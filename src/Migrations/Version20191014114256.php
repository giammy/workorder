<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014114256 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__workslist AS SELECT id, activity_code_prefix, activity_code_suffix, description, workorder, responsible, deputy, valid_from, valid_to, last_change_author, last_change_date, internal_note FROM workslist');
        $this->addSql('DROP TABLE workslist');
        $this->addSql('CREATE TABLE workslist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, activity_code_prefix VARCHAR(255) NOT NULL COLLATE BINARY, activity_code_suffix VARCHAR(255) NOT NULL COLLATE BINARY, description VARCHAR(1024) DEFAULT NULL COLLATE BINARY, workorder VARCHAR(255) NOT NULL COLLATE BINARY, responsible VARCHAR(255) NOT NULL COLLATE BINARY, deputy VARCHAR(255) DEFAULT NULL COLLATE BINARY, last_change_author VARCHAR(255) NOT NULL COLLATE BINARY, internal_note VARCHAR(1024) DEFAULT NULL COLLATE BINARY, valid_from DATETIME NOT NULL, valid_to DATETIME DEFAULT NULL, last_change_date DATETIME NOT NULL, version VARCHAR(255) NOT NULL, created DATETIME NOT NULL, is_an_old_copy BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO workslist (id, activity_code_prefix, activity_code_suffix, description, workorder, responsible, deputy, valid_from, valid_to, last_change_author, last_change_date, internal_note) SELECT id, activity_code_prefix, activity_code_suffix, description, workorder, responsible, deputy, valid_from, valid_to, last_change_author, last_change_date, internal_note FROM __temp__workslist');
        $this->addSql('DROP TABLE __temp__workslist');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__workslist AS SELECT id, activity_code_prefix, activity_code_suffix, description, workorder, responsible, deputy, valid_from, valid_to, last_change_author, last_change_date, internal_note FROM workslist');
        $this->addSql('DROP TABLE workslist');
        $this->addSql('CREATE TABLE workslist (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, activity_code_prefix VARCHAR(255) NOT NULL, activity_code_suffix VARCHAR(255) NOT NULL, description VARCHAR(1024) DEFAULT NULL, workorder VARCHAR(255) NOT NULL, responsible VARCHAR(255) NOT NULL, deputy VARCHAR(255) DEFAULT NULL, last_change_author VARCHAR(255) NOT NULL, internal_note VARCHAR(1024) DEFAULT NULL, valid_from DATETIME NOT NULL, valid_to DATETIME DEFAULT NULL, last_change_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO workslist (id, activity_code_prefix, activity_code_suffix, description, workorder, responsible, deputy, valid_from, valid_to, last_change_author, last_change_date, internal_note) SELECT id, activity_code_prefix, activity_code_suffix, description, workorder, responsible, deputy, valid_from, valid_to, last_change_author, last_change_date, internal_note FROM __temp__workslist');
        $this->addSql('DROP TABLE __temp__workslist');
    }
}
