<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191004075217 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()
            ->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'ALTER TABLE customer ADD username VARCHAR(255) NOT NULL,
            DROP email, DROP roles, CHANGE password fullname VARCHAR(255) NOT NULL'
        );
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()
            ->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql(
            'ALTER TABLE customer ADD email VARCHAR(180) NOT NULL COLLATE utf8mb4_unicode_ci,
            ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci,
            DROP fullname, DROP username'
        );
    }
}
