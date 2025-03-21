<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320080226 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stat (id INT AUTO_INCREMENT NOT NULL, count INT NOT NULL, number_limit INT NOT NULL, number1 INT NOT NULL, number2 INT NOT NULL, string1 VARCHAR(200) NOT NULL, string2 VARCHAR(200) NOT NULL, INDEX idx_stat_number_limit (number_limit), INDEX idx_stat_number1 (number1), INDEX idx_stat_number2 (number2), INDEX idx_stat_string1 (string1), INDEX idx_stat_string2 (string2), INDEX idx_stat_count (count), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE stat');
    }
}
