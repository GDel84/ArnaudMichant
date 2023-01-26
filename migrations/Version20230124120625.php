<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230124120625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule ADD COLUMN noon_start_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE schedule ADD COLUMN noon_end_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE schedule ADD COLUMN night_start_time TIME DEFAULT NULL');
        $this->addSql('ALTER TABLE schedule ADD COLUMN night_end_time TIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__schedule AS SELECT id, week, schedule_moon, schedule_night FROM schedule');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('CREATE TABLE schedule (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, week VARCHAR(255) DEFAULT NULL, schedule_moon CLOB DEFAULT NULL, schedule_night CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO schedule (id, week, schedule_moon, schedule_night) SELECT id, week, schedule_moon, schedule_night FROM __temp__schedule');
        $this->addSql('DROP TABLE __temp__schedule');
    }
}
