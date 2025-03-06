<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250306202740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C5EE2A58947610D ON communes (designation)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_49F8927F8947610D ON lieu_naissances (designation)');
        $this->addSql('ALTER TABLE meres ADD fullname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE peres ADD fullname VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE prenoms CHANGE designation designation VARCHAR(130) NOT NULL');
        $this->addSql('ALTER TABLE professions CHANGE designation designation VARCHAR(130) NOT NULL');
        $this->addSql('ALTER TABLE regions RENAME INDEX uniq_a26779f38947610d TO UNIQ_REGION_DESIGNATION');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_5C5EE2A58947610D ON communes');
        $this->addSql('ALTER TABLE peres DROP fullname');
        $this->addSql('DROP INDEX UNIQ_49F8927F8947610D ON lieu_naissances');
        $this->addSql('ALTER TABLE meres DROP fullname');
        $this->addSql('ALTER TABLE regions RENAME INDEX uniq_region_designation TO UNIQ_A26779F38947610D');
        $this->addSql('ALTER TABLE professions CHANGE designation designation VARCHAR(75) NOT NULL');
        $this->addSql('ALTER TABLE prenoms CHANGE designation designation VARCHAR(75) NOT NULL');
    }
}
