<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200617194653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement (id INT AUTO_INCREMENT NOT NULL, located_at_id INT NOT NULL, user_owner_id INT NOT NULL, room_nb INT NOT NULL, surface DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, furnished TINYINT(1) NOT NULL, availability_date DATE NOT NULL, smoker TINYINT(1) NOT NULL, max_roomates INT NOT NULL, balcon TINYINT(1) NOT NULL, garden TINYINT(1) NOT NULL, garage TINYINT(1) NOT NULL, images LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_4DB9D91C5882D2EF (located_at_id), INDEX IDX_4DB9D91C9EB185F9 (user_owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, avg_price DOUBLE PRECISION NOT NULL, nb_announcements INT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gender (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, gender_id INT NOT NULL, coloc_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone_number INT NOT NULL, age INT NOT NULL, profession VARCHAR(255) NOT NULL, about LONGTEXT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_8D93D649708A0E0 (gender_id), UNIQUE INDEX UNIQ_8D93D649927F2F4F (coloc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91C5882D2EF FOREIGN KEY (located_at_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91C9EB185F9 FOREIGN KEY (user_owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649708A0E0 FOREIGN KEY (gender_id) REFERENCES gender (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649927F2F4F FOREIGN KEY (coloc_id) REFERENCES announcement (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649927F2F4F');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91C5882D2EF');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649708A0E0');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91C9EB185F9');
        $this->addSql('DROP TABLE announcement');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE gender');
        $this->addSql('DROP TABLE user');
    }
}
