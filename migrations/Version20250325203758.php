<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325203758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B180BDEBFF');
        $this->addSql('CREATE TABLE redoublements1_scolarites1 (redoublements1_id INT NOT NULL, scolarites1_id INT NOT NULL, INDEX IDX_1D57184D373EBBB6 (redoublements1_id), INDEX IDX_1D57184DF4ABE2EA (scolarites1_id), PRIMARY KEY(redoublements1_id, scolarites1_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redoublements1_scolarites2 (redoublements1_id INT NOT NULL, scolarites2_id INT NOT NULL, INDEX IDX_845E49F7373EBBB6 (redoublements1_id), INDEX IDX_845E49F7E61E4D04 (scolarites2_id), PRIMARY KEY(redoublements1_id, scolarites2_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redoublements2_scolarites1 (redoublements2_id INT NOT NULL, scolarites1_id INT NOT NULL, INDEX IDX_A09D7483258B1458 (redoublements2_id), INDEX IDX_A09D7483F4ABE2EA (scolarites1_id), PRIMARY KEY(redoublements2_id, scolarites1_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redoublements2_scolarites2 (redoublements2_id INT NOT NULL, scolarites2_id INT NOT NULL, INDEX IDX_39942539258B1458 (redoublements2_id), INDEX IDX_39942539E61E4D04 (scolarites2_id), PRIMARY KEY(redoublements2_id, scolarites2_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redoublements3_scolarites1 (redoublements3_id INT NOT NULL, scolarites1_id INT NOT NULL, INDEX IDX_7D0BAD069D37733D (redoublements3_id), INDEX IDX_7D0BAD06F4ABE2EA (scolarites1_id), PRIMARY KEY(redoublements3_id, scolarites1_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE redoublements3_scolarites2 (redoublements3_id INT NOT NULL, scolarites2_id INT NOT NULL, INDEX IDX_E402FCBC9D37733D (redoublements3_id), INDEX IDX_E402FCBCE61E4D04 (scolarites2_id), PRIMARY KEY(redoublements3_id, scolarites2_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statuts_niveaux (statuts_id INT NOT NULL, niveaux_id INT NOT NULL, INDEX IDX_397C5DCBE0EA5904 (statuts_id), INDEX IDX_397C5DCBAAC4B70E (niveaux_id), PRIMARY KEY(statuts_id, niveaux_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE redoublements1_scolarites1 ADD CONSTRAINT FK_1D57184D373EBBB6 FOREIGN KEY (redoublements1_id) REFERENCES redoublements1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements1_scolarites1 ADD CONSTRAINT FK_1D57184DF4ABE2EA FOREIGN KEY (scolarites1_id) REFERENCES scolarites1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements1_scolarites2 ADD CONSTRAINT FK_845E49F7373EBBB6 FOREIGN KEY (redoublements1_id) REFERENCES redoublements1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements1_scolarites2 ADD CONSTRAINT FK_845E49F7E61E4D04 FOREIGN KEY (scolarites2_id) REFERENCES scolarites2 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements2_scolarites1 ADD CONSTRAINT FK_A09D7483258B1458 FOREIGN KEY (redoublements2_id) REFERENCES redoublements2 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements2_scolarites1 ADD CONSTRAINT FK_A09D7483F4ABE2EA FOREIGN KEY (scolarites1_id) REFERENCES scolarites1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements2_scolarites2 ADD CONSTRAINT FK_39942539258B1458 FOREIGN KEY (redoublements2_id) REFERENCES redoublements2 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements2_scolarites2 ADD CONSTRAINT FK_39942539E61E4D04 FOREIGN KEY (scolarites2_id) REFERENCES scolarites2 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements3_scolarites1 ADD CONSTRAINT FK_7D0BAD069D37733D FOREIGN KEY (redoublements3_id) REFERENCES redoublements3 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements3_scolarites1 ADD CONSTRAINT FK_7D0BAD06F4ABE2EA FOREIGN KEY (scolarites1_id) REFERENCES scolarites1 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements3_scolarites2 ADD CONSTRAINT FK_E402FCBC9D37733D FOREIGN KEY (redoublements3_id) REFERENCES redoublements3 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE redoublements3_scolarites2 ADD CONSTRAINT FK_E402FCBCE61E4D04 FOREIGN KEY (scolarites2_id) REFERENCES scolarites2 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE statuts_niveaux ADD CONSTRAINT FK_397C5DCBE0EA5904 FOREIGN KEY (statuts_id) REFERENCES statuts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE statuts_niveaux ADD CONSTRAINT FK_397C5DCBAAC4B70E FOREIGN KEY (niveaux_id) REFERENCES niveaux (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE departs DROP FOREIGN KEY FK_15CE7982A6CC7B2');
        $this->addSql('ALTER TABLE dossier_eleves DROP FOREIGN KEY FK_D04A5D98896DBBDE');
        $this->addSql('ALTER TABLE dossier_eleves DROP FOREIGN KEY FK_D04A5D98B03A8386');
        $this->addSql('ALTER TABLE dossier_eleves DROP FOREIGN KEY FK_D04A5D98C2140342');
        $this->addSql('ALTER TABLE ecole_provenances DROP FOREIGN KEY FK_59378F8C896DBBDE');
        $this->addSql('ALTER TABLE ecole_provenances DROP FOREIGN KEY FK_59378F8CB03A8386');
        $this->addSql('ALTER TABLE eleves_ecole_provenances DROP FOREIGN KEY FK_6E150AF18AC80606');
        $this->addSql('ALTER TABLE eleves_ecole_provenances DROP FOREIGN KEY FK_6E150AF1C2140342');
        $this->addSql('ALTER TABLE santes DROP FOREIGN KEY FK_C1A17FE9A6CC7B2');
        $this->addSql('DROP TABLE departs');
        $this->addSql('DROP TABLE dossier_eleves');
        $this->addSql('DROP TABLE ecole_provenances');
        $this->addSql('DROP TABLE eleves_ecole_provenances');
        $this->addSql('DROP TABLE santes');
        $this->addSql('ALTER TABLE cercles DROP FOREIGN KEY FK_45C1718D98260155');
        $this->addSql('ALTER TABLE cercles ADD CONSTRAINT FK_45C1718D98260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A527413AB9');
        $this->addSql('ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A527413AB9 FOREIGN KEY (cercle_id) REFERENCES cercles (id)');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B16D13ADFD');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B17FA60213');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1896DBBDE');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1B03A8386');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1C71A6576');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B18F5EA509');
        $this->addSql('DROP INDEX IDX_383B09B16D13ADFD ON eleves');
        $this->addSql('DROP INDEX IDX_383B09B17FA60213 ON eleves');
        $this->addSql('DROP INDEX IDX_383B09B180BDEBFF ON eleves');
        $this->addSql('DROP INDEX IDX_383B09B1896DBBDE ON eleves');
        $this->addSql('DROP INDEX IDX_383B09B1B03A8386 ON eleves');
        $this->addSql('DROP INDEX IDX_383B09B1C71A6576 ON eleves');
        $this->addSql('ALTER TABLE eleves DROP redoublement1_id, DROP redoublement2_id, DROP redoublement3_id, DROP created_by_id, DROP updated_by_id, DROP image_name, DROP matricule, DROP created_at, DROP updated_at, DROP slug, CHANGE ecole_recrutement_id user_id INT NOT NULL, CHANGE is_admis is_admin TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B18F5EA509 FOREIGN KEY (classe_id) REFERENCES classes (id)');
        $this->addSql('CREATE INDEX IDX_383B09B1A76ED395 ON eleves (user_id)');
        $this->addSql('ALTER TABLE lieu_naissances DROP FOREIGN KEY FK_49F8927F131A4F72');
        $this->addSql('ALTER TABLE lieu_naissances ADD CONSTRAINT FK_49F8927F131A4F72 FOREIGN KEY (commune_id) REFERENCES communes (id)');
        $this->addSql('ALTER TABLE niveaux DROP min_age, DROP max_age, DROP min_date, DROP max_date');
        $this->addSql('ALTER TABLE redoublements1 DROP FOREIGN KEY FK_2554EDA9E671FFEE');
        $this->addSql('ALTER TABLE redoublements1 DROP FOREIGN KEY FK_2554EDA9F4C45000');
        $this->addSql('DROP INDEX IDX_2554EDA9E671FFEE ON redoublements1');
        $this->addSql('DROP INDEX IDX_2554EDA9F4C45000 ON redoublements1');
        $this->addSql('ALTER TABLE redoublements1 DROP scolarite1_id, DROP scolarite2_id');
        $this->addSql('ALTER TABLE redoublements2 DROP FOREIGN KEY FK_BC5DBC13E671FFEE');
        $this->addSql('ALTER TABLE redoublements2 DROP FOREIGN KEY FK_BC5DBC13F4C45000');
        $this->addSql('DROP INDEX IDX_BC5DBC13E671FFEE ON redoublements2');
        $this->addSql('DROP INDEX IDX_BC5DBC13F4C45000 ON redoublements2');
        $this->addSql('ALTER TABLE redoublements2 DROP scolarite1_id, DROP scolarite2_id');
        $this->addSql('ALTER TABLE redoublements3 DROP FOREIGN KEY FK_CB5A8C85E671FFEE');
        $this->addSql('ALTER TABLE redoublements3 DROP FOREIGN KEY FK_CB5A8C85F4C45000');
        $this->addSql('DROP INDEX IDX_CB5A8C85E671FFEE ON redoublements3');
        $this->addSql('DROP INDEX IDX_CB5A8C85F4C45000 ON redoublements3');
        $this->addSql('ALTER TABLE redoublements3 DROP scolarite1_id, DROP scolarite2_id');
        $this->addSql('ALTER TABLE statuts DROP FOREIGN KEY FK_403505E6B3E9C81');
        $this->addSql('DROP INDEX IDX_403505E6B3E9C81 ON statuts');
        $this->addSql('ALTER TABLE statuts DROP niveau_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_STATUT_DESIGNATION ON statuts (designation)');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9A6CC7B2');
        $this->addSql('DROP INDEX UNIQ_1483A5E9A6CC7B2 ON users');
        $this->addSql('ALTER TABLE users DROP eleve_id, DROP fullname');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departs (id INT AUTO_INCREMENT NOT NULL, eleve_id INT NOT NULL, date_depart DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ecole_destination VARCHAR(130) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_15CE7982A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE dossier_eleves (id INT AUTO_INCREMENT NOT NULL, eleves_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D04A5D98896DBBDE (updated_by_id), INDEX IDX_D04A5D98B03A8386 (created_by_id), INDEX IDX_D04A5D98C2140342 (eleves_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE ecole_provenances (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, adresse VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, telephone VARCHAR(25) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, designation VARCHAR(130) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', slug VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_59378F8C896DBBDE (updated_by_id), INDEX IDX_59378F8CB03A8386 (created_by_id), UNIQUE INDEX UNIQ_59378F8CE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE eleves_ecole_provenances (eleves_id INT NOT NULL, ecole_provenances_id INT NOT NULL, INDEX IDX_6E150AF18AC80606 (ecole_provenances_id), INDEX IDX_6E150AF1C2140342 (eleves_id), PRIMARY KEY(eleves_id, ecole_provenances_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE santes (id INT AUTO_INCREMENT NOT NULL, eleve_id INT NOT NULL, maladie VARCHAR(130) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, medecin VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, numero_urgence VARCHAR(25) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, centre_sante VARCHAR(150) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_C1A17FE9A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE departs ADD CONSTRAINT FK_15CE7982A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE dossier_eleves ADD CONSTRAINT FK_D04A5D98896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE dossier_eleves ADD CONSTRAINT FK_D04A5D98B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE dossier_eleves ADD CONSTRAINT FK_D04A5D98C2140342 FOREIGN KEY (eleves_id) REFERENCES eleves (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ecole_provenances ADD CONSTRAINT FK_59378F8C896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE ecole_provenances ADD CONSTRAINT FK_59378F8CB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE eleves_ecole_provenances ADD CONSTRAINT FK_6E150AF18AC80606 FOREIGN KEY (ecole_provenances_id) REFERENCES ecole_provenances (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleves_ecole_provenances ADD CONSTRAINT FK_6E150AF1C2140342 FOREIGN KEY (eleves_id) REFERENCES eleves (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE santes ADD CONSTRAINT FK_C1A17FE9A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE redoublements1_scolarites1 DROP FOREIGN KEY FK_1D57184D373EBBB6');
        $this->addSql('ALTER TABLE redoublements1_scolarites1 DROP FOREIGN KEY FK_1D57184DF4ABE2EA');
        $this->addSql('ALTER TABLE redoublements1_scolarites2 DROP FOREIGN KEY FK_845E49F7373EBBB6');
        $this->addSql('ALTER TABLE redoublements1_scolarites2 DROP FOREIGN KEY FK_845E49F7E61E4D04');
        $this->addSql('ALTER TABLE redoublements2_scolarites1 DROP FOREIGN KEY FK_A09D7483258B1458');
        $this->addSql('ALTER TABLE redoublements2_scolarites1 DROP FOREIGN KEY FK_A09D7483F4ABE2EA');
        $this->addSql('ALTER TABLE redoublements2_scolarites2 DROP FOREIGN KEY FK_39942539258B1458');
        $this->addSql('ALTER TABLE redoublements2_scolarites2 DROP FOREIGN KEY FK_39942539E61E4D04');
        $this->addSql('ALTER TABLE redoublements3_scolarites1 DROP FOREIGN KEY FK_7D0BAD069D37733D');
        $this->addSql('ALTER TABLE redoublements3_scolarites1 DROP FOREIGN KEY FK_7D0BAD06F4ABE2EA');
        $this->addSql('ALTER TABLE redoublements3_scolarites2 DROP FOREIGN KEY FK_E402FCBC9D37733D');
        $this->addSql('ALTER TABLE redoublements3_scolarites2 DROP FOREIGN KEY FK_E402FCBCE61E4D04');
        $this->addSql('ALTER TABLE statuts_niveaux DROP FOREIGN KEY FK_397C5DCBE0EA5904');
        $this->addSql('ALTER TABLE statuts_niveaux DROP FOREIGN KEY FK_397C5DCBAAC4B70E');
        $this->addSql('DROP TABLE redoublements1_scolarites1');
        $this->addSql('DROP TABLE redoublements1_scolarites2');
        $this->addSql('DROP TABLE redoublements2_scolarites1');
        $this->addSql('DROP TABLE redoublements2_scolarites2');
        $this->addSql('DROP TABLE redoublements3_scolarites1');
        $this->addSql('DROP TABLE redoublements3_scolarites2');
        $this->addSql('DROP TABLE statuts_niveaux');
        $this->addSql('ALTER TABLE cercles DROP FOREIGN KEY FK_45C1718D98260155');
        $this->addSql('ALTER TABLE cercles ADD CONSTRAINT FK_45C1718D98260155 FOREIGN KEY (region_id) REFERENCES regions (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A527413AB9');
        $this->addSql('ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A527413AB9 FOREIGN KEY (cercle_id) REFERENCES cercles (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B1A76ED395');
        $this->addSql('ALTER TABLE eleves DROP FOREIGN KEY FK_383B09B18F5EA509');
        $this->addSql('DROP INDEX IDX_383B09B1A76ED395 ON eleves');
        $this->addSql('ALTER TABLE eleves ADD redoublement1_id INT DEFAULT NULL, ADD redoublement2_id INT DEFAULT NULL, ADD redoublement3_id INT DEFAULT NULL, ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD image_name VARCHAR(255) DEFAULT NULL, ADD matricule VARCHAR(30) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL, CHANGE user_id ecole_recrutement_id INT NOT NULL, CHANGE is_admin is_admis TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B16D13ADFD FOREIGN KEY (redoublement1_id) REFERENCES redoublements1 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B17FA60213 FOREIGN KEY (redoublement2_id) REFERENCES redoublements2 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B180BDEBFF FOREIGN KEY (ecole_recrutement_id) REFERENCES ecole_provenances (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B1C71A6576 FOREIGN KEY (redoublement3_id) REFERENCES redoublements3 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE eleves ADD CONSTRAINT FK_383B09B18F5EA509 FOREIGN KEY (classe_id) REFERENCES classes (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_383B09B16D13ADFD ON eleves (redoublement1_id)');
        $this->addSql('CREATE INDEX IDX_383B09B17FA60213 ON eleves (redoublement2_id)');
        $this->addSql('CREATE INDEX IDX_383B09B180BDEBFF ON eleves (ecole_recrutement_id)');
        $this->addSql('CREATE INDEX IDX_383B09B1896DBBDE ON eleves (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_383B09B1B03A8386 ON eleves (created_by_id)');
        $this->addSql('CREATE INDEX IDX_383B09B1C71A6576 ON eleves (redoublement3_id)');
        $this->addSql('ALTER TABLE lieu_naissances DROP FOREIGN KEY FK_49F8927F131A4F72');
        $this->addSql('ALTER TABLE lieu_naissances ADD CONSTRAINT FK_49F8927F131A4F72 FOREIGN KEY (commune_id) REFERENCES communes (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveaux ADD min_age INT NOT NULL, ADD max_age INT NOT NULL, ADD min_date INT NOT NULL, ADD max_date INT NOT NULL');
        $this->addSql('ALTER TABLE redoublements1 ADD scolarite1_id INT NOT NULL, ADD scolarite2_id INT NOT NULL');
        $this->addSql('ALTER TABLE redoublements1 ADD CONSTRAINT FK_2554EDA9E671FFEE FOREIGN KEY (scolarite2_id) REFERENCES scolarites2 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE redoublements1 ADD CONSTRAINT FK_2554EDA9F4C45000 FOREIGN KEY (scolarite1_id) REFERENCES scolarites1 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2554EDA9E671FFEE ON redoublements1 (scolarite2_id)');
        $this->addSql('CREATE INDEX IDX_2554EDA9F4C45000 ON redoublements1 (scolarite1_id)');
        $this->addSql('ALTER TABLE redoublements2 ADD scolarite1_id INT NOT NULL, ADD scolarite2_id INT NOT NULL');
        $this->addSql('ALTER TABLE redoublements2 ADD CONSTRAINT FK_BC5DBC13E671FFEE FOREIGN KEY (scolarite2_id) REFERENCES scolarites2 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE redoublements2 ADD CONSTRAINT FK_BC5DBC13F4C45000 FOREIGN KEY (scolarite1_id) REFERENCES scolarites1 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_BC5DBC13E671FFEE ON redoublements2 (scolarite2_id)');
        $this->addSql('CREATE INDEX IDX_BC5DBC13F4C45000 ON redoublements2 (scolarite1_id)');
        $this->addSql('ALTER TABLE redoublements3 ADD scolarite1_id INT NOT NULL, ADD scolarite2_id INT NOT NULL');
        $this->addSql('ALTER TABLE redoublements3 ADD CONSTRAINT FK_CB5A8C85E671FFEE FOREIGN KEY (scolarite2_id) REFERENCES scolarites2 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE redoublements3 ADD CONSTRAINT FK_CB5A8C85F4C45000 FOREIGN KEY (scolarite1_id) REFERENCES scolarites1 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_CB5A8C85E671FFEE ON redoublements3 (scolarite2_id)');
        $this->addSql('CREATE INDEX IDX_CB5A8C85F4C45000 ON redoublements3 (scolarite1_id)');
        $this->addSql('DROP INDEX UNIQ_STATUT_DESIGNATION ON statuts');
        $this->addSql('ALTER TABLE statuts ADD niveau_id INT NOT NULL');
        $this->addSql('ALTER TABLE statuts ADD CONSTRAINT FK_403505E6B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveaux (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_403505E6B3E9C81 ON statuts (niveau_id)');
        $this->addSql('ALTER TABLE users ADD eleve_id INT DEFAULT NULL, ADD fullname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A6CC7B2 ON users (eleve_id)');
    }
}
