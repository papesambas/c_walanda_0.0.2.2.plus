<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250318165324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE santes (id INT AUTO_INCREMENT NOT NULL, eleve_id INT NOT NULL, maladie VARCHAR(130) NOT NULL, medecin VARCHAR(50) DEFAULT NULL, numero_urgence VARCHAR(25) NOT NULL, centre_sante VARCHAR(150) DEFAULT NULL, INDEX IDX_C1A17FE9A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE santes ADD CONSTRAINT FK_C1A17FE9A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE santes DROP FOREIGN KEY FK_C1A17FE9A6CC7B2');
        $this->addSql('DROP TABLE santes');
    }
}
