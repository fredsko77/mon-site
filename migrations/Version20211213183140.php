<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213183140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE group_skil (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, icon VARCHAR(20) NOT NULL, color VARCHAR(20) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE skill ADD group_skill_id INT DEFAULT NULL, DROP icon, DROP color, DROP skills, DROP created_at, DROP updated_at, CHANGE name name VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4775CB58D3D FOREIGN KEY (group_skill_id) REFERENCES group_skil (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE4775CB58D3D ON skill (group_skill_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4775CB58D3D');
        $this->addSql('DROP TABLE group_skil');
        $this->addSql('DROP INDEX IDX_5E3DE4775CB58D3D ON skill');
        $this->addSql('ALTER TABLE skill ADD icon VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD color VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD skills LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP group_skill_id, CHANGE name name VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
