<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221114164900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY fk_Movie_has_Type_Movie1');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY fk_Movie_has_Type_Type1');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FB8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FBC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX idx_d7417fb76e5d4aa TO IDX_D7417FB8F93B6FC');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX fk_movie_has_type_type1 TO IDX_D7417FBC54C8C93');
        $this->addSql('ALTER TABLE movie_has_people ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE movie_has_people RENAME INDEX fk_movie_has_people_people1 TO IDX_EDC40D81B3B64B95');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_has_people MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON movie_has_people');
        $this->addSql('ALTER TABLE movie_has_people DROP id');
        $this->addSql('ALTER TABLE movie_has_people ADD PRIMARY KEY (Movie_id, People_id)');
        $this->addSql('ALTER TABLE movie_has_people RENAME INDEX idx_edc40d81b3b64b95 TO fk_Movie_has_People_People1');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY FK_D7417FB8F93B6FC');
        $this->addSql('ALTER TABLE movie_has_type DROP FOREIGN KEY FK_D7417FBC54C8C93');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT fk_Movie_has_Type_Movie1 FOREIGN KEY (Movie_id) REFERENCES movie (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE movie_has_type ADD CONSTRAINT fk_Movie_has_Type_Type1 FOREIGN KEY (Type_id) REFERENCES type (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX idx_d7417fbc54c8c93 TO fk_Movie_has_Type_Type1');
        $this->addSql('ALTER TABLE movie_has_type RENAME INDEX idx_d7417fb8f93b6fc TO IDX_D7417FB76E5D4AA');
    }
}
