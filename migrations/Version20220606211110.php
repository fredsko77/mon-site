<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220606211110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, shelf_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, visibility VARCHAR(20) NOT NULL, INDEX IDX_CBE5A3317C12FBC0 (shelf_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chapter (id INT AUTO_INCREMENT NOT NULL, book_id INT DEFAULT NULL, parent_chapter_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, visibility VARCHAR(20) NOT NULL, INDEX IDX_F981B52E16A2B381 (book_id), INDEX IDX_F981B52E10DCC338 (parent_chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, fullname VARCHAR(100) NOT NULL, about VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_at DATETIME NOT NULL, state VARCHAR(20) NOT NULL, telephone VARCHAR(15) DEFAULT NULL, email VARCHAR(255) NOT NULL, company_name VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, replied_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_extension (id INT AUTO_INCREMENT NOT NULL, file_type_id INT DEFAULT NULL, extension VARCHAR(60) NOT NULL, icon VARCHAR(30) DEFAULT NULL, has_icon TINYINT(1) DEFAULT 0, INDEX IDX_11B882019E2A35A8 (file_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(60) NOT NULL, icon VARCHAR(60) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, icon VARCHAR(20) DEFAULT NULL, color VARCHAR(20) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, book_id INT DEFAULT NULL, chapter_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, sources LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', visibility VARCHAR(20) NOT NULL, state VARCHAR(20) DEFAULT NULL, INDEX IDX_140AB62016A2B381 (book_id), INDEX IDX_140AB620579F4768 (chapter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(150) NOT NULL, link VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, state VARCHAR(20) DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, visibility VARCHAR(15) DEFAULT NULL, tasks LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\', image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_stack (project_id INT NOT NULL, stack_id INT NOT NULL, INDEX IDX_52FD72F4166D1F9C (project_id), INDEX IDX_52FD72F437C70060 (stack_id), PRIMARY KEY(project_id, stack_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shelf (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, visibility VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, group_skill_id INT DEFAULT NULL, name VARCHAR(30) NOT NULL, INDEX IDX_5E3DE4775CB58D3D (group_skill_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(30) NOT NULL, link VARCHAR(255) NOT NULL, icon VARCHAR(50) DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stack (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(100) DEFAULT NULL, firstname VARCHAR(100) DEFAULT NULL, lastname VARCHAR(100) DEFAULT NULL, token VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, confirm TINYINT(1) DEFAULT NULL, slug VARCHAR(255) DEFAULT NULL, biography LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), FULLTEXT INDEX IDX_8D93D64983A00E683124B5B6F85E0677E7927C74989D9B62 (firstname, lastname, username, email, slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3317C12FBC0 FOREIGN KEY (shelf_id) REFERENCES shelf (id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE chapter ADD CONSTRAINT FK_F981B52E10DCC338 FOREIGN KEY (parent_chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE file_extension ADD CONSTRAINT FK_11B882019E2A35A8 FOREIGN KEY (file_type_id) REFERENCES file_type (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB62016A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620579F4768 FOREIGN KEY (chapter_id) REFERENCES chapter (id)');
        $this->addSql('ALTER TABLE project_stack ADD CONSTRAINT FK_52FD72F4166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE project_stack ADD CONSTRAINT FK_52FD72F437C70060 FOREIGN KEY (stack_id) REFERENCES stack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE skill ADD CONSTRAINT FK_5E3DE4775CB58D3D FOREIGN KEY (group_skill_id) REFERENCES group_skill (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E16A2B381');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB62016A2B381');
        $this->addSql('ALTER TABLE chapter DROP FOREIGN KEY FK_F981B52E10DCC338');
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620579F4768');
        $this->addSql('ALTER TABLE file_extension DROP FOREIGN KEY FK_11B882019E2A35A8');
        $this->addSql('ALTER TABLE skill DROP FOREIGN KEY FK_5E3DE4775CB58D3D');
        $this->addSql('ALTER TABLE project_stack DROP FOREIGN KEY FK_52FD72F4166D1F9C');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3317C12FBC0');
        $this->addSql('ALTER TABLE project_stack DROP FOREIGN KEY FK_52FD72F437C70060');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE chapter');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE file_extension');
        $this->addSql('DROP TABLE file_type');
        $this->addSql('DROP TABLE group_skill');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_stack');
        $this->addSql('DROP TABLE shelf');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE social');
        $this->addSql('DROP TABLE stack');
        $this->addSql('DROP TABLE `user`');
    }
}
