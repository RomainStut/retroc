<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180724103826 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE quality (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD quality_id INT NOT NULL, DROP quality');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5ABCFC6D57 FOREIGN KEY (quality_id) REFERENCES quality (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5ABCFC6D57 ON products (quality_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5ABCFC6D57');
        $this->addSql('DROP TABLE quality');
        $this->addSql('DROP INDEX IDX_B3BA5A5ABCFC6D57 ON products');
        $this->addSql('ALTER TABLE products ADD quality VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP quality_id');
    }
}