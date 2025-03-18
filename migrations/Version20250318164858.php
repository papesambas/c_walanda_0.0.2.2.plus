<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250318164858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE departs (id INT AUTO_INCREMENT NOT NULL, eleve_id INT NOT NULL, date_depart DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ecole_destination VARCHAR(130) DEFAULT NULL, INDEX IDX_15CE7982A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE departs ADD CONSTRAINT FK_15CE7982A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departs DROP FOREIGN KEY FK_15CE7982A6CC7B2');
        $this->addSql('DROP TABLE departs');
    }
}
