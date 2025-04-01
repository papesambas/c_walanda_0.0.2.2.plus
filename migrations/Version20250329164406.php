<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250329164406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absences ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE absences ADD CONSTRAINT FK_F9C0EFFFB03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE absences ADD CONSTRAINT FK_F9C0EFFF896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_F9C0EFFFB03A8386 ON absences (created_by_id)');
        $this->addSql('CREATE INDEX IDX_F9C0EFFF896DBBDE ON absences (updated_by_id)');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE indiscipline ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE indiscipline ADD CONSTRAINT FK_5AB8AB81B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE indiscipline ADD CONSTRAINT FK_5AB8AB81896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_5AB8AB81B03A8386 ON indiscipline (created_by_id)');
        $this->addSql('CREATE INDEX IDX_5AB8AB81896DBBDE ON indiscipline (updated_by_id)');
        $this->addSql('ALTER TABLE retards ADD created_by_id INT DEFAULT NULL, ADD updated_by_id INT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('ALTER TABLE retards ADD CONSTRAINT FK_AE8264E7B03A8386 FOREIGN KEY (created_by_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE retards ADD CONSTRAINT FK_AE8264E7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_AE8264E7B03A8386 ON retards (created_by_id)');
        $this->addSql('CREATE INDEX IDX_AE8264E7896DBBDE ON retards (updated_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE absences DROP FOREIGN KEY FK_F9C0EFFFB03A8386');
        $this->addSql('ALTER TABLE absences DROP FOREIGN KEY FK_F9C0EFFF896DBBDE');
        $this->addSql('DROP INDEX IDX_F9C0EFFFB03A8386 ON absences');
        $this->addSql('DROP INDEX IDX_F9C0EFFF896DBBDE ON absences');
        $this->addSql('ALTER TABLE absences DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug');
        $this->addSql('ALTER TABLE ecole_provenances CHANGE email email VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE indiscipline DROP FOREIGN KEY FK_5AB8AB81B03A8386');
        $this->addSql('ALTER TABLE indiscipline DROP FOREIGN KEY FK_5AB8AB81896DBBDE');
        $this->addSql('DROP INDEX IDX_5AB8AB81B03A8386 ON indiscipline');
        $this->addSql('DROP INDEX IDX_5AB8AB81896DBBDE ON indiscipline');
        $this->addSql('ALTER TABLE indiscipline DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug');
        $this->addSql('ALTER TABLE retards DROP FOREIGN KEY FK_AE8264E7B03A8386');
        $this->addSql('ALTER TABLE retards DROP FOREIGN KEY FK_AE8264E7896DBBDE');
        $this->addSql('DROP INDEX IDX_AE8264E7B03A8386 ON retards');
        $this->addSql('DROP INDEX IDX_AE8264E7896DBBDE ON retards');
        $this->addSql('ALTER TABLE retards DROP created_by_id, DROP updated_by_id, DROP created_at, DROP updated_at, DROP slug');
    }
}
