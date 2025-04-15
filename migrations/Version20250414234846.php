<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250414234846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absences_personnel (id INT AUTO_INCREMENT NOT NULL, personnel_id INT NOT NULL, annee_scolaire_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, jour DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', is_justify TINYINT(1) NOT NULL, motif VARCHAR(130) DEFAULT NULL, heure TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(128) NOT NULL, INDEX IDX_64A8F3D01C109075 (personnel_id), INDEX IDX_64A8F3D09331C741 (annee_scolaire_id), INDEX IDX_64A8F3D0B03A8386 (created_by_id), INDEX IDX_64A8F3D0896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fonctions (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE indiscipline_personnel (id INT AUTO_INCREMENT NOT NULL, personnel_id INT NOT NULL, annee_scolaire_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, jour DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', description LONGTEXT NOT NULL, is_sanction TINYINT(1) NOT NULL, sanction VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(128) NOT NULL, INDEX IDX_6A057261C109075 (personnel_id), INDEX IDX_6A057269331C741 (annee_scolaire_id), INDEX IDX_6A05726B03A8386 (created_by_id), INDEX IDX_6A05726896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retards_personnel (id INT AUTO_INCREMENT NOT NULL, personnel_id INT NOT NULL, annee_scolaire_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, jour DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', heure TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', duree TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', motif VARCHAR(255) DEFAULT NULL, heure_classe TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(128) NOT NULL, INDEX IDX_391BBEF71C109075 (personnel_id), INDEX IDX_391BBEF79331C741 (annee_scolaire_id), INDEX IDX_391BBEF7B03A8386 (created_by_id), INDEX IDX_391BBEF7896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absences_personnel ADD CONSTRAINT FK_64A8F3D01C109075 FOREIGN KEY (personnel_id) REFERENCES personnels (id)');
        $this->addSql('ALTER TABLE absences_personnel ADD CONSTRAINT FK_64A8F3D09331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaires (id)');
        $this->addSql('ALTER TABLE absences_personnel ADD CONSTRAINT FK_64A8F3D0B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE absences_personnel ADD CONSTRAINT FK_64A8F3D0896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE indiscipline_personnel ADD CONSTRAINT FK_6A057261C109075 FOREIGN KEY (personnel_id) REFERENCES personnels (id)');
        $this->addSql('ALTER TABLE indiscipline_personnel ADD CONSTRAINT FK_6A057269331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaires (id)');
        $this->addSql('ALTER TABLE indiscipline_personnel ADD CONSTRAINT FK_6A05726B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE indiscipline_personnel ADD CONSTRAINT FK_6A05726896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE retards_personnel ADD CONSTRAINT FK_391BBEF71C109075 FOREIGN KEY (personnel_id) REFERENCES personnels (id)');
        $this->addSql('ALTER TABLE retards_personnel ADD CONSTRAINT FK_391BBEF79331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaires (id)');
        $this->addSql('ALTER TABLE retards_personnel ADD CONSTRAINT FK_391BBEF7B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE retards_personnel ADD CONSTRAINT FK_391BBEF7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE contrats ADD type_contrat_id INT NOT NULL, ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL, ADD designation VARCHAR(130) NOT NULL, DROP type');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C520D03A FOREIGN KEY (type_contrat_id) REFERENCES type_contrats (id)');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396CB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_7268396C520D03A ON contrats (type_contrat_id)');
        $this->addSql('CREATE INDEX IDX_7268396CB03A8386 ON contrats (created_by_id)');
        $this->addSql('CREATE INDEX IDX_7268396C896DBBDE ON contrats (updated_by_id)');
        $this->addSql('ALTER TABLE personnels ADD fonctions_id INT NOT NULL, ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD image_name VARCHAR(255) DEFAULT NULL, ADD is_actif TINYINT(1) NOT NULL, ADD is_allowed TINYINT(1) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2BDC481574 FOREIGN KEY (fonctions_id) REFERENCES fonctions (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2BB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2B896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_7AC38C2BDC481574 ON personnels (fonctions_id)');
        $this->addSql('CREATE INDEX IDX_7AC38C2BB03A8386 ON personnels (created_by_id)');
        $this->addSql('CREATE INDEX IDX_7AC38C2B896DBBDE ON personnels (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2BDC481574');
        $this->addSql('ALTER TABLE absences_personnel DROP FOREIGN KEY FK_64A8F3D01C109075');
        $this->addSql('ALTER TABLE absences_personnel DROP FOREIGN KEY FK_64A8F3D09331C741');
        $this->addSql('ALTER TABLE absences_personnel DROP FOREIGN KEY FK_64A8F3D0B03A8386');
        $this->addSql('ALTER TABLE absences_personnel DROP FOREIGN KEY FK_64A8F3D0896DBBDE');
        $this->addSql('ALTER TABLE indiscipline_personnel DROP FOREIGN KEY FK_6A057261C109075');
        $this->addSql('ALTER TABLE indiscipline_personnel DROP FOREIGN KEY FK_6A057269331C741');
        $this->addSql('ALTER TABLE indiscipline_personnel DROP FOREIGN KEY FK_6A05726B03A8386');
        $this->addSql('ALTER TABLE indiscipline_personnel DROP FOREIGN KEY FK_6A05726896DBBDE');
        $this->addSql('ALTER TABLE retards_personnel DROP FOREIGN KEY FK_391BBEF71C109075');
        $this->addSql('ALTER TABLE retards_personnel DROP FOREIGN KEY FK_391BBEF79331C741');
        $this->addSql('ALTER TABLE retards_personnel DROP FOREIGN KEY FK_391BBEF7B03A8386');
        $this->addSql('ALTER TABLE retards_personnel DROP FOREIGN KEY FK_391BBEF7896DBBDE');
        $this->addSql('DROP TABLE absences_personnel');
        $this->addSql('DROP TABLE fonctions');
        $this->addSql('DROP TABLE indiscipline_personnel');
        $this->addSql('DROP TABLE retards_personnel');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C520D03A');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396CB03A8386');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C896DBBDE');
        $this->addSql('DROP INDEX IDX_7268396C520D03A ON contrats');
        $this->addSql('DROP INDEX IDX_7268396CB03A8386 ON contrats');
        $this->addSql('DROP INDEX IDX_7268396C896DBBDE ON contrats');
        $this->addSql('ALTER TABLE contrats ADD type VARCHAR(150) NOT NULL, DROP type_contrat_id, DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug, DROP designation');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2BB03A8386');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2B896DBBDE');
        $this->addSql('DROP INDEX IDX_7AC38C2BDC481574 ON personnels');
        $this->addSql('DROP INDEX IDX_7AC38C2BB03A8386 ON personnels');
        $this->addSql('DROP INDEX IDX_7AC38C2B896DBBDE ON personnels');
        $this->addSql('ALTER TABLE personnels DROP fonctions_id, DROP created_by_id, DROP updated_by_id, DROP image_name, DROP is_actif, DROP is_allowed, DROP created_at, DROP updated_at, DROP slug');
    }
}
