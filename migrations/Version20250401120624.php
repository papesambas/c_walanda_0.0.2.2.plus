<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401120624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrats ADD type_contrat_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C520D03A FOREIGN KEY (type_contrat_id) REFERENCES type_contrats (id)');
        $this->addSql('CREATE INDEX IDX_7268396C520D03A ON contrats (type_contrat_id)');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C520D03A');
        $this->addSql('DROP INDEX IDX_7268396C520D03A ON contrats');
        $this->addSql('ALTER TABLE contrats DROP type_contrat_id');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
    }
}
