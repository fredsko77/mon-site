<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211011001507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477F373DCF');
        $this->addSql('DROP TABLE group_skill');
        $this->addSql('DROP INDEX IDX_5E3DE477F373DCF ON skill');
        $this->addSql('ALTER TABLE skill ADD icon VARCHAR(30) DEFAULT NULL, ADD color VARCHAR(30) DEFAULT NULL, ADD skills LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP groups_id, DROP level, CHANGE name name VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE group_skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, icon VARCHAR(40) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE skill ADD groups_id INT DEFAULT NULL, ADD level INT NOT NULL, DROP icon, DROP color, DROP skills, DROP created_at, DROP updated_at, CHANGE name name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477F373DCF FOREIGN KEY (groups_id) REFERENCES group_skill (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477F373DCF ON skill (groups_id)');
    }
}
