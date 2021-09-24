<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210924200411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE group_skill (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(60) NOT NULL, description LONGTEXT DEFAULT NULL, icon VARCHAR(40) DEFAULT NULL, INDEX IDX_E11CF10A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE group_skill ADD CONSTRAINT FK_E11CF10A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE content_bloc');
        $this->addSql('ALTER TABLE contact CHANGE status state VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE content DROP INDEX IDX_FEC530A9A76ED395, ADD UNIQUE INDEX UNIQ_FEC530A9A76ED395 (user_id)');
        $this->addSql('ALTER TABLE content ADD heading_primary LONGTEXT NOT NULL, ADD heading_secondary LONGTEXT DEFAULT NULL, ADD biography_blocs LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', ADD footing_primary LONGTEXT DEFAULT NULL, ADD footing_secondary LONGTEXT DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL, ADD state VARCHAR(20) DEFAULT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP name');
        $this->addSql('ALTER TABLE project CHANGE status state VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477A76ED395');
        $this->addSql('DROP INDEX IDX_5E3DE477A76ED395 ON skill');
        $this->addSql('ALTER TABLE skill CHANGE user_id groups_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477F373DCF FOREIGN KEY (groups_id) REFERENCES group_skill (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477F373DCF ON skill (groups_id)');
        $this->addSql('ALTER TABLE ticket CHANGE status state VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477F373DCF');
        $this->addSql('CREATE TABLE content_bloc (id INT AUTO_INCREMENT NOT NULL, content_id INT DEFAULT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, text LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_A1A789F84A0A3ED (content_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE content_bloc ADD CONSTRAINT FK_A1A789F84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('DROP TABLE group_skill');
        $this->addSql('ALTER TABLE contact CHANGE state status VARCHAR(10) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE content DROP INDEX UNIQ_FEC530A9A76ED395, ADD INDEX IDX_FEC530A9A76ED395 (user_id)');
        $this->addSql('ALTER TABLE content ADD name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP heading_primary, DROP heading_secondary, DROP biography_blocs, DROP footing_primary, DROP footing_secondary, DROP image, DROP state, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE project CHANGE state status VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX IDX_5E3DE477F373DCF ON skill');
        $this->addSql('ALTER TABLE skill CHANGE groups_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5E3DE477A76ED395 ON skill (user_id)');
        $this->addSql('ALTER TABLE ticket CHANGE state status VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
