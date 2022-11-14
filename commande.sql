ALTER TABLE movie_has_type DROP FOREIGN KEY fk_Movie_has_Type_Movie1;
ALTER TABLE movie_has_type DROP FOREIGN KEY fk_Movie_has_Type_Type1;
ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FB8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE;
ALTER TABLE movie_has_type ADD CONSTRAINT FK_D7417FBC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE;
ALTER TABLE movie_has_type RENAME INDEX fk_movie_has_type_type1 TO IDX_D7417FBC54C8C93;
ALTER TABLE movie_has_people RENAME INDEX fk_movie_has_people_people1 TO IDX_EDC40D81B3B64B95;

alter table movie_has_people
drop foreign key fk_Movie_has_People_Movie1;

alter table movie_has_people
drop foreign key fk_Movie_has_People_People1;

ALTER TABLE movie_has_people ADD id INT AUTO_INCREMENT NOT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id);

alter table movie_has_people add constraint fk_Movie_has_People_Movie1
    foreign key (Movie_id) references movie (id);

alter table movie_has_people add constraint fk_Movie_has_People_People1
    foreign key (People_id) references people (id);

ALTER TABLE movie_has_people RENAME INDEX fk_movie_has_people_movie1 TO IDX_EDC40D8176E5D4AA;

CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB
