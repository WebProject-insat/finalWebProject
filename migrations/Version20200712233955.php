<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200712233955 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CAE5E1BDF');
        $this->addSql('DROP INDEX IDX_4DB9D91CAE5E1BDF ON announcement');
        $this->addSql('ALTER TABLE announcement DROP applied_ad_id');
        $this->addSql('ALTER TABLE user ADD applied_ad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649AE5E1BDF FOREIGN KEY (applied_ad_id) REFERENCES announcement (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649AE5E1BDF ON user (applied_ad_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE announcement ADD applied_ad_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CAE5E1BDF FOREIGN KEY (applied_ad_id) REFERENCES announcement (id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91CAE5E1BDF ON announcement (applied_ad_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649AE5E1BDF');
        $this->addSql('DROP INDEX IDX_8D93D649AE5E1BDF ON user');
        $this->addSql('ALTER TABLE user DROP applied_ad_id');
    }
}
