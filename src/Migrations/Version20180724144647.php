<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180724144647 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96A76ED395');
        $this->addSql('DROP INDEX IDX_DB021E96A76ED395 ON messages');
        $this->addSql('ALTER TABLE messages ADD expediteur_id INT NOT NULL, ADD destinataire_id INT NOT NULL, CHANGE user_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E964584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9610335F61 FOREIGN KEY (expediteur_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A4F84F6E FOREIGN KEY (destinataire_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_DB021E964584665A ON messages (product_id)');
        $this->addSql('CREATE INDEX IDX_DB021E9610335F61 ON messages (expediteur_id)');
        $this->addSql('CREATE INDEX IDX_DB021E96A4F84F6E ON messages (destinataire_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E964584665A');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9610335F61');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96A4F84F6E');
        $this->addSql('DROP INDEX IDX_DB021E964584665A ON messages');
        $this->addSql('DROP INDEX IDX_DB021E9610335F61 ON messages');
        $this->addSql('DROP INDEX IDX_DB021E96A4F84F6E ON messages');
        $this->addSql('ALTER TABLE messages ADD user_id INT NOT NULL, DROP product_id, DROP expediteur_id, DROP destinataire_id');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_DB021E96A76ED395 ON messages (user_id)');
    }
}
