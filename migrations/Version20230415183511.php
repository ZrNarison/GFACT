<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230415183511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, nom_cl VARCHAR(255) NOT NULL, adress VARCHAR(255) DEFAULT NULL, tel VARCHAR(255) DEFAULT NULL, stat VARCHAR(255) DEFAULT NULL, nif VARCHAR(255) DEFAULT NULL, rcs VARCHAR(255) DEFAULT NULL, rib VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cmd (id INT AUTO_INCREMENT NOT NULL, cmd_client_id INT DEFAULT NULL, design VARCHAR(255) NOT NULL, prd VARCHAR(255) DEFAULT NULL, duree VARCHAR(255) DEFAULT NULL, qte VARCHAR(255) NOT NULL, pu VARCHAR(255) NOT NULL, dt_cmd VARCHAR(255) NOT NULL, cm_slug VARCHAR(255) DEFAULT NULL, INDEX IDX_2F5C1CC05D40D804 (cmd_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cmd_client (id INT AUTO_INCREMENT NOT NULL, client_id INT DEFAULT NULL, ncmd VARCHAR(255) DEFAULT NULL, cclient VARCHAR(255) DEFAULT NULL, dos VARCHAR(255) DEFAULT NULL, dif VARCHAR(255) DEFAULT NULL, cl_slug VARCHAR(255) DEFAULT NULL, INDEX IDX_83CC231F19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE params (id INT AUTO_INCREMENT NOT NULL, std VARCHAR(255) NOT NULL, frq VARCHAR(255) NOT NULL, padres VARCHAR(255) NOT NULL, bp VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, telp VARCHAR(255) NOT NULL, pnif VARCHAR(255) NOT NULL, pstat VARCHAR(255) NOT NULL, prib VARCHAR(255) NOT NULL, tp VARCHAR(255) NOT NULL, fstd VARCHAR(255) NOT NULL, pslug VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_user (role_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_332CA4DDD60322AC (role_id), INDEX IDX_332CA4DDA76ED395 (user_id), PRIMARY KEY(role_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, picture VARCHAR(255) DEFAULT NULL, uslug VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cmd ADD CONSTRAINT FK_2F5C1CC05D40D804 FOREIGN KEY (cmd_client_id) REFERENCES cmd_client (id)');
        $this->addSql('ALTER TABLE cmd_client ADD CONSTRAINT FK_83CC231F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDD60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_user ADD CONSTRAINT FK_332CA4DDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cmd_client DROP FOREIGN KEY FK_83CC231F19EB6921');
        $this->addSql('ALTER TABLE cmd DROP FOREIGN KEY FK_2F5C1CC05D40D804');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDD60322AC');
        $this->addSql('ALTER TABLE role_user DROP FOREIGN KEY FK_332CA4DDA76ED395');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE cmd');
        $this->addSql('DROP TABLE cmd_client');
        $this->addSql('DROP TABLE params');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_user');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
