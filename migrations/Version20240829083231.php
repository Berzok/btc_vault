<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240829083231 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE drink_ingredient DROP FOREIGN KEY FK_432CB60D36AA4BB4');
        $this->addSql('ALTER TABLE drink_ingredient DROP FOREIGN KEY FK_432CB60D933FE08C');
        $this->addSql('DROP TABLE drink_ingredient');
        $this->addSql('ALTER TABLE drink ADD description VARCHAR(255) NOT NULL, DROP alcool');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE drink_ingredient (drink_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_432CB60D933FE08C (ingredient_id), INDEX IDX_432CB60D36AA4BB4 (drink_id), PRIMARY KEY(drink_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE drink_ingredient ADD CONSTRAINT FK_432CB60D36AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE drink_ingredient ADD CONSTRAINT FK_432CB60D933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE drink ADD alcool TINYINT(1) NOT NULL, DROP description');
    }
}
