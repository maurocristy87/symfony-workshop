<?php

declare(strict_types=1);

namespace Tests\Extension;

use Codeception\Events;
use Codeception\Extension;
use Codeception\Event\SuiteEvent;

class LoadFixturesExtension  extends Extension
{
    private \Doctrine\DBAL\Connection $dbal;
            
    public static $events = [
        Events::SUITE_BEFORE  => 'beforeSuite'
    ];
    
    public function beforeSuite(SuiteEvent $event): void
    {
        $this->dbal = $this->getModule('Symfony')->grabService('doctrine.dbal.default_connection');
        
        $this->writeln('Loading fixtures...');
        
        $fixtureFilenames = [
            'fixtures.users.json',
            'fixtures.categories.json'
        ];
        
        $this->dbal->query('SET FOREIGN_KEY_CHECKS = 0');
        
        foreach ($fixtureFilenames as $filename) {
            $this->loadFixtutres($filename);
        }
        
        $this->dbal->query('SET FOREIGN_KEY_CHECKS = 1');
        
        $this->writeln('Fixtures loaded!');
    }
    
    private function loadFixtutres(string $filename): void
    {
        $fixtures = \json_decode(file_get_contents(__DIR__ . '/../../_data/' . $filename), true);
        
        foreach ($fixtures as $table => $rows) {
            foreach ($rows as $row) {
                $this->dbal->insert($table, $row);
            }
        }
    }
}
