<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109115650 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cmd ADD user VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE cmd_client CHANGE cl_slug cl_slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE depense ADD slug VARCHAR(255) NOT NULL, ADD user VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cmd DROP user');
        $this->addSql('ALTER TABLE cmd_client CHANGE cl_slug cl_slug VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE depense DROP slug, DROP user');
    }
}
