<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210924230612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, about VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, state VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, heading_primary LONGTEXT NOT NULL, heading_secondary LONGTEXT DEFAULT NULL, biography_blocs LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', footing_primary LONGTEXT DEFAULT NULL, footing_secondary LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, state VARCHAR(20) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_FEC530A9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_skill (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(60) NOT NULL, description LONGTEXT DEFAULT NULL, icon VARCHAR(40) DEFAULT NULL, INDEX IDX_E11CF10A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(150) NOT NULL, link VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, state VARCHAR(15) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_2FB3D0EEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_image (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, is_main TINYINT(1) DEFAULT NULL, ref VARCHAR(150) NOT NULL, INDEX IDX_D6680DC1166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_task (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_6BEF133D166D1F9C (project_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resume (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, ref VARCHAR(150) NOT NULL, is_main TINYINT(1) DEFAULT NULL, INDEX IDX_60C1D0A0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, groups_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, level INT NOT NULL, INDEX IDX_5E3DE477F373DCF (groups_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, state VARCHAR(50) NOT NULL, ref VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, priority VARCHAR(20) DEFAULT NULL, estimation DOUBLE PRECISION DEFAULT NULL, INDEX IDX_97A0ADA3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, ticket_id INT DEFAULT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_98B80B3EA76ED395 (user_id), INDEX IDX_98B80B3E700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_comment_document (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, original_name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_AF9F5DE9700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_document (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, INDEX IDX_5D0076F7700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(100) DEFAULT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, token VARCHAR(255) DEFAULT NULL, confirm TINYINT(1) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, telephone VARCHAR(20) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_image (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, ref VARCHAR(150) NOT NULL, is_main TINYINT(1) DEFAULT NULL, INDEX IDX_27FFFF07A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_social (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_1433FABAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE group_skill ADD CONSTRAINT FK_E11CF10A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE project_image ADD CONSTRAINT FK_D6680DC1166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE project_task ADD CONSTRAINT FK_6BEF133D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT FK_60C1D0A0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE477F373DCF FOREIGN KEY (groups_id) REFERENCES group_skill (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_comment ADD CONSTRAINT FK_98B80B3EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_comment ADD CONSTRAINT FK_98B80B3E700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket_comment_document ADD CONSTRAINT FK_AF9F5DE9700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket_comment (id)');
        $this->addSql('ALTER TABLE ticket_document ADD CONSTRAINT FK_5D0076F7700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE user_image ADD CONSTRAINT FK_27FFFF07A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_social ADD CONSTRAINT FK_1433FABAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE477F373DCF');
        $this->addSql('ALTER TABLE project_image DROP FOREIGN KEY FK_D6680DC1166D1F9C');
        $this->addSql('ALTER TABLE project_task DROP FOREIGN KEY FK_6BEF133D166D1F9C');
        $this->addSql('ALTER TABLE ticket_comment DROP FOREIGN KEY FK_98B80B3E700047D2');
        $this->addSql('ALTER TABLE ticket_document DROP FOREIGN KEY FK_5D0076F7700047D2');
        $this->addSql('ALTER TABLE ticket_comment_document DROP FOREIGN KEY FK_AF9F5DE9700047D2');
        $this->addSql('ALTER TABLE content DROP FOREIGN KEY FK_FEC530A9A76ED395');
        $this->addSql('ALTER TABLE group_skill DROP FOREIGN KEY FK_E11CF10A76ED395');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('ALTER TABLE resume DROP FOREIGN KEY FK_60C1D0A0A76ED395');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3A76ED395');
        $this->addSql('ALTER TABLE ticket_comment DROP FOREIGN KEY FK_98B80B3EA76ED395');
        $this->addSql('ALTER TABLE user_image DROP FOREIGN KEY FK_27FFFF07A76ED395');
        $this->addSql('ALTER TABLE user_social DROP FOREIGN KEY FK_1433FABAA76ED395');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE group_skill');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_image');
        $this->addSql('DROP TABLE project_task');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_comment');
        $this->addSql('DROP TABLE ticket_comment_document');
        $this->addSql('DROP TABLE ticket_document');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_image');
        $this->addSql('DROP TABLE user_social');
    }
}
