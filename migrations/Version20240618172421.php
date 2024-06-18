<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240618172421 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates the quiz table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE `quiz` (
              `id` uuid NOT NULL,
              `name` varchar(255) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE quiz');
    }
}
