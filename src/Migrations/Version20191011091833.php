<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191011091833 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE workslist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, activity_code_prefix VARCHAR(255) NOT NULL, activity_code_suffix VARCHAR(255) NOT NULL, description VARCHAR(1024) DEFAULT NULL, workorder VARCHAR(255) NOT NULL, responsible VARCHAR(255) NOT NULL, deputy VARCHAR(255) DEFAULT NULL, valid_from DATETIME NOT NULL, valid_to DATETIME DEFAULT NULL, last_change_author VARCHAR(255) NOT NULL, last_change_date DATETIME NOT NULL, internal_note VARCHAR(1024) DEFAULT NULL)');
        $this->addSql('CREATE TABLE workorder (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE activity_code (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL, responsible VARCHAR(255) NOT NULL)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE workslist');
        $this->addSql('DROP TABLE workorder');
        $this->addSql('DROP TABLE activity_code');
    }
}
