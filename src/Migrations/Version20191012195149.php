<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191012195149 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE blog_post (id UUID NOT NULL, title TEXT NOT NULL, status VARCHAR(16) NOT NULL, author UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN blog_post.id IS \'(DC2Type:blog_post_id)\'');
        $this->addSql('COMMENT ON COLUMN blog_post.status IS \'(DC2Type:blog_author_status)\'');
        $this->addSql('COMMENT ON COLUMN blog_post.author IS \'(DC2Type:blog_author_id)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE blog_post');
    }
}
