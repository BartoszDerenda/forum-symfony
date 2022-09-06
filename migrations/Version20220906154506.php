<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220906154506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5F675F31B');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5F675F31B FOREIGN KEY (author_id) REFERENCES users (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E27F6BF');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5F675F31B');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5F675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
    }
}
