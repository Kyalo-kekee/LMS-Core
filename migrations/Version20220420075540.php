<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420075540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignmentheader ADD AttachmentSize INT DEFAULT NULL, ADD UpdatedAt DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD ClassId VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE courseheaderdetails ADD ModuleAttachment VARCHAR(255) NOT NULL, ADD AttachmentSize INT DEFAULT NULL, ADD UpdatedAt DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE ModuleDecription ModuleDescription LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE studentassignmentheader ADD UpdatedAt DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE StudentScore AttachmentSize INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE AssignmentHeader DROP AttachmentSize, DROP UpdatedAt, DROP ClassId');
        $this->addSql('ALTER TABLE CourseHeaderDetails DROP ModuleAttachment, DROP AttachmentSize, DROP UpdatedAt, CHANGE ModuleDescription ModuleDecription LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE StudentAssignmentHeader DROP UpdatedAt, CHANGE AttachmentSize StudentScore INT DEFAULT NULL');
    }
}
