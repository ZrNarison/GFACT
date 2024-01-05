<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240105062854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depense (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, qte DOUBLE PRECISION DEFAULT NULL, prix_unitaire DOUBLE PRECISION DEFAULT NULL, date_dps DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cmd DROP annees, DROP mois');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE depense');
        $this->addSql('ALTER TABLE cmd ADD annees VARCHAR(255) NOT NULL, ADD mois VARCHAR(255) NOT NULL');
    }
}
