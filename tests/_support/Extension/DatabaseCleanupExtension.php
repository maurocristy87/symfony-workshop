<?php

declare(strict_types=1);

namespace Tests\Extension;

use Codeception\Events;
use Codeception\Extension;
use Codeception\Event\SuiteEvent;


class DatabaseCleanupExtension extends Extension
{
    public static $events = [
        Events::SUITE_BEFORE => 'beforeSuit'
    ];
    
    public function beforeSuit(SuiteEvent $event): void
    {
        $cli = $this->getModule('Cli');
        
        $this->writeln('Running Doctrine Migrations...');
        $cli->runShellCommand('bin/console doctrine:migrations:migrate --no-interaction --env=test');
        $cli->seeResultCodeIs(0);
        
        $this->writeln('Cleaning database tables...');
        $dbal = $this->getModule('Symfony')->grabService('doctrine.dbal.default_connection');
        $tables = $dbal->fetchAll('SHOW TABLES');
        $dbal->query('SET FOREIGN_KEY_CHECKS = 0');
        foreach ($tables as $table) {
            $tableName = current($table);
            if ($tableName !== 'doctrine_migration_versions') {
                $dbal->executeQuery(sprintf('TRUNCATE %s', $tableName));
            }
        }
        $dbal->query('SET FOREIGN_KEY_CHECKS = 1');
        
        $this->writeln('Test database ready!');
    }
}
