<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191125000106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_9474526C54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, room_id, firstname, family_name, content, accepted FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, family_name VARCHAR(255) NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, accepted BOOLEAN NOT NULL, CONSTRAINT FK_9474526C54177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO comment (id, room_id, firstname, family_name, content, accepted) SELECT id, room_id, firstname, family_name, content, accepted FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C54177093 ON comment (room_id)');
        $this->addSql('DROP INDEX IDX_E00CEDDE54177093');
        $this->addSql('DROP INDEX IDX_E00CEDDE19EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, client_id, room_id, starting_on, ending_on, price FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER NOT NULL, room_id INTEGER NOT NULL, starting_on DATE NOT NULL, ending_on DATE NOT NULL, price DOUBLE PRECISION NOT NULL, confirmed BOOLEAN NOT NULL, CONSTRAINT FK_E00CEDDE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E00CEDDE54177093 FOREIGN KEY (room_id) REFERENCES room (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO booking (id, client_id, room_id, starting_on, ending_on, price) SELECT id, client_id, room_id, starting_on, ending_on, price FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE54177093 ON booking (room_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE19EB6921 ON booking (client_id)');
        $this->addSql('DROP INDEX UNIQ_C7440455A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, user_id, firstname, family_name, country FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, family_name VARCHAR(255) NOT NULL COLLATE BINARY, country VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO client (id, user_id, firstname, family_name, country) SELECT id, user_id, firstname, family_name, country FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455A76ED395 ON client (user_id)');
        $this->addSql('DROP INDEX UNIQ_CF60E67CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__owner AS SELECT id, user_id, firstname, family_name, address, country FROM owner');
        $this->addSql('DROP TABLE owner');
        $this->addSql('CREATE TABLE owner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, firstname VARCHAR(255) DEFAULT NULL COLLATE BINARY, family_name VARCHAR(255) NOT NULL COLLATE BINARY, address CLOB DEFAULT NULL COLLATE BINARY, country VARCHAR(2) NOT NULL COLLATE BINARY, CONSTRAINT FK_CF60E67CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO owner (id, user_id, firstname, family_name, address, country) SELECT id, user_id, firstname, family_name, address, country FROM __temp__owner');
        $this->addSql('DROP TABLE __temp__owner');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF60E67CA76ED395 ON owner (user_id)');
        $this->addSql('DROP INDEX IDX_729F519B7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, owner_id, summary, description, capacity, superficy, price, address, image_name, image_updated_at, content_type FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, summary CLOB NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, capacity INTEGER NOT NULL, superficy DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, address CLOB NOT NULL COLLATE BINARY, image_name VARCHAR(255) DEFAULT NULL COLLATE BINARY, image_updated_at DATETIME DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_729F519B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room (id, owner_id, summary, description, capacity, superficy, price, address, image_name, image_updated_at, content_type) SELECT id, owner_id, summary, description, capacity, superficy, price, address, image_name, image_updated_at, content_type FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B7E3C61F9 ON room (owner_id)');
        $this->addSql('DROP INDEX IDX_4E2C37B754177093');
        $this->addSql('DROP INDEX IDX_4E2C37B798260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_region AS SELECT room_id, region_id FROM room_region');
        $this->addSql('DROP TABLE room_region');
        $this->addSql('CREATE TABLE room_region (room_id INTEGER NOT NULL, region_id INTEGER NOT NULL, PRIMARY KEY(room_id, region_id), CONSTRAINT FK_4E2C37B754177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4E2C37B798260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room_region (room_id, region_id) SELECT room_id, region_id FROM __temp__room_region');
        $this->addSql('DROP TABLE __temp__room_region');
        $this->addSql('CREATE INDEX IDX_4E2C37B754177093 ON room_region (room_id)');
        $this->addSql('CREATE INDEX IDX_4E2C37B798260155 ON room_region (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_E00CEDDE19EB6921');
        $this->addSql('DROP INDEX IDX_E00CEDDE54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__booking AS SELECT id, client_id, room_id, starting_on, ending_on, price FROM booking');
        $this->addSql('DROP TABLE booking');
        $this->addSql('CREATE TABLE booking (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER NOT NULL, room_id INTEGER NOT NULL, starting_on DATE NOT NULL, ending_on DATE NOT NULL, price DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO booking (id, client_id, room_id, starting_on, ending_on, price) SELECT id, client_id, room_id, starting_on, ending_on, price FROM __temp__booking');
        $this->addSql('DROP TABLE __temp__booking');
        $this->addSql('CREATE INDEX IDX_E00CEDDE19EB6921 ON booking (client_id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDE54177093 ON booking (room_id)');
        $this->addSql('DROP INDEX UNIQ_C7440455A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, user_id, firstname, family_name, country FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL, family_name VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO client (id, user_id, firstname, family_name, country) SELECT id, user_id, firstname, family_name, country FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455A76ED395 ON client (user_id)');
        $this->addSql('DROP INDEX IDX_9474526C54177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__comment AS SELECT id, room_id, firstname, family_name, content, accepted FROM comment');
        $this->addSql('DROP TABLE comment');
        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER NOT NULL, firstname VARCHAR(255) NOT NULL, family_name VARCHAR(255) NOT NULL, content CLOB NOT NULL, accepted BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO comment (id, room_id, firstname, family_name, content, accepted) SELECT id, room_id, firstname, family_name, content, accepted FROM __temp__comment');
        $this->addSql('DROP TABLE __temp__comment');
        $this->addSql('CREATE INDEX IDX_9474526C54177093 ON comment (room_id)');
        $this->addSql('DROP INDEX UNIQ_CF60E67CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__owner AS SELECT id, user_id, firstname, family_name, address, country FROM owner');
        $this->addSql('DROP TABLE owner');
        $this->addSql('CREATE TABLE owner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, firstname VARCHAR(255) DEFAULT NULL, family_name VARCHAR(255) NOT NULL, address CLOB DEFAULT NULL, country VARCHAR(2) NOT NULL)');
        $this->addSql('INSERT INTO owner (id, user_id, firstname, family_name, address, country) SELECT id, user_id, firstname, family_name, address, country FROM __temp__owner');
        $this->addSql('DROP TABLE __temp__owner');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF60E67CA76ED395 ON owner (user_id)');
        $this->addSql('DROP INDEX IDX_729F519B7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, owner_id, summary, description, capacity, superficy, price, address, image_name, image_updated_at, content_type FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, summary CLOB NOT NULL, description CLOB NOT NULL, capacity INTEGER NOT NULL, superficy DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, address CLOB NOT NULL, image_name VARCHAR(255) DEFAULT NULL, image_updated_at DATETIME DEFAULT NULL, content_type VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO room (id, owner_id, summary, description, capacity, superficy, price, address, image_name, image_updated_at, content_type) SELECT id, owner_id, summary, description, capacity, superficy, price, address, image_name, image_updated_at, content_type FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B7E3C61F9 ON room (owner_id)');
        $this->addSql('DROP INDEX IDX_4E2C37B754177093');
        $this->addSql('DROP INDEX IDX_4E2C37B798260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_region AS SELECT room_id, region_id FROM room_region');
        $this->addSql('DROP TABLE room_region');
        $this->addSql('CREATE TABLE room_region (room_id INTEGER NOT NULL, region_id INTEGER NOT NULL, PRIMARY KEY(room_id, region_id))');
        $this->addSql('INSERT INTO room_region (room_id, region_id) SELECT room_id, region_id FROM __temp__room_region');
        $this->addSql('DROP TABLE __temp__room_region');
        $this->addSql('CREATE INDEX IDX_4E2C37B754177093 ON room_region (room_id)');
        $this->addSql('CREATE INDEX IDX_4E2C37B798260155 ON room_region (region_id)');
    }
}
