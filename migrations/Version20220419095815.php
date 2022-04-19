<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220419095815 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ClassHeader (id INT AUTO_INCREMENT NOT NULL, ClassName VARCHAR(255) NOT NULL, MaximumStudentCapacity INT NOT NULL, MinimumStudentCapacity INT NOT NULL, HasStreams TINYINT(1) DEFAULT NULL, ClassTeacher VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_83ADEF8A4702329D (ClassName), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ClassHeaderDetails (id INT AUTO_INCREMENT NOT NULL, ClassID VARCHAR(255) NOT NULL, SectionID VARCHAR(255) NOT NULL, MaxStudents INT NOT NULL, MinStudents INT NOT NULL, ClassPrefect VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1B46C0FFA14BBEB (SectionID), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE CompaniesNextNumbers (id INT AUTO_INCREMENT NOT NULL, CompaniesNextNumbers VARCHAR(100) NOT NULL, Prefix VARCHAR(5) NOT NULL, NextNumberValue VARCHAR(10) NOT NULL, EntityClass VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE InstitutionSetup (Id VARCHAR(255) NOT NULL, IDInitials VARCHAR(22) NOT NULL, Name VARCHAR(255) NOT NULL, CellPhone1 VARCHAR(13) NOT NULL, CellPhone2 VARCHAR(13) DEFAULT NULL, Email VARCHAR(255) DEFAULT NULL, WebsiteURl VARCHAR(255) DEFAULT NULL, LogoURL VARCHAR(255) DEFAULT NULL, NoOfLevels INT NOT NULL, NoOfStreamsPerLevel INT NOT NULL, Zip VARCHAR(10) DEFAULT NULL, City VARCHAR(10) DEFAULT NULL, State VARCHAR(10) DEFAULT NULL, PRIMARY KEY(Id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE MshuleUser (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON DEFAULT NULL, password VARCHAR(255) NOT NULL, FirstName VARCHAR(22) NOT NULL, MiddleName VARCHAR(22) DEFAULT NULL, LastName VARCHAR(22) DEFAULT NULL, EmployeeNumber VARCHAR(122) NOT NULL, Salutation VARCHAR(4) NOT NULL, IsEmployee TINYINT(1) DEFAULT NULL, Designation VARCHAR(100) NOT NULL, Email VARCHAR(255) NOT NULL, isVerified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_DEBFCE83F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ClassHeader');
        $this->addSql('DROP TABLE ClassHeaderDetails');
        $this->addSql('DROP TABLE CompaniesNextNumbers');
        $this->addSql('DROP TABLE InstitutionSetup');
        $this->addSql('DROP TABLE MshuleUser');
    }
}
