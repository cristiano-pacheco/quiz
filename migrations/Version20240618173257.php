<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240618173257 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the product table';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            CREATE TABLE `product` (
              `id` uuid NOT NULL,
              `name` varchar(255) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE product');
    }
}
