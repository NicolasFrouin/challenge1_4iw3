<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240303222654 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE estimate (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, company_id INTEGER DEFAULT NULL, client_id INTEGER DEFAULT NULL, contact_id INTEGER DEFAULT NULL, signed BOOLEAN NOT NULL, status INTEGER NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_D2EA4607979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D2EA460719EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D2EA4607E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_D2EA4607979B1AD6 ON estimate (company_id)');
        $this->addSql('CREATE INDEX IDX_D2EA460719EB6921 ON estimate (client_id)');
        $this->addSql('CREATE INDEX IDX_D2EA4607E7A1254A ON estimate (contact_id)');
        $this->addSql('CREATE TABLE estimate_line (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER DEFAULT NULL, estimate_id INTEGER DEFAULT NULL, quantity INTEGER NOT NULL, description VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_9715EDF74584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_9715EDF785F23082 FOREIGN KEY (estimate_id) REFERENCES estimate (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_9715EDF74584665A ON estimate_line (product_id)');
        $this->addSql('CREATE INDEX IDX_9715EDF785F23082 ON estimate_line (estimate_id)');
        $this->addSql('ALTER TABLE invoice ADD COLUMN status INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE estimate');
        $this->addSql('DROP TABLE estimate_line');
        $this->addSql('CREATE TEMPORARY TABLE __temp__invoice AS SELECT id, client_id, company_id, contact_id, paid, paid_amount, created_by, updated_by, created_at, updated_at FROM invoice');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('CREATE TABLE invoice (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, client_id INTEGER DEFAULT NULL, company_id INTEGER DEFAULT NULL, contact_id INTEGER DEFAULT NULL, paid BOOLEAN NOT NULL, paid_amount INTEGER NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_9065174419EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_90651744979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_90651744E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO invoice (id, client_id, company_id, contact_id, paid, paid_amount, created_by, updated_by, created_at, updated_at) SELECT id, client_id, company_id, contact_id, paid, paid_amount, created_by, updated_by, created_at, updated_at FROM __temp__invoice');
        $this->addSql('DROP TABLE __temp__invoice');
        $this->addSql('CREATE INDEX IDX_9065174419EB6921 ON invoice (client_id)');
        $this->addSql('CREATE INDEX IDX_90651744979B1AD6 ON invoice (company_id)');
        $this->addSql('CREATE INDEX IDX_90651744E7A1254A ON invoice (contact_id)');
    }
}
