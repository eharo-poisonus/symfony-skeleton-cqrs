<?php

declare(strict_types=1);

namespace Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241110151616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create user credentials table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE IF NOT EXISTS user_credentials (
                id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
                user VARCHAR(24) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS user_credentials');
    }
}
