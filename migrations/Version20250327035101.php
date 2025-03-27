<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250327035101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departs ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE departs ADD CONSTRAINT FK_15CE7982B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE departs ADD CONSTRAINT FK_15CE7982896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_15CE7982B03A8386 ON departs (created_by_id)');
        $this->addSql('CREATE INDEX IDX_15CE7982896DBBDE ON departs (updated_by_id)');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departs DROP FOREIGN KEY FK_15CE7982B03A8386');
        $this->addSql('ALTER TABLE departs DROP FOREIGN KEY FK_15CE7982896DBBDE');
        $this->addSql('DROP INDEX IDX_15CE7982B03A8386 ON departs');
        $this->addSql('DROP INDEX IDX_15CE7982896DBBDE ON departs');
        $this->addSql('ALTER TABLE departs DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
    }
}
