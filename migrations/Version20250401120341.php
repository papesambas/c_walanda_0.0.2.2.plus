<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401120341 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personnels (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, prenom_id INT NOT NULL, lieu_naissance_id INT NOT NULL, telephone1_id INT NOT NULL, telephone2_id INT DEFAULT NULL, nina_id INT NOT NULL, niveau_etudes_id INT NOT NULL, poste_id INT NOT NULL, date_naissance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', sexe VARCHAR(2) NOT NULL, reference_diplome VARCHAR(150) DEFAULT NULL, INDEX IDX_7AC38C2BC8121CE9 (nom_id), INDEX IDX_7AC38C2B58819F9E (prenom_id), INDEX IDX_7AC38C2B38C8067D (lieu_naissance_id), UNIQUE INDEX UNIQ_7AC38C2B9420D165 (telephone1_id), UNIQUE INDEX UNIQ_7AC38C2B86957E8B (telephone2_id), UNIQUE INDEX UNIQ_7AC38C2B5586F33C (nina_id), INDEX IDX_7AC38C2B165BF274 (niveau_etudes_id), INDEX IDX_7AC38C2BA0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnels_specialites (personnels_id INT NOT NULL, specialites_id INT NOT NULL, INDEX IDX_4B6A7D68C7022806 (personnels_id), INDEX IDX_4B6A7D685AEDDAD9 (specialites_id), PRIMARY KEY(personnels_id, specialites_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_contrats (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', designation VARCHAR(130) NOT NULL, slug VARCHAR(128) NOT NULL, INDEX IDX_BF971E90B03A8386 (created_by_id), INDEX IDX_BF971E90896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2BC8121CE9 FOREIGN KEY (nom_id) REFERENCES noms (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2B58819F9E FOREIGN KEY (prenom_id) REFERENCES prenoms (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2B38C8067D FOREIGN KEY (lieu_naissance_id) REFERENCES lieu_naissances (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2B9420D165 FOREIGN KEY (telephone1_id) REFERENCES telephones1 (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2B86957E8B FOREIGN KEY (telephone2_id) REFERENCES telephones2 (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2B5586F33C FOREIGN KEY (nina_id) REFERENCES ninas (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2B165BF274 FOREIGN KEY (niveau_etudes_id) REFERENCES niveau_etudes (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2BA0905086 FOREIGN KEY (poste_id) REFERENCES postes (id)');
        $this->addSql('ALTER TABLE personnels_specialites ADD CONSTRAINT FK_4B6A7D68C7022806 FOREIGN KEY (personnels_id) REFERENCES personnels (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE personnels_specialites ADD CONSTRAINT FK_4B6A7D685AEDDAD9 FOREIGN KEY (specialites_id) REFERENCES specialites (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_contrats ADD CONSTRAINT FK_BF971E90B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE type_contrats ADD CONSTRAINT FK_BF971E90896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE contrats ADD personnels_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396CC7022806 FOREIGN KEY (personnels_id) REFERENCES personnels (id)');
        $this->addSql('CREATE INDEX IDX_7268396CC7022806 ON contrats (personnels_id)');
        $this->addSql('ALTER TABLE dossier_personnel ADD personnels_id INT NOT NULL');
        $this->addSql('ALTER TABLE dossier_personnel ADD CONSTRAINT FK_68F557A3C7022806 FOREIGN KEY (personnels_id) REFERENCES personnels (id)');
        $this->addSql('CREATE INDEX IDX_68F557A3C7022806 ON dossier_personnel (personnels_id)');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396CC7022806');
        $this->addSql('ALTER TABLE dossier_personnel DROP FOREIGN KEY FK_68F557A3C7022806');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2BC8121CE9');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2B58819F9E');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2B38C8067D');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2B9420D165');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2B86957E8B');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2B5586F33C');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2B165BF274');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2BA0905086');
        $this->addSql('ALTER TABLE personnels_specialites DROP FOREIGN KEY FK_4B6A7D68C7022806');
        $this->addSql('ALTER TABLE personnels_specialites DROP FOREIGN KEY FK_4B6A7D685AEDDAD9');
        $this->addSql('ALTER TABLE type_contrats DROP FOREIGN KEY FK_BF971E90B03A8386');
        $this->addSql('ALTER TABLE type_contrats DROP FOREIGN KEY FK_BF971E90896DBBDE');
        $this->addSql('DROP TABLE personnels');
        $this->addSql('DROP TABLE personnels_specialites');
        $this->addSql('DROP TABLE type_contrats');
        $this->addSql('DROP INDEX IDX_7268396CC7022806 ON contrats');
        $this->addSql('ALTER TABLE contrats DROP personnels_id');
        $this->addSql('DROP INDEX IDX_68F557A3C7022806 ON dossier_personnel');
        $this->addSql('ALTER TABLE dossier_personnel DROP personnels_id');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
    }
}
