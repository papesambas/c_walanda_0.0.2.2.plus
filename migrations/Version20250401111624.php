<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401111624 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE niveau_etudes ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD designation VARCHAR(130) NOT NULL, ADD slug VARCHAR(128) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE niveau_etudes ADD CONSTRAINT FK_832456ECB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE niveau_etudes ADD CONSTRAINT FK_832456EC896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_832456ECB03A8386 ON niveau_etudes (created_by_id)');
        $this->addSql('CREATE INDEX IDX_832456EC896DBBDE ON niveau_etudes (updated_by_id)');
        $this->addSql('ALTER TABLE specialites ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD designation VARCHAR(130) NOT NULL, ADD slug VARCHAR(128) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE specialites ADD CONSTRAINT FK_F78AEBD1B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE specialites ADD CONSTRAINT FK_F78AEBD1896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_F78AEBD1B03A8386 ON specialites (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F78AEBD1896DBBDE ON specialites (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE niveau_etudes DROP FOREIGN KEY FK_832456ECB03A8386');
        $this->addSql('ALTER TABLE niveau_etudes DROP FOREIGN KEY FK_832456EC896DBBDE');
        $this->addSql('DROP INDEX IDX_832456ECB03A8386 ON niveau_etudes');
        $this->addSql('DROP INDEX IDX_832456EC896DBBDE ON niveau_etudes');
        $this->addSql('ALTER TABLE niveau_etudes DROP created_by_id, DROP updated_by_id, DROP designation, DROP slug, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE specialites DROP FOREIGN KEY FK_F78AEBD1B03A8386');
        $this->addSql('ALTER TABLE specialites DROP FOREIGN KEY FK_F78AEBD1896DBBDE');
        $this->addSql('DROP INDEX IDX_F78AEBD1B03A8386 ON specialites');
        $this->addSql('DROP INDEX IDX_F78AEBD1896DBBDE ON specialites');
        $this->addSql('ALTER TABLE specialites DROP created_by_id, DROP updated_by_id, DROP designation, DROP slug, DROP created_at, DROP updated_at');
    }
}
