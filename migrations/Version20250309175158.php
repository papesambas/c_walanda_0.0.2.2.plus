<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250309175158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scolarites1 ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE scolarites1 ADD CONSTRAINT FK_328D2B44B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE scolarites1 ADD CONSTRAINT FK_328D2B44896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_328D2B44B03A8386 ON scolarites1 (created_by_id)');
        $this->addSql('CREATE INDEX IDX_328D2B44896DBBDE ON scolarites1 (updated_by_id)');
        $this->addSql('ALTER TABLE scolarites2 ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE scolarites2 ADD CONSTRAINT FK_AB847AFEB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE scolarites2 ADD CONSTRAINT FK_AB847AFE896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_AB847AFEB03A8386 ON scolarites2 (created_by_id)');
        $this->addSql('CREATE INDEX IDX_AB847AFE896DBBDE ON scolarites2 (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scolarites1 DROP FOREIGN KEY FK_328D2B44B03A8386');
        $this->addSql('ALTER TABLE scolarites1 DROP FOREIGN KEY FK_328D2B44896DBBDE');
        $this->addSql('DROP INDEX IDX_328D2B44B03A8386 ON scolarites1');
        $this->addSql('DROP INDEX IDX_328D2B44896DBBDE ON scolarites1');
        $this->addSql('ALTER TABLE scolarites1 DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE scolarites2 DROP FOREIGN KEY FK_AB847AFEB03A8386');
        $this->addSql('ALTER TABLE scolarites2 DROP FOREIGN KEY FK_AB847AFE896DBBDE');
        $this->addSql('DROP INDEX IDX_AB847AFEB03A8386 ON scolarites2');
        $this->addSql('DROP INDEX IDX_AB847AFE896DBBDE ON scolarites2');
        $this->addSql('ALTER TABLE scolarites2 DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at');
    }
}
