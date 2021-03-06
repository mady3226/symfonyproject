<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208022511 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55CAF7626C6E55B5 ON etat (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55CAF7627AC30186 ON etat (synonyme)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_29A5EC276C6E55B5 ON produit (nom)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_55CAF7626C6E55B5 ON etat');
        $this->addSql('DROP INDEX UNIQ_55CAF7627AC30186 ON etat');
        $this->addSql('DROP INDEX UNIQ_29A5EC276C6E55B5 ON produit');
    }
}
