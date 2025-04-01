<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401123856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE absences_personnel (id INT AUTO_INCREMENT NOT NULL, personnel_id INT NOT NULL, annee_scolaire_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, jour DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', is_justify TINYINT(1) NOT NULL, motif VARCHAR(130) DEFAULT NULL, heure TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(128) NOT NULL, INDEX IDX_64A8F3D01C109075 (personnel_id), INDEX IDX_64A8F3D09331C741 (annee_scolaire_id), INDEX IDX_64A8F3D0B03A8386 (created_by_id), INDEX IDX_64A8F3D0896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE indiscipline_personnel (id INT AUTO_INCREMENT NOT NULL, personnel_id INT NOT NULL, annee_scolaire_id INT NOT NULL, jour DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', description LONGTEXT NOT NULL, is_sanction TINYINT(1) NOT NULL, sanction VARCHAR(255) DEFAULT NULL, INDEX IDX_6A057261C109075 (personnel_id), INDEX IDX_6A057269331C741 (annee_scolaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retards_personnel (id INT AUTO_INCREMENT NOT NULL, personnel_id INT NOT NULL, annee_scolaire_id INT NOT NULL, jour DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', heure TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', duree TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', motif VARCHAR(255) DEFAULT NULL, heure_classe TIME DEFAULT NULL COMMENT \'(DC2Type:time_immutable)\', INDEX IDX_391BBEF71C109075 (personnel_id), INDEX IDX_391BBEF79331C741 (annee_scolaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE absences_personnel ADD CONSTRAINT FK_64A8F3D01C109075 FOREIGN KEY (personnel_id) REFERENCES personnels (id)');
        $this->addSql('ALTER TABLE absences_personnel ADD CONSTRAINT FK_64A8F3D09331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaires (id)');
        $this->addSql('ALTER TABLE absences_personnel ADD CONSTRAINT FK_64A8F3D0B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE absences_personnel ADD CONSTRAINT FK_64A8F3D0896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE indiscipline_personnel ADD CONSTRAINT FK_6A057261C109075 FOREIGN KEY (personnel_id) REFERENCES personnels (id)');
        $this->addSql('ALTER TABLE indiscipline_personnel ADD CONSTRAINT FK_6A057269331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaires (id)');
        $this->addSql('ALTER TABLE retards_personnel ADD CONSTRAINT FK_391BBEF71C109075 FOREIGN KEY (personnel_id) REFERENCES personnels (id)');
        $this->addSql('ALTER TABLE retards_personnel ADD CONSTRAINT FK_391BBEF79331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaires (id)');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absences_personnel DROP FOREIGN KEY FK_64A8F3D01C109075');
        $this->addSql('ALTER TABLE absences_personnel DROP FOREIGN KEY FK_64A8F3D09331C741');
        $this->addSql('ALTER TABLE absences_personnel DROP FOREIGN KEY FK_64A8F3D0B03A8386');
        $this->addSql('ALTER TABLE absences_personnel DROP FOREIGN KEY FK_64A8F3D0896DBBDE');
        $this->addSql('ALTER TABLE indiscipline_personnel DROP FOREIGN KEY FK_6A057261C109075');
        $this->addSql('ALTER TABLE indiscipline_personnel DROP FOREIGN KEY FK_6A057269331C741');
        $this->addSql('ALTER TABLE retards_personnel DROP FOREIGN KEY FK_391BBEF71C109075');
        $this->addSql('ALTER TABLE retards_personnel DROP FOREIGN KEY FK_391BBEF79331C741');
        $this->addSql('DROP TABLE absences_personnel');
        $this->addSql('DROP TABLE indiscipline_personnel');
        $this->addSql('DROP TABLE retards_personnel');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
    }
}
