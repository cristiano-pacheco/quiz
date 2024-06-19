<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240618172811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the answer table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE `answer` (
              `id` uuid NOT NULL,
              `question_id` uuid NOT NULL,
              `answer` varchar(255) NOT NULL,
              `sort_order` int NOT NULL,
              `behavior` varchar(32) NOT NULL,
              `restriction` varchar(32) NOT NULL,
              `question_to_ask` uuid DEFAULT NULL,
              `excluded_product_ids` json DEFAULT NULL,
              `recommended_product_ids` json DEFAULT NULL,
              `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
              PRIMARY KEY (`id`),
              KEY `answer_FK` (`question_id`),
              CONSTRAINT `answer_FK` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE answer');
    }
}
