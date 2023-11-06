<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231106161024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create User table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            CREATE TABLE "user" (
                id VARCHAR(36) NOT NULL PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(100) NOT NULL,
                password VARCHAR(50) NOT NULL,
                avatar VARCHAR(255) DEFAULT NULL,
                token VARCHAR(100) DEFAULT NULL,
                reset_password_token VARCHAR(100) DEFAULT NULL,
                active BOOLEAN NOT NULL,
                created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now(),
                updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT now()
        )');
        $this->addSql('CREATE INDEX IDX_user_name ON "user" (name)');
        $this->addSql('CREATE UNIQUE INDEX U_user_email ON "user" (email)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE "user"');
    }
}
