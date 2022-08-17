<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220816202606 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uq_categories_title ON categories');
        $this->addSql('ALTER TABLE categories CHANGE slug slug VARCHAR(64) NOT NULL');
        $this->addSql('ALTER TABLE tags ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD slug VARCHAR(32) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories CHANGE slug slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uq_categories_title ON categories (title)');
        $this->addSql('ALTER TABLE tags DROP created_at, DROP updated_at, DROP slug');
    }
}
