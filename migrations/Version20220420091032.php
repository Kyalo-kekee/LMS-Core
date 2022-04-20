<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420091032 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mshuleuser ADD StudentId VARCHAR(255) DEFAULT NULL, ADD ClassId VARCHAR(255) DEFAULT NULL, CHANGE EmployeeNumber EmployeeNumber VARCHAR(122) DEFAULT NULL, CHANGE Salutation Salutation VARCHAR(4) DEFAULT NULL, CHANGE Designation Designation VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE MshuleUser DROP StudentId, DROP ClassId, CHANGE EmployeeNumber EmployeeNumber VARCHAR(122) NOT NULL, CHANGE Salutation Salutation VARCHAR(4) NOT NULL, CHANGE Designation Designation VARCHAR(100) NOT NULL');
    }
}
