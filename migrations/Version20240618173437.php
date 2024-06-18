<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240618173437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Seed the initial products';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO product (id, name) VALUES (uuid(), "Sildenafil 50mg")');
        $this->addSql('INSERT INTO product (id, name) VALUES (uuid(), "Sildenafil 100mg")');
        $this->addSql('INSERT INTO product (id, name) VALUES (uuid(), "Tadalafil 10mg")');
        $this->addSql('INSERT INTO product (id, name) VALUES (uuid(), "Tadalafil 20mg")');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM product WHERE name = "Sildenafil 50mg"');
        $this->addSql('DELETE FROM product WHERE name = "Sildenafil 100mg"');
        $this->addSql('DELETE FROM product WHERE name = "Tadalafil 10mg"');
        $this->addSql('DELETE FROM product WHERE name = "Tadalafil 20mg"');
    }
}
