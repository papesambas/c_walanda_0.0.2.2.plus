<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250309015327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE eleves (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, prenom_id INT NOT NULL, lieu_naissance_id INT NOT NULL, parent_id INT NOT NULL, sexe VARCHAR(1) NOT NULL, numero_extrait VARCHAR(30) NOT NULL, date_inscription DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', date_recrutement DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', date_naissance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', date_extrait DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_383B09B1C8121CE9 (nom_id), INDEX IDX_383B09B158819F9E (prenom_id), INDEX IDX_383B09B138C8067D (lieu_naissance_id), INDEX IDX_383B09B1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1C8121CE9 FOREIGN KEY (nom_id) REFERENCES noms (id)');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B158819F9E FOREIGN KEY (prenom_id) REFERENCES prenoms (id)');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B138C8067D FOREIGN KEY (lieu_naissance_id) REFERENCES lieu_naissances (id)');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1727ACA70 FOREIGN KEY (parent_id) REFERENCES parents (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1C8121CE9');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B158819F9E');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B138C8067D');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1727ACA70');
        $this->addSql('DROP TABLE eleves');
    }
}
