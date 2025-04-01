<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329163938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE indiscipline (id INT AUTO_INCREMENT NOT NULL, eleve_id INT NOT NULL, annee_scolaire_id INT NOT NULL, jour DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', description LONGTEXT NOT NULL, is_sanction TINYINT(1) NOT NULL, sanction VARCHAR(255) DEFAULT NULL, INDEX IDX_5AB8AB81A6CC7B2 (eleve_id), INDEX IDX_5AB8AB819331C741 (annee_scolaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE indiscipline ADD CONSTRAINT FK_5AB8AB81A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleves (id)');
        $this->addSql('ALTER TABLE indiscipline ADD CONSTRAINT FK_5AB8AB819331C741 FOREIGN KEY (annee_scolaire_id) REFERENCES annee_scolaires (id)');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE indiscipline DROP FOREIGN KEY FK_5AB8AB81A6CC7B2');
        $this->addSql('ALTER TABLE indiscipline DROP FOREIGN KEY FK_5AB8AB819331C741');
        $this->addSql('DROP TABLE indiscipline');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
    }
}
