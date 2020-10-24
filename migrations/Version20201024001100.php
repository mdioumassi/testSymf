<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201024001100 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE64584665A');
        $this->addSql('DROP INDEX IDX_2530ADE64584665A ON order_product');
        $this->addSql('ALTER TABLE order_product ADD products_id INT DEFAULT NULL, DROP product_id, CHANGE orders_id orders_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE66C8A81A9 FOREIGN KEY (products_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_2530ADE66C8A81A9 ON order_product (products_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_product DROP FOREIGN KEY FK_2530ADE66C8A81A9');
        $this->addSql('DROP INDEX IDX_2530ADE66C8A81A9 ON order_product');
        $this->addSql('ALTER TABLE order_product ADD product_id INT NOT NULL, DROP products_id, CHANGE orders_id orders_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_product ADD CONSTRAINT FK_2530ADE64584665A FOREIGN KEY (product_id) REFERENCES product (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_2530ADE64584665A ON order_product (product_id)');
    }
}
