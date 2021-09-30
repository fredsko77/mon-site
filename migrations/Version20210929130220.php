<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929130220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_comment DROP FOREIGN KEY FK_98B80B3E700047D2');
        $this->addSql('ALTER TABLE ticket_document DROP FOREIGN KEY FK_5D0076F7700047D2');
        $this->addSql('ALTER TABLE ticket_comment_document DROP FOREIGN KEY FK_AF9F5DE9700047D2');
        $this->addSql('DROP TABLE resume');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_comment');
        $this->addSql('DROP TABLE ticket_comment_document');
        $this->addSql('DROP TABLE ticket_document');
        $this->addSql('DROP TABLE user_image');
        $this->addSql('ALTER TABLE contact ADD telephone VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE group_skill DROP FOREIGN KEY FK_E11CF10A76ED395');
        $this->addSql('DROP INDEX IDX_E11CF10A76ED395 ON group_skill');
        $this->addSql('ALTER TABLE group_skill DROP user_id');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEA76ED395');
        $this->addSql('DROP INDEX IDX_2FB3D0EEA76ED395 ON project');
        $this->addSql('ALTER TABLE project DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64984A0A3ED');
        $this->addSql('DROP INDEX UNIQ_8D93D64984A0A3ED ON user');
        $this->addSql('ALTER TABLE user DROP content_id, DROP confirm, DROP gender, DROP slug');
        $this->addSql('ALTER TABLE user_social DROP FOREIGN KEY FK_1433FABAA76ED395');
        $this->addSql('DROP INDEX IDX_1433FABAA76ED395 ON user_social');
        $this->addSql('ALTER TABLE user_social DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE resume (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, ref VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_main TINYINT(1) DEFAULT NULL, INDEX IDX_60C1D0A0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, state VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ref VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, priority VARCHAR(20) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, estimation DOUBLE PRECISION DEFAULT NULL, INDEX IDX_97A0ADA3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ticket_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, ticket_id INT DEFAULT NULL, comment LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, INDEX IDX_98B80B3EA76ED395 (user_id), INDEX IDX_98B80B3E700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ticket_comment_document (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, original_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_AF9F5DE9700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ticket_document (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, original_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_5D0076F7700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user_image (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, path VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, original_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, ref VARCHAR(150) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_main TINYINT(1) DEFAULT NULL, INDEX IDX_27FFFF07A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE resume ADD CONSTRAINT FK_60C1D0A0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_comment ADD CONSTRAINT FK_98B80B3E700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket_comment ADD CONSTRAINT FK_98B80B3EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_comment_document ADD CONSTRAINT FK_AF9F5DE9700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket_comment (id)');
        $this->addSql('ALTER TABLE ticket_document ADD CONSTRAINT FK_5D0076F7700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE user_image ADD CONSTRAINT FK_27FFFF07A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contact DROP telephone');
        $this->addSql('ALTER TABLE group_skill ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE group_skill ADD CONSTRAINT FK_E11CF10A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E11CF10A76ED395 ON group_skill (user_id)');
        $this->addSql('ALTER TABLE project ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEA76ED395 ON project (user_id)');
        $this->addSql('ALTER TABLE user ADD content_id INT DEFAULT NULL, ADD confirm TINYINT(1) DEFAULT NULL, ADD gender VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD slug VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64984A0A3ED FOREIGN KEY (content_id) REFERENCES content (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64984A0A3ED ON user (content_id)');
        $this->addSql('ALTER TABLE user_social ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_social ADD CONSTRAINT FK_1433FABAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1433FABAA76ED395 ON user_social (user_id)');
    }
}
