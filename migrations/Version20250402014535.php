<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402014535 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fonctions (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personnels ADD fonctions_id INT NOT NULL');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2BDC481574 FOREIGN KEY (fonctions_id) REFERENCES fonctions (id)');
        $this->addSql('CREATE INDEX IDX_7AC38C2BDC481574 ON personnels (fonctions_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2BDC481574');
        $this->addSql('DROP TABLE fonctions');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_7AC38C2BDC481574 ON personnels');
        $this->addSql('ALTER TABLE personnels DROP fonctions_id');
    }
}
