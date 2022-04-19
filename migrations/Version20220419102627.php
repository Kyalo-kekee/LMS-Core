<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419102627 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE AssignmentHeader (id INT AUTO_INCREMENT NOT NULL, AssignmentName VARCHAR(255) NOT NULL, ModuleId VARCHAR(255) NOT NULL, Content VARCHAR(255) NOT NULL, attachment VARCHAR(255) NOT NULL, SubmitBefore DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE CourseHeader (id INT AUTO_INCREMENT NOT NULL, CourseName VARCHAR(255) NOT NULL, CourseDuration DATETIME NOT NULL, CourserTutor VARCHAR(255) NOT NULL, ClassId VARCHAR(255) NOT NULL, IsActive TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE CourseHeaderDetails (id INT AUTO_INCREMENT NOT NULL, CourseId INT NOT NULL, ModuleName VARCHAR(255) NOT NULL, ModuleDecription LONGTEXT NOT NULL, ModuleContent VARCHAR(255) NOT NULL, ModuleDuration DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE LmsUserRoles (id INT AUTO_INCREMENT NOT NULL, RoleName VARCHAR(255) NOT NULL, IsEnabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE StudentAssignmentHeader (id INT AUTO_INCREMENT NOT NULL, ModuleId VARCHAR(255) NOT NULL, StudentScore INT DEFAULT NULL, Content LONGTEXT DEFAULT NULL, Attachment VARCHAR(255) DEFAULT NULL, SubmitDate DATETIME NOT NULL, StudentId VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE AssignmentHeader');
        $this->addSql('DROP TABLE CourseHeader');
        $this->addSql('DROP TABLE CourseHeaderDetails');
        $this->addSql('DROP TABLE LmsUserRoles');
        $this->addSql('DROP TABLE StudentAssignmentHeader');
    }
}
