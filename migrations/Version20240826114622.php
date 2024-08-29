<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240826114622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE drink (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, alcool TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drink_ingredient (drink_id INT NOT NULL, ingredient_id INT NOT NULL, INDEX IDX_432CB60D36AA4BB4 (drink_id), INDEX IDX_432CB60D933FE08C (ingredient_id), PRIMARY KEY(drink_id, ingredient_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE drink_ingredients (id INT AUTO_INCREMENT NOT NULL, drink_id INT DEFAULT NULL, ingredient_id INT DEFAULT NULL, quantity VARCHAR(255) DEFAULT NULL, unit VARCHAR(255) DEFAULT NULL, INDEX IDX_65FC9F0036AA4BB4 (drink_id), INDEX IDX_65FC9F00933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etape (id INT AUTO_INCREMENT NOT NULL, drink_id INT NOT NULL, content VARCHAR(511) NOT NULL, INDEX IDX_285F75DD36AA4BB4 (drink_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ingredient (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, karmotrine TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE drink_ingredient ADD CONSTRAINT FK_432CB60D36AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE drink_ingredient ADD CONSTRAINT FK_432CB60D933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE drink_ingredients ADD CONSTRAINT FK_65FC9F0036AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id)');
        $this->addSql('ALTER TABLE drink_ingredients ADD CONSTRAINT FK_65FC9F00933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
        $this->addSql('ALTER TABLE etape ADD CONSTRAINT FK_285F75DD36AA4BB4 FOREIGN KEY (drink_id) REFERENCES drink (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE drink_ingredient DROP FOREIGN KEY FK_432CB60D36AA4BB4');
        $this->addSql('ALTER TABLE drink_ingredient DROP FOREIGN KEY FK_432CB60D933FE08C');
        $this->addSql('ALTER TABLE drink_ingredients DROP FOREIGN KEY FK_65FC9F0036AA4BB4');
        $this->addSql('ALTER TABLE drink_ingredients DROP FOREIGN KEY FK_65FC9F00933FE08C');
        $this->addSql('ALTER TABLE etape DROP FOREIGN KEY FK_285F75DD36AA4BB4');
        $this->addSql('DROP TABLE drink');
        $this->addSql('DROP TABLE drink_ingredient');
        $this->addSql('DROP TABLE drink_ingredients');
        $this->addSql('DROP TABLE etape');
        $this->addSql('DROP TABLE ingredient');
    }
}
