<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329175112 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee_scolaires ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE annee_scolaires ADD CONSTRAINT FK_B7252347B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE annee_scolaires ADD CONSTRAINT FK_B7252347896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B725234723E1E348 ON annee_scolaires (anneedebut)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B72523477B13567B ON annee_scolaires (annee_fin)');
        $this->addSql('CREATE INDEX IDX_B7252347B03A8386 ON annee_scolaires (created_by_id)');
        $this->addSql('CREATE INDEX IDX_B7252347896DBBDE ON annee_scolaires (updated_by_id)');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annee_scolaires DROP FOREIGN KEY FK_B7252347B03A8386');
        $this->addSql('ALTER TABLE annee_scolaires DROP FOREIGN KEY FK_B7252347896DBBDE');
        $this->addSql('DROP INDEX UNIQ_B725234723E1E348 ON annee_scolaires');
        $this->addSql('DROP INDEX UNIQ_B72523477B13567B ON annee_scolaires');
        $this->addSql('DROP INDEX IDX_B7252347B03A8386 ON annee_scolaires');
        $this->addSql('DROP INDEX IDX_B7252347896DBBDE ON annee_scolaires');
        $this->addSql('ALTER TABLE annee_scolaires DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
    }
}
