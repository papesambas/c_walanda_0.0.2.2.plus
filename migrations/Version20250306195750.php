<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250306195750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE telephones1 DROP FOREIGN KEY FK_E36A9DB2DBA63C52');
        $this->addSql('DROP INDEX UNIQ_E36A9DB2DBA63C52 ON telephones1');
        $this->addSql('ALTER TABLE telephones1 DROP telephones2_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE telephones1 ADD telephones2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE telephones1 ADD CONSTRAINT FK_E36A9DB2DBA63C52 FOREIGN KEY (telephones2_id) REFERENCES telephones2 (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E36A9DB2DBA63C52 ON telephones1 (telephones2_id)');
    }
}
