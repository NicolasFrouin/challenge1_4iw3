<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208102015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_company_id INTEGER NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_C744045532119A01 FOREIGN KEY (id_company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C744045532119A01 ON client (id_company_id)');
        $this->addSql('CREATE TABLE contact (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_client_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, zip_code VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_4C62E63899DED506 FOREIGN KEY (id_client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4C62E63899DED506 ON contact (id_client_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__company AS SELECT id, name, description, siret, premium, created_at FROM company');
        $this->addSql('DROP TABLE company');
        $this->addSql('CREATE TABLE company (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, siret VARCHAR(127) NOT NULL, premium BOOLEAN NOT NULL, created_at DATETIME NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO company (id, name, description, siret, premium, created_at) SELECT id, name, description, siret, premium, created_at FROM __temp__company');
        $this->addSql('DROP TABLE __temp__company');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, id_company_id, ref, name, description, tax_rate, price_no_tax, price_with_tax, weight, height, width, depth, stock, active, created_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_company_id INTEGER NOT NULL, ref VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, tax_rate DOUBLE PRECISION NOT NULL, price_no_tax INTEGER NOT NULL, price_with_tax INTEGER NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, depth DOUBLE PRECISION DEFAULT NULL, stock INTEGER NOT NULL, active BOOLEAN NOT NULL, created_at DATETIME NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_D34A04AD32119A01 FOREIGN KEY (id_company_id) REFERENCES company (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, id_company_id, ref, name, description, tax_rate, price_no_tax, price_with_tax, weight, height, width, depth, stock, active, created_at) SELECT id, id_company_id, ref, name, description, tax_rate, price_no_tax, price_with_tax, weight, height, width, depth, stock, active, created_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD32119A01 ON product (id_company_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, id_company_id, email, roles, password, is_verified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_company_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, created_by VARCHAR(255) DEFAULT NULL, updated_by VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, CONSTRAINT FK_8D93D64932119A01 FOREIGN KEY (id_company_id) REFERENCES company (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, id_company_id, email, roles, password, is_verified) SELECT id, id_company_id, email, roles, password, is_verified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE INDEX IDX_8D93D64932119A01 ON user (id_company_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE contact');
        $this->addSql('CREATE TEMPORARY TABLE __temp__company AS SELECT id, name, description, siret, premium, created_at FROM company');
        $this->addSql('DROP TABLE company');
        $this->addSql('CREATE TABLE company (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, created_by_id INTEGER DEFAULT NULL, modified_by_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, siret VARCHAR(127) NOT NULL, premium BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_4FBF094FB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4FBF094F99049ECE FOREIGN KEY (modified_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO company (id, name, description, siret, premium, created_at) SELECT id, name, description, siret, premium, created_at FROM __temp__company');
        $this->addSql('DROP TABLE __temp__company');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094F99049ECE ON company (modified_by_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4FBF094FB03A8386 ON company (created_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__product AS SELECT id, id_company_id, ref, name, description, tax_rate, price_no_tax, price_with_tax, weight, height, width, depth, stock, active, created_at FROM product');
        $this->addSql('DROP TABLE product');
        $this->addSql('CREATE TABLE product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_company_id INTEGER NOT NULL, created_by_id INTEGER DEFAULT NULL, modified_by_id INTEGER DEFAULT NULL, ref VARCHAR(255) NOT NULL, name VARCHAR(255) DEFAULT NULL, description CLOB DEFAULT NULL, tax_rate DOUBLE PRECISION NOT NULL, price_no_tax INTEGER NOT NULL, price_with_tax INTEGER NOT NULL, weight DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, depth DOUBLE PRECISION DEFAULT NULL, stock INTEGER NOT NULL, active BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_D34A04AD32119A01 FOREIGN KEY (id_company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D34A04ADB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D34A04AD99049ECE FOREIGN KEY (modified_by_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO product (id, id_company_id, ref, name, description, tax_rate, price_no_tax, price_with_tax, weight, height, width, depth, stock, active, created_at) SELECT id, id_company_id, ref, name, description, tax_rate, price_no_tax, price_with_tax, weight, height, width, depth, stock, active, created_at FROM __temp__product');
        $this->addSql('DROP TABLE __temp__product');
        $this->addSql('CREATE INDEX IDX_D34A04AD32119A01 ON product (id_company_id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADB03A8386 ON product (created_by_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD99049ECE ON product (modified_by_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, id_company_id, email, roles, password, is_verified FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_company_id INTEGER DEFAULT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, CONSTRAINT FK_8D93D64932119A01 FOREIGN KEY (id_company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, id_company_id, email, roles, password, is_verified) SELECT id, id_company_id, email, roles, password, is_verified FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE INDEX IDX_8D93D64932119A01 ON user (id_company_id)');
    }
}
