<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712175143 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement ADD cover_image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE image ADD announcement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id)');
        $this->addSql('CREATE INDEX IDX_C53D045F913AEA17 ON image (announcement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement DROP cover_image');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F913AEA17');
        $this->addSql('DROP INDEX IDX_C53D045F913AEA17 ON image');
        $this->addSql('ALTER TABLE image DROP announcement_id');
    }
}
