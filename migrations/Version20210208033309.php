<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210208033309 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_55CAF7627AC30186 ON etat');
        $this->addSql('ALTER TABLE etat CHANGE synonyme valeur INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55CAF7621B44CD51 ON etat (valeur)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_55CAF7621B44CD51 ON etat');
        $this->addSql('ALTER TABLE etat CHANGE valeur synonyme INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_55CAF7627AC30186 ON etat (synonyme)');
    }
}
