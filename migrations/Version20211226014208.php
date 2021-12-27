<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211226014208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_skill CHANGE icon icon VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE project ADD stacks_id INT DEFAULT NULL, CHANGE stack tasks LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEAAF41B7D FOREIGN KEY (stacks_id) REFERENCES stack (id)');
        $this->addSql('CREATE INDEX IDX_2FB3D0EEAAF41B7D ON project (stacks_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE group_skill CHANGE icon icon VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEAAF41B7D');
        $this->addSql('DROP INDEX IDX_2FB3D0EEAAF41B7D ON project');
        $this->addSql('ALTER TABLE project DROP stacks_id, CHANGE tasks stack LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\'');
    }
}
