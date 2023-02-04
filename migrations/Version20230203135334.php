<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230203135334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__schedule AS SELECT id, week, noon_start_time, noon_end_time, night_start_time, night_end_time FROM schedule');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('CREATE TABLE schedule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, week VARCHAR(255) DEFAULT NULL, noon_start_time TIME DEFAULT NULL --(DC2Type:time_immutable)
        , noon_end_time TIME DEFAULT NULL --(DC2Type:time_immutable)
        , night_start_time TIME DEFAULT NULL --(DC2Type:time_immutable)
        , night_end_time TIME DEFAULT NULL --(DC2Type:time_immutable)
        )');
        $this->addSql('INSERT INTO schedule (id, week, noon_start_time, noon_end_time, night_start_time, night_end_time) SELECT id, week, noon_start_time, noon_end_time, night_start_time, night_end_time FROM __temp__schedule');
        $this->addSql('DROP TABLE __temp__schedule');
        $this->addSql('ALTER TABLE user ADD COLUMN first_name VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__schedule AS SELECT id, week, noon_start_time, noon_end_time, night_start_time, night_end_time FROM schedule');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('CREATE TABLE schedule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, week VARCHAR(255) DEFAULT NULL, noon_start_time TIME DEFAULT NULL, noon_end_time TIME DEFAULT NULL, night_start_time TIME DEFAULT NULL, night_end_time TIME DEFAULT NULL, schedule_moon CLOB DEFAULT NULL, schedule_night CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO schedule (id, week, noon_start_time, noon_end_time, night_start_time, night_end_time) SELECT id, week, noon_start_time, noon_end_time, night_start_time, night_end_time FROM __temp__schedule');
        $this->addSql('DROP TABLE __temp__schedule');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, name, mentions_allergene, nb_couverts FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, mentions_allergene VARCHAR(255) DEFAULT NULL, nb_couverts INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, name, mentions_allergene, nb_couverts) SELECT id, email, roles, password, name, mentions_allergene, nb_couverts FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
