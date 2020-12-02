<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201120143711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO `attribute` (`id`, `name`) VALUES (NULL, 'Talle'), (NULL, 'Color')");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DELETE FROM `attribute`');
    }
}
