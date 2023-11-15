<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111081238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE histoire (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, ref VARCHAR(255) NOT NULL, INDEX IDX_FD74CD68F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE magazine (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, ref VARCHAR(255) NOT NULL, INDEX IDX_378C2FE4F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE histoire ADD CONSTRAINT FK_FD74CD68F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE magazine ADD CONSTRAINT FK_378C2FE4F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE histoire DROP FOREIGN KEY FK_FD74CD68F675F31B');
        $this->addSql('ALTER TABLE magazine DROP FOREIGN KEY FK_378C2FE4F675F31B');
        $this->addSql('DROP TABLE histoire');
        $this->addSql('DROP TABLE magazine');
    }
}
