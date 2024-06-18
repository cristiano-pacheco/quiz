<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240618172646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the question table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE `question` (
              `id` uuid NOT NULL,
              `quiz_id` uuid NOT NULL,
              `question` varchar(500) NOT NULL,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`id`),
              KEY `question_FK` (`quiz_id`),
              CONSTRAINT `question_FK` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE question');
    }
}
