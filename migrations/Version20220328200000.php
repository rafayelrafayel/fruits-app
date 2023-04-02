<?php
// database/migrations/Version20220328200000.php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20220328200000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create fruit table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE fruit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL,  nutritions JSON DEFAULT NULL, createdAt DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE fruit');
    }
}
