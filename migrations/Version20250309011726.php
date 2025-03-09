<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250309011726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cercles (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(130) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_45C1718D98260155 (region_id), INDEX IDX_45C1718DB03A8386 (created_by_id), INDEX IDX_45C1718D896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE communes (id INT AUTO_INCREMENT NOT NULL, cercle_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(130) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_5C5EE2A527413AB9 (cercle_id), INDEX IDX_5C5EE2A5B03A8386 (created_by_id), INDEX IDX_5C5EE2A5896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lieu_naissances (id INT AUTO_INCREMENT NOT NULL, commune_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(130) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_49F8927F131A4F72 (commune_id), INDEX IDX_49F8927FB03A8386 (created_by_id), INDEX IDX_49F8927F896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meres (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, prenom_id INT NOT NULL, profession_id INT NOT NULL, telephone1_id INT NOT NULL, telephone2_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2D8B408AC8121CE9 (nom_id), INDEX IDX_2D8B408A58819F9E (prenom_id), INDEX IDX_2D8B408AFDEF8996 (profession_id), UNIQUE INDEX UNIQ_2D8B408A9420D165 (telephone1_id), UNIQUE INDEX UNIQ_2D8B408A86957E8B (telephone2_id), INDEX IDX_2D8B408AB03A8386 (created_by_id), INDEX IDX_2D8B408A896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ninas (id INT AUTO_INCREMENT NOT NULL, pere_id INT DEFAULT NULL, mere_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(15) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_51AD1AF28947610D (designation), UNIQUE INDEX UNIQ_51AD1AF23FD73900 (pere_id), UNIQUE INDEX UNIQ_51AD1AF239DEC40E (mere_id), INDEX IDX_51AD1AF2B03A8386 (created_by_id), INDEX IDX_51AD1AF2896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE noms (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(60) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_A069E65D8947610D (designation), INDEX IDX_A069E65DB03A8386 (created_by_id), INDEX IDX_A069E65D896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parents (id INT AUTO_INCREMENT NOT NULL, pere_id INT NOT NULL, mere_id INT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_FD501D6A3FD73900 (pere_id), INDEX IDX_FD501D6A39DEC40E (mere_id), INDEX IDX_FD501D6AB03A8386 (created_by_id), INDEX IDX_FD501D6A896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE peres (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, prenom_id INT NOT NULL, profession_id INT NOT NULL, telephone1_id INT NOT NULL, telephone2_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, fullname VARCHAR(255) DEFAULT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_B5FB13B9C8121CE9 (nom_id), INDEX IDX_B5FB13B958819F9E (prenom_id), INDEX IDX_B5FB13B9FDEF8996 (profession_id), UNIQUE INDEX UNIQ_B5FB13B99420D165 (telephone1_id), UNIQUE INDEX UNIQ_B5FB13B986957E8B (telephone2_id), INDEX IDX_B5FB13B9B03A8386 (created_by_id), INDEX IDX_B5FB13B9896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prenoms (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', designation VARCHAR(130) NOT NULL, INDEX IDX_E71162E3B03A8386 (created_by_id), INDEX IDX_E71162E3896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_PRENOMS_DESIGNATION (designation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professions (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(130) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_2FDA85FAB03A8386 (created_by_id), INDEX IDX_2FDA85FA896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_PROFESSIONS_DESIGNATION (designation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, designation VARCHAR(130) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_A26779F3B03A8386 (created_by_id), INDEX IDX_A26779F3896DBBDE (updated_by_id), UNIQUE INDEX UNIQ_REGION_DESIGNATION (designation), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telephones1 (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, numero VARCHAR(23) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_E36A9DB2F55AE19E (numero), INDEX IDX_E36A9DB2B03A8386 (created_by_id), INDEX IDX_E36A9DB2896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telephones2 (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, updated_by_id INT DEFAULT NULL, numero VARCHAR(23) NOT NULL, slug VARCHAR(128) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_7A63CC08F55AE19E (numero), INDEX IDX_7A63CC08B03A8386 (created_by_id), INDEX IDX_7A63CC08896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(60) NOT NULL, prenom VARCHAR(70) NOT NULL, email VARCHAR(130) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cercles ADD CONSTRAINT FK_45C1718D98260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('ALTER TABLE cercles ADD CONSTRAINT FK_45C1718DB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE cercles ADD CONSTRAINT FK_45C1718D896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A527413AB9 FOREIGN KEY (cercle_id) REFERENCES cercles (id)');
        $this->addSql('ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A5B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE communes ADD CONSTRAINT FK_5C5EE2A5896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE lieu_naissances ADD CONSTRAINT FK_49F8927F131A4F72 FOREIGN KEY (commune_id) REFERENCES communes (id)');
        $this->addSql('ALTER TABLE lieu_naissances ADD CONSTRAINT FK_49F8927FB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE lieu_naissances ADD CONSTRAINT FK_49F8927F896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408AC8121CE9 FOREIGN KEY (nom_id) REFERENCES noms (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A58819F9E FOREIGN KEY (prenom_id) REFERENCES prenoms (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408AFDEF8996 FOREIGN KEY (profession_id) REFERENCES professions (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A9420D165 FOREIGN KEY (telephone1_id) REFERENCES telephones1 (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A86957E8B FOREIGN KEY (telephone2_id) REFERENCES telephones2 (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE meres ADD CONSTRAINT FK_2D8B408A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE ninas ADD CONSTRAINT FK_51AD1AF23FD73900 FOREIGN KEY (pere_id) REFERENCES peres (id)');
        $this->addSql('ALTER TABLE ninas ADD CONSTRAINT FK_51AD1AF239DEC40E FOREIGN KEY (mere_id) REFERENCES meres (id)');
        $this->addSql('ALTER TABLE ninas ADD CONSTRAINT FK_51AD1AF2B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE ninas ADD CONSTRAINT FK_51AD1AF2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE noms ADD CONSTRAINT FK_A069E65DB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE noms ADD CONSTRAINT FK_A069E65D896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6A3FD73900 FOREIGN KEY (pere_id) REFERENCES peres (id)');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6A39DEC40E FOREIGN KEY (mere_id) REFERENCES meres (id)');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6AB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE parents ADD CONSTRAINT FK_FD501D6A896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9C8121CE9 FOREIGN KEY (nom_id) REFERENCES noms (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B958819F9E FOREIGN KEY (prenom_id) REFERENCES prenoms (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9FDEF8996 FOREIGN KEY (profession_id) REFERENCES professions (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B99420D165 FOREIGN KEY (telephone1_id) REFERENCES telephones1 (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B986957E8B FOREIGN KEY (telephone2_id) REFERENCES telephones2 (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE peres ADD CONSTRAINT FK_B5FB13B9896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE prenoms ADD CONSTRAINT FK_E71162E3B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE prenoms ADD CONSTRAINT FK_E71162E3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE professions ADD CONSTRAINT FK_2FDA85FAB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE professions ADD CONSTRAINT FK_2FDA85FA896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE regions ADD CONSTRAINT FK_A26779F3B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE regions ADD CONSTRAINT FK_A26779F3896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE telephones1 ADD CONSTRAINT FK_E36A9DB2B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE telephones1 ADD CONSTRAINT FK_E36A9DB2896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE telephones2 ADD CONSTRAINT FK_7A63CC08B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE telephones2 ADD CONSTRAINT FK_7A63CC08896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cercles DROP FOREIGN KEY FK_45C1718D98260155');
        $this->addSql('ALTER TABLE cercles DROP FOREIGN KEY FK_45C1718DB03A8386');
        $this->addSql('ALTER TABLE cercles DROP FOREIGN KEY FK_45C1718D896DBBDE');
        $this->addSql('ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A527413AB9');
        $this->addSql('ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A5B03A8386');
        $this->addSql('ALTER TABLE communes DROP FOREIGN KEY FK_5C5EE2A5896DBBDE');
        $this->addSql('ALTER TABLE lieu_naissances DROP FOREIGN KEY FK_49F8927F131A4F72');
        $this->addSql('ALTER TABLE lieu_naissances DROP FOREIGN KEY FK_49F8927FB03A8386');
        $this->addSql('ALTER TABLE lieu_naissances DROP FOREIGN KEY FK_49F8927F896DBBDE');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408AC8121CE9');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A58819F9E');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408AFDEF8996');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A9420D165');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A86957E8B');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408AB03A8386');
        $this->addSql('ALTER TABLE meres DROP FOREIGN KEY FK_2D8B408A896DBBDE');
        $this->addSql('ALTER TABLE ninas DROP FOREIGN KEY FK_51AD1AF23FD73900');
        $this->addSql('ALTER TABLE ninas DROP FOREIGN KEY FK_51AD1AF239DEC40E');
        $this->addSql('ALTER TABLE ninas DROP FOREIGN KEY FK_51AD1AF2B03A8386');
        $this->addSql('ALTER TABLE ninas DROP FOREIGN KEY FK_51AD1AF2896DBBDE');
        $this->addSql('ALTER TABLE noms DROP FOREIGN KEY FK_A069E65DB03A8386');
        $this->addSql('ALTER TABLE noms DROP FOREIGN KEY FK_A069E65D896DBBDE');
        $this->addSql('ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6A3FD73900');
        $this->addSql('ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6A39DEC40E');
        $this->addSql('ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6AB03A8386');
        $this->addSql('ALTER TABLE parents DROP FOREIGN KEY FK_FD501D6A896DBBDE');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9C8121CE9');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B958819F9E');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9FDEF8996');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B99420D165');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B986957E8B');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9B03A8386');
        $this->addSql('ALTER TABLE peres DROP FOREIGN KEY FK_B5FB13B9896DBBDE');
        $this->addSql('ALTER TABLE prenoms DROP FOREIGN KEY FK_E71162E3B03A8386');
        $this->addSql('ALTER TABLE prenoms DROP FOREIGN KEY FK_E71162E3896DBBDE');
        $this->addSql('ALTER TABLE professions DROP FOREIGN KEY FK_2FDA85FAB03A8386');
        $this->addSql('ALTER TABLE professions DROP FOREIGN KEY FK_2FDA85FA896DBBDE');
        $this->addSql('ALTER TABLE regions DROP FOREIGN KEY FK_A26779F3B03A8386');
        $this->addSql('ALTER TABLE regions DROP FOREIGN KEY FK_A26779F3896DBBDE');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE telephones1 DROP FOREIGN KEY FK_E36A9DB2B03A8386');
        $this->addSql('ALTER TABLE telephones1 DROP FOREIGN KEY FK_E36A9DB2896DBBDE');
        $this->addSql('ALTER TABLE telephones2 DROP FOREIGN KEY FK_7A63CC08B03A8386');
        $this->addSql('ALTER TABLE telephones2 DROP FOREIGN KEY FK_7A63CC08896DBBDE');
        $this->addSql('DROP TABLE cercles');
        $this->addSql('DROP TABLE communes');
        $this->addSql('DROP TABLE lieu_naissances');
        $this->addSql('DROP TABLE meres');
        $this->addSql('DROP TABLE ninas');
        $this->addSql('DROP TABLE noms');
        $this->addSql('DROP TABLE parents');
        $this->addSql('DROP TABLE peres');
        $this->addSql('DROP TABLE prenoms');
        $this->addSql('DROP TABLE professions');
        $this->addSql('DROP TABLE regions');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE telephones1');
        $this->addSql('DROP TABLE telephones2');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
