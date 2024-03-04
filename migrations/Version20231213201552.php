<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231213201552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, modified_by_id INTEGER DEFAULT NULL, ref VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, tax_rate DOUBLE PRECISION NOT NULL, price_no_tax INTEGER NOT NULL, price_with_tax INTEGER NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, depth DOUBLE PRECISION DEFAULT NULL, stock INTEGER NOT NULL, active BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_D34A04ADB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D34A04AD99049ECE FOREIGN KEY (modified_by_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D34A04ADB03A8386 ON product (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD99049ECE ON product (modified_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
