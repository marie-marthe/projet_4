<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180201103103 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket ADD booking_id INT NOT NULL');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA33301C60 FOREIGN KEY (booking_id) REFERENCES booking (id)');
        $this->addSql('CREATE INDEX IDX_97A0ADA33301C60 ON ticket (booking_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA33301C60');
        $this->addSql('DROP INDEX IDX_97A0ADA33301C60 ON ticket');
        $this->addSql('ALTER TABLE ticket DROP booking_id');
    }
}
