<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201028144910 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, uuid VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D34A04ADA76ED395 (user_id), INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_attribute (id INT AUTO_INCREMENT NOT NULL, attribute_id INT NOT NULL, product_id INT NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_94DA5976B6E62EFA (attribute_id), INDEX IDX_94DA59764584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, status INT NOT NULL, total NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6117D13BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_product (id INT AUTO_INCREMENT NOT NULL, purchase_id INT NOT NULL, product_id INT NOT NULL, amount INT NOT NULL, unit_price NUMERIC(10, 2) NOT NULL, INDEX IDX_C890CED4558FBEB9 (purchase_id), INDEX IDX_C890CED44584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA5976B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA59764584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE purchase_product ADD CONSTRAINT FK_C890CED4558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id)');
        $this->addSql('ALTER TABLE purchase_product ADD CONSTRAINT FK_C890CED44584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA5976B6E62EFA');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA59764584665A');
        $this->addSql('ALTER TABLE purchase_product DROP FOREIGN KEY FK_C890CED44584665A');
        $this->addSql('ALTER TABLE purchase_product DROP FOREIGN KEY FK_C890CED4558FBEB9');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_attribute');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE purchase_product');
    }
}
