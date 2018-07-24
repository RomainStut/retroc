<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180724075908 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE products (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, user_id INT NOT NULL, type_id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, quality VARCHAR(255) NOT NULL, datepost DATETIME NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) DEFAULT NULL, isvalidate TINYINT(1) NOT NULL, INDEX IDX_B3BA5A5ABCF5E72D (categorie_id), INDEX IDX_B3BA5A5AA76ED395 (user_id), INDEX IDX_B3BA5A5AC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5ABCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('DROP TABLE arcade');
        $this->addSql('DROP TABLE goodies');
        $this->addSql('DROP TABLE nextgen');
        $this->addSql('DROP TABLE retro');
        $this->addSql('ALTER TABLE categories CHANGE name name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AC54C8C93');
        $this->addSql('CREATE TABLE arcade (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, price INT NOT NULL, quality VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, datepost DATETIME NOT NULL, description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, image VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, is_validate TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_ADB70C7DBCF5E72D (categorie_id), INDEX IDX_ADB70C7DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE goodies (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, price INT NOT NULL, quality VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, datepost DATETIME NOT NULL, description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, image VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, is_validate TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_1379DF99BCF5E72D (categorie_id), INDEX IDX_1379DF99A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nextgen (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, price INT NOT NULL, quality VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, datepost DATETIME NOT NULL, description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, image VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, is_validate TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_CC3BE4F2BCF5E72D (categorie_id), INDEX IDX_CC3BE4F2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retro (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, user_id INT NOT NULL, name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, price INT NOT NULL, quality VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci, datepost DATETIME NOT NULL, description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, image VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci, is_validate TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_DA34E4B2BCF5E72D (categorie_id), INDEX IDX_DA34E4B2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE arcade ADD CONSTRAINT FK_ADB70C7DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE arcade ADD CONSTRAINT FK_ADB70C7DBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE goodies ADD CONSTRAINT FK_1379DF99A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE goodies ADD CONSTRAINT FK_1379DF99BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE nextgen ADD CONSTRAINT FK_CC3BE4F2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE nextgen ADD CONSTRAINT FK_CC3BE4F2BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE retro ADD CONSTRAINT FK_DA34E4B2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE retro ADD CONSTRAINT FK_DA34E4B2BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categories (id)');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE type');
        $this->addSql('ALTER TABLE categories CHANGE name name VARCHAR(50) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
