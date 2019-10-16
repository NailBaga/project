<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191014193756 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE user_users ALTER name_first DROP NOT NULL');
        $this->addSql('ALTER TABLE user_users ALTER name_last DROP NOT NULL');
        $this->addSql('ALTER TABLE blog_post ALTER status TYPE VARCHAR(16)');
        $this->addSql('ALTER TABLE blog_post ALTER status DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_users ALTER name_first SET NOT NULL');
        $this->addSql('ALTER TABLE user_users ALTER name_last SET NOT NULL');
        $this->addSql('ALTER TABLE blog_post ALTER status TYPE VARCHAR(16)');
        $this->addSql('ALTER TABLE blog_post ALTER status DROP DEFAULT');
    }
}
