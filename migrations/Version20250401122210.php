<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401122210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personnels ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD image_name VARCHAR(255) DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2BB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE personnels ADD CONSTRAINT FK_7AC38C2B896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_7AC38C2BB03A8386 ON personnels (created_by_id)');
        $this->addSql('CREATE INDEX IDX_7AC38C2B896DBBDE ON personnels (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2BB03A8386');
        $this->addSql('ALTER TABLE personnels DROP FOREIGN KEY FK_7AC38C2B896DBBDE');
        $this->addSql('DROP INDEX IDX_7AC38C2BB03A8386 ON personnels');
        $this->addSql('DROP INDEX IDX_7AC38C2B896DBBDE ON personnels');
        $this->addSql('ALTER TABLE personnels DROP created_by_id, DROP updated_by_id, DROP image_name, DROP created_at, DROP updated_at, DROP slug');
    }
}
