<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129150820 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, shelf_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, visibility VARCHAR(20) NOT NULL, INDEX IDX_CBE5A3317C12FBC0 (shelf_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapter (id INT AUTO_INCREMENT NOT NULL, book_id INT DEFAULT NULL, parent_chapter_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, crated_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, visibility VARCHAR(20) NOT NULL, INDEX IDX_F981B52E16A2B381 (book_id), INDEX IDX_F981B52E10DCC338 (parent_chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, book_id INT DEFAULT NULL, chapter_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, sources LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', visibility VARCHAR(20) NOT NULL, INDEX IDX_140AB62016A2B381 (book_id), INDEX IDX_140AB620579F4768 (chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shelf (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, visibility VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3317C12FBC0 FOREIGN KEY (shelf_id) REFERENCES shelf (id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E10DCC338 FOREIGN KEY (parent_chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62016A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E16A2B381');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62016A2B381');
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E10DCC338');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620579F4768');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3317C12FBC0');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE shelf');
    }
}
