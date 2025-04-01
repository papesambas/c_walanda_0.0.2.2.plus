<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401124211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrats ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL, ADD designation VARCHAR(130) NOT NULL');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396CB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE contrats ADD CONSTRAINT FK_7268396C896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_7268396CB03A8386 ON contrats (created_by_id)');
        $this->addSql('CREATE INDEX IDX_7268396C896DBBDE ON contrats (updated_by_id)');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE indiscipline_personnel ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE indiscipline_personnel ADD CONSTRAINT FK_6A05726B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE indiscipline_personnel ADD CONSTRAINT FK_6A05726896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_6A05726B03A8386 ON indiscipline_personnel (created_by_id)');
        $this->addSql('CREATE INDEX IDX_6A05726896DBBDE ON indiscipline_personnel (updated_by_id)');
        $this->addSql('ALTER TABLE retards_personnel ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE retards_personnel ADD CONSTRAINT FK_391BBEF7B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE retards_personnel ADD CONSTRAINT FK_391BBEF7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_391BBEF7B03A8386 ON retards_personnel (created_by_id)');
        $this->addSql('CREATE INDEX IDX_391BBEF7896DBBDE ON retards_personnel (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396CB03A8386');
        $this->addSql('ALTER TABLE contrats DROP FOREIGN KEY FK_7268396C896DBBDE');
        $this->addSql('DROP INDEX IDX_7268396CB03A8386 ON contrats');
        $this->addSql('DROP INDEX IDX_7268396C896DBBDE ON contrats');
        $this->addSql('ALTER TABLE contrats DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug, DROP designation');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE indiscipline_personnel DROP FOREIGN KEY FK_6A05726B03A8386');
        $this->addSql('ALTER TABLE indiscipline_personnel DROP FOREIGN KEY FK_6A05726896DBBDE');
        $this->addSql('DROP INDEX IDX_6A05726B03A8386 ON indiscipline_personnel');
        $this->addSql('DROP INDEX IDX_6A05726896DBBDE ON indiscipline_personnel');
        $this->addSql('ALTER TABLE indiscipline_personnel DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug');
        $this->addSql('ALTER TABLE retards_personnel DROP FOREIGN KEY FK_391BBEF7B03A8386');
        $this->addSql('ALTER TABLE retards_personnel DROP FOREIGN KEY FK_391BBEF7896DBBDE');
        $this->addSql('DROP INDEX IDX_391BBEF7B03A8386 ON retards_personnel');
        $this->addSql('DROP INDEX IDX_391BBEF7896DBBDE ON retards_personnel');
        $this->addSql('ALTER TABLE retards_personnel DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug');
    }
}
