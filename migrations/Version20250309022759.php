<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250309022759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves ADD is_actif TINYINT(1) NOT NULL, ADD is_allowed TINYINT(1) NOT NULL, ADD is_admin TINYINT(1) NOT NULL, ADD is_handicap TINYINT(1) NOT NULL, ADD nature_handicape VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eleves DROP is_actif, DROP is_allowed, DROP is_admin, DROP is_handicap, DROP nature_handicape');
    }
}
