<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250306024937 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meres (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, prenom_id INT NOT NULL, profession_id INT NOT NULL, telephone1_id INT NOT NULL, telephone2_id INT DEFAULT NULL, INDEX IDX_2D8B408AC8121CE9 (nom_id), INDEX IDX_2D8B408A58819F9E (prenom_id), INDEX IDX_2D8B408AFDEF8996 (profession_id), UNIQUE INDEX UNIQ_2D8B408A9420D165 (telephone1_id), UNIQUE INDEX UNIQ_2D8B408A86957E8B (telephone2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE peres (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, prenom_id INT NOT NULL, profession_id INT NOT NULL, telephone1_id INT NOT NULL, telephone2_id INT DEFAULT NULL, INDEX IDX_B5FB13B9C8121CE9 (nom_id), INDEX IDX_B5FB13B958819F9E (prenom_id), INDEX IDX_B5FB13B9FDEF8996 (profession_id), UNIQUE INDEX UNIQ_B5FB13B99420D165 (telephone1_id), UNIQUE INDEX UNIQ_B5FB13B986957E8B (telephone2_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408AC8121CE9 FOREIGN KEY (nom_id) REFERENCES noms (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A58819F9E FOREIGN KEY (prenom_id) REFERENCES prenoms (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408AFDEF8996 FOREIGN KEY (profession_id) REFERENCES professions (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A9420D165 FOREIGN KEY (telephone1_id) REFERENCES telephones1 (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A86957E8B FOREIGN KEY (telephone2_id) REFERENCES telephones2 (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9C8121CE9 FOREIGN KEY (nom_id) REFERENCES noms (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B958819F9E FOREIGN KEY (prenom_id) REFERENCES prenoms (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9FDEF8996 FOREIGN KEY (profession_id) REFERENCES professions (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B99420D165 FOREIGN KEY (telephone1_id) REFERENCES telephones1 (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B986957E8B FOREIGN KEY (telephone2_id) REFERENCES telephones2 (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_45C1718D8947610D ON cercles (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A069E65D8947610D ON noms (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E71162E38947610D ON prenoms (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2FDA85FA8947610D ON professions (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A26779F38947610D ON regions (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E36A9DB2F55AE19E ON telephones1 (numero)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7A63CC08F55AE19E ON telephones2 (numero)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408AC8121CE9');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A58819F9E');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408AFDEF8996');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A9420D165');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A86957E8B');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9C8121CE9');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B958819F9E');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9FDEF8996');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B99420D165');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B986957E8B');
        $this->addSql('DROP TABLE meres');
        $this->addSql('DROP TABLE peres');
        $this->addSql('DROP INDEX UNIQ_45C1718D8947610D ON cercles');
        $this->addSql('DROP INDEX UNIQ_E71162E38947610D ON prenoms');
        $this->addSql('DROP INDEX UNIQ_7A63CC08F55AE19E ON telephones2');
        $this->addSql('DROP INDEX UNIQ_E36A9DB2F55AE19E ON telephones1');
        $this->addSql('DROP INDEX UNIQ_A26779F38947610D ON regions');
        $this->addSql('DROP INDEX UNIQ_2FDA85FA8947610D ON professions');
        $this->addSql('DROP INDEX UNIQ_A069E65D8947610D ON noms');
    }
}
