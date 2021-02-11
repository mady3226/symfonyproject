<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208015215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE concurrence (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT NOT NULL, etat_id INT NOT NULL, nom_id INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_E894F07858C065E (vendeur_id), INDEX IDX_E894F07D5E86FF (etat_id), INDEX IDX_E894F07C8121CE9 (nom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filtre (id INT AUTO_INCREMENT NOT NULL, produit VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE concurrence ADD CONSTRAINT FK_E894F07858C065E FOREIGN KEY (vendeur_id) REFERENCES vendeur (id)');
        $this->addSql('ALTER TABLE concurrence ADD CONSTRAINT FK_E894F07D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('ALTER TABLE concurrence ADD CONSTRAINT FK_E894F07C8121CE9 FOREIGN KEY (nom_id) REFERENCES produit (id)');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE registre');
        $this->addSql('DROP TABLE valise');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT NOT NULL, etat_id INT NOT NULL, nom_id INT NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_23A0E66D5E86FF (etat_id), INDEX IDX_23A0E66C8121CE9 (nom_id), INDEX IDX_23A0E66858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE registre (id INT AUTO_INCREMENT NOT NULL, prix DOUBLE PRECISION NOT NULL, vendeur VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, etat INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE valise (id INT AUTO_INCREMENT NOT NULL, prix_minimum INT NOT NULL, resultat INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66858C065E FOREIGN KEY (vendeur_id) REFERENCES vendeur (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C8121CE9 FOREIGN KEY (nom_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id)');
        $this->addSql('DROP TABLE concurrence');
        $this->addSql('DROP TABLE filtre');
    }
}
