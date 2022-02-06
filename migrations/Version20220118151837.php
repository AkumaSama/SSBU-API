<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220118151837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coup_speciaux (id VARCHAR(255) NOT NULL, personnage_id VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, pourcentages VARCHAR(255) NOT NULL, direction VARCHAR(255) NOT NULL, INDEX IDX_79ED4EEA5E315342 (personnage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE matchs (id VARCHAR(255) NOT NULL, personnage_joueur_id VARCHAR(255) NOT NULL, personnage_adversaire_id VARCHAR(255) NOT NULL, date DATETIME NOT NULL, gagner TINYINT(1) NOT NULL, INDEX IDX_6B1E604198FB72AC (personnage_joueur_id), INDEX IDX_6B1E60415D66515A (personnage_adversaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personnage (id VARCHAR(255) NOT NULL, univers_id VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, link_image VARCHAR(255) NOT NULL, INDEX IDX_6AEA486D1CF61C0B (univers_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE univers (id VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, link_image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE coup_speciaux ADD CONSTRAINT FK_79ED4EEA5E315342 FOREIGN KEY (personnage_id) REFERENCES personnage (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E604198FB72AC FOREIGN KEY (personnage_joueur_id) REFERENCES personnage (id)');
        $this->addSql('ALTER TABLE matchs ADD CONSTRAINT FK_6B1E60415D66515A FOREIGN KEY (personnage_adversaire_id) REFERENCES personnage (id)');
        $this->addSql('ALTER TABLE personnage ADD CONSTRAINT FK_6AEA486D1CF61C0B FOREIGN KEY (univers_id) REFERENCES univers (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coup_speciaux DROP FOREIGN KEY FK_79ED4EEA5E315342');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E604198FB72AC');
        $this->addSql('ALTER TABLE matchs DROP FOREIGN KEY FK_6B1E60415D66515A');
        $this->addSql('ALTER TABLE personnage DROP FOREIGN KEY FK_6AEA486D1CF61C0B');
        $this->addSql('DROP TABLE coup_speciaux');
        $this->addSql('DROP TABLE matchs');
        $this->addSql('DROP TABLE personnage');
        $this->addSql('DROP TABLE univers');
    }
}
