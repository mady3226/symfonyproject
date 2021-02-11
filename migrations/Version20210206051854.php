<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210206051854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD nom_id INT NOT NULL, DROP nom');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C8121CE9 FOREIGN KEY (nom_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66C8121CE9 ON article (nom_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66C8121CE9');
        $this->addSql('DROP INDEX IDX_23A0E66C8121CE9 ON article');
        $this->addSql('ALTER TABLE article ADD nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP nom_id');
    }
}
