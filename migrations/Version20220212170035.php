<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220212170035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE artist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE artwork_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE classification_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE dating_artwork_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE localisation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE artist (id INT NOT NULL, display_name VARCHAR(255) DEFAULT NULL, display_bio TEXT DEFAULT NULL, begin_date VARCHAR(255) DEFAULT NULL, end_date VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) DEFAULT NULL, nationality VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE artwork (id INT NOT NULL, classification_id INT DEFAULT NULL, dating_artwork_id INT DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) DEFAULT NULL, dimensions VARCHAR(255) DEFAULT NULL, medium VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_881FC5762A86559F ON artwork (classification_id)');
        $this->addSql('CREATE INDEX IDX_881FC5765D2BBF95 ON artwork (dating_artwork_id)');
        $this->addSql('CREATE TABLE artwork_artist (artwork_id INT NOT NULL, artist_id INT NOT NULL, PRIMARY KEY(artwork_id, artist_id))');
        $this->addSql('CREATE INDEX IDX_FCAA8595DB8FFA4 ON artwork_artist (artwork_id)');
        $this->addSql('CREATE INDEX IDX_FCAA8595B7970CF8 ON artwork_artist (artist_id)');
        $this->addSql('CREATE TABLE classification (id INT NOT NULL, classification VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE dating_artwork (id INT NOT NULL, object_date VARCHAR(255) DEFAULT NULL, object_begin_date INT DEFAULT NULL, object_end_date INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE localisation (id INT NOT NULL, culture VARCHAR(255) DEFAULT NULL, period VARCHAR(255) DEFAULT NULL, dynasty VARCHAR(255) DEFAULT NULL, reign VARCHAR(255) DEFAULT NULL, region VARCHAR(255) DEFAULT NULL, subregion VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, county VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) DEFAULT NULL, locus VARCHAR(255) DEFAULT NULL, river VARCHAR(255) DEFAULT NULL, excavation VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC5762A86559F FOREIGN KEY (classification_id) REFERENCES classification (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC5765D2BBF95 FOREIGN KEY (dating_artwork_id) REFERENCES dating_artwork (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artwork_artist ADD CONSTRAINT FK_FCAA8595DB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE artwork_artist ADD CONSTRAINT FK_FCAA8595B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE artwork_artist DROP CONSTRAINT FK_FCAA8595B7970CF8');
        $this->addSql('ALTER TABLE artwork_artist DROP CONSTRAINT FK_FCAA8595DB8FFA4');
        $this->addSql('ALTER TABLE artwork DROP CONSTRAINT FK_881FC5762A86559F');
        $this->addSql('ALTER TABLE artwork DROP CONSTRAINT FK_881FC5765D2BBF95');
        $this->addSql('DROP SEQUENCE artist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE artwork_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE classification_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE dating_artwork_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE localisation_id_seq CASCADE');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('DROP TABLE artwork_artist');
        $this->addSql('DROP TABLE classification');
        $this->addSql('DROP TABLE dating_artwork');
        $this->addSql('DROP TABLE localisation');
    }
}
