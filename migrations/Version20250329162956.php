<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329162956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE retards (id INT AUTO_INCREMENT NOT NULL, eleves_id INT NOT NULL, annee_scolaire_id INT NOT NULL, jour DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', heure TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', duree TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', is_justify TINYINT(1) NOT NULL, INDEX IDX_AE8264E7C2140342 (eleves_id), INDEX IDX_AE8264E79331C741 (annee_scolaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE retards ADD CONSTRAINT FK_AE8264E7C2140342 FOREIGN KEY (eleves_id) REFERENCES eleves (id)');
        $this->addSql('ALTER TABLE retards ADD CONSTRAINT FK_AE8264E79331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaires (id)');
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
        $this->addSql('ALTER TABLE retards DROP FOREIGN KEY FK_AE8264E7C2140342');
        $this->addSql('ALTER TABLE retards DROP FOREIGN KEY FK_AE8264E79331C741');
        $this->addSql('DROP TABLE retards');
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
