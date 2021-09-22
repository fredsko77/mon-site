<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210922013016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, status VARCHAR(50) NOT NULL, ref VARCHAR(150) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, priority VARCHAR(20) DEFAULT NULL, estimation DOUBLE PRECISION DEFAULT NULL, INDEX IDX_97A0ADA3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_comment (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, ticket_id INT DEFAULT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_98B80B3EA76ED395 (user_id), INDEX IDX_98B80B3E700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_comment_document (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, original_name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_AF9F5DE9700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_document (id INT AUTO_INCREMENT NOT NULL, ticket_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, INDEX IDX_5D0076F7700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_social (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(50) NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_1433FABAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_comment ADD CONSTRAINT FK_98B80B3EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_comment ADD CONSTRAINT FK_98B80B3E700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE ticket_comment_document ADD CONSTRAINT FK_AF9F5DE9700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket_comment (id)');
        $this->addSql('ALTER TABLE ticket_document ADD CONSTRAINT FK_5D0076F7700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket (id)');
        $this->addSql('ALTER TABLE user_social ADD CONSTRAINT FK_1433FABAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_comment DROP FOREIGN KEY FK_98B80B3E700047D2');
        $this->addSql('ALTER TABLE ticket_document DROP FOREIGN KEY FK_5D0076F7700047D2');
        $this->addSql('ALTER TABLE ticket_comment_document DROP FOREIGN KEY FK_AF9F5DE9700047D2');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_comment');
        $this->addSql('DROP TABLE ticket_comment_document');
        $this->addSql('DROP TABLE ticket_document');
        $this->addSql('DROP TABLE user_social');
    }
}
