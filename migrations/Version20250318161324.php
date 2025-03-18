<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250318161324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_eleves ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE dossier_eleves ADD CONSTRAINT FK_D04A5D98B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE dossier_eleves ADD CONSTRAINT FK_D04A5D98896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_D04A5D98B03A8386 ON dossier_eleves (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D04A5D98896DBBDE ON dossier_eleves (updated_by_id)');
        $this->addSql('ALTER TABLE users ADD eleve_id INT DEFAULT NULL, ADD fullname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1483A5E9A6CC7B2 ON users (eleve_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_eleves DROP FOREIGN KEY FK_D04A5D98B03A8386');
        $this->addSql('ALTER TABLE dossier_eleves DROP FOREIGN KEY FK_D04A5D98896DBBDE');
        $this->addSql('DROP INDEX IDX_D04A5D98B03A8386 ON dossier_eleves');
        $this->addSql('DROP INDEX IDX_D04A5D98896DBBDE ON dossier_eleves');
        $this->addSql('ALTER TABLE dossier_eleves DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9A6CC7B2');
        $this->addSql('DROP INDEX UNIQ_1483A5E9A6CC7B2 ON users');
        $this->addSql('ALTER TABLE users DROP eleve_id, DROP fullname');
    }
}
