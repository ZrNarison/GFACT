<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420010018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cmd CHANGE quantite quantite INT NOT NULL, CHANGE prixunitaire prixunitaire INT NOT NULL, CHANGE datecmd datecmd DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cmd CHANGE quantite quantite VARCHAR(255) NOT NULL, CHANGE prixunitaire prixunitaire VARCHAR(255) NOT NULL, CHANGE datecmd datecmd VARCHAR(255) NOT NULL');
    }
}
