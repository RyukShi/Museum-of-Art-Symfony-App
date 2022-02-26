<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220226192633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE artist (id SERIAL NOT NULL, display_name VARCHAR(5000) DEFAULT NULL, begin_date VARCHAR(5000) DEFAULT NULL, end_date VARCHAR(5000) DEFAULT NULL, gender VARCHAR(5000) DEFAULT NULL, nationality VARCHAR(5000) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE artwork (id SERIAL NOT NULL, classification_id INT DEFAULT NULL, dating_artwork_id INT DEFAULT NULL, artist_id INT DEFAULT NULL, localisation_id INT DEFAULT NULL, number TEXT DEFAULT NULL, name TEXT DEFAULT NULL, title TEXT DEFAULT NULL, dimensions TEXT DEFAULT NULL, medium TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_881FC5762A86559F ON artwork (classification_id)');
        $this->addSql('CREATE INDEX IDX_881FC5765D2BBF95 ON artwork (dating_artwork_id)');
        $this->addSql('CREATE INDEX IDX_881FC576B7970CF8 ON artwork (artist_id)');
        $this->addSql('CREATE INDEX IDX_881FC576C68BE09C ON artwork (localisation_id)');
        $this->addSql('CREATE TABLE classification (id SERIAL NOT NULL, classification VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE dating_artwork (id SERIAL NOT NULL, object_begin_date INT DEFAULT NULL, object_end_date INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE localisation (id SERIAL NOT NULL, culture VARCHAR(255) DEFAULT NULL, period VARCHAR(255) DEFAULT NULL, dynasty VARCHAR(255) DEFAULT NULL, reign VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, subregion VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, county VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) DEFAULT NULL, locus VARCHAR(255) DEFAULT NULL, river VARCHAR(255) DEFAULT NULL, excavation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC5762A86559F FOREIGN KEY (classification_id) REFERENCES classification (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC5765D2BBF95 FOREIGN KEY (dating_artwork_id) REFERENCES dating_artwork (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE artwork DROP CONSTRAINT FK_881FC576B7970CF8');
        $this->addSql('ALTER TABLE artwork DROP CONSTRAINT FK_881FC5762A86559F');
        $this->addSql('ALTER TABLE artwork DROP CONSTRAINT FK_881FC5765D2BBF95');
        $this->addSql('ALTER TABLE artwork DROP CONSTRAINT FK_881FC576C68BE09C');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('DROP TABLE classification');
        $this->addSql('DROP TABLE dating_artwork');
        $this->addSql('DROP TABLE localisation');
    }
}
