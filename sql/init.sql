SET NAMES 'utf8';

CREATE TABLE IF NOT EXISTS movie_genre(
    genre_id TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
    genre VARCHAR(30) NOT NULL
) ENGINE=INNODB;

-- фильм/мультфильм
CREATE TABLE IF NOT EXISTS movie_type(
    type_id TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR(30) NOT NULL
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS movie_room(
    room_id TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
    room TINYINT(1) NOT NULL
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS age_restriction(
    age_id TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
    age TINYINT(1) NOT NULL
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS movie_country(
    country_id TINYINT(1) PRIMARY KEY AUTO_INCREMENT,
    country VARCHAR(30) NOT NULL
) ENGINE=INNODB;

CREATE TABLE IF NOT EXISTS movie(
    movie_id INT PRIMARY KEY AUTO_INCREMENT,
    genre_id TINYINT(1) NOT NULL,
    type_id TINYINT(1) NOT NULL,
    age_id TINYINT(1) NOT NULL,
    room_id TINYINT(1) NOT NULL,
    country_id TINYINT(1) NOT NULL,
    year YEAR NOT NULL,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(500) NOT NULL,
    starts_at DATETIME NOT NULL,
    ends_at DATETIME NOT NULL,
    price DECIMAL(10,2) NOT NULL,

    FOREIGN KEY (genre_id)
    REFERENCES movie_genre(genre_id),

    FOREIGN KEY (type_id)
    REFERENCES movie_type(type_id),

    FOREIGN KEY (room_id)
    REFERENCES movie_room(room_id),

    FOREIGN KEY (age_id)
    REFERENCES age_restriction(age_id),

    FOREIGN KEY (country_id)
    REFERENCES movie_country(country_id)
)ENGINE=INNODB;

/*****************************
    INITIALIZING TABLES
******************************/

-- Types:
INSERT INTO movie_type(type) VALUES('фильм');
INSERT INTO movie_type(type) VALUES('сериал');
INSERT INTO movie_type(type) VALUES('мультфильм');

-- Rooms:
INSERT INTO movie_room(room) VALUES(101);
INSERT INTO movie_room(room) VALUES(102);
INSERT INTO movie_room(room) VALUES(103);
INSERT INTO movie_room(room) VALUES(106);
INSERT INTO movie_room(room) VALUES(114);
INSERT INTO movie_room(room) VALUES(202);
INSERT INTO movie_room(room) VALUES(207);

-- Genres:
INSERT INTO movie_genre(genre) VALUES('аниме');
INSERT INTO movie_genre(genre) VALUES('биография');
INSERT INTO movie_genre(genre) VALUES('боевик');
INSERT INTO movie_genre(genre) VALUES('документальный');
INSERT INTO movie_genre(genre) VALUES('приключения');
INSERT INTO movie_genre(genre) VALUES('триллер');
INSERT INTO movie_genre(genre) VALUES('ужасы');
INSERT INTO movie_genre(genre) VALUES('комедия');
INSERT INTO movie_genre(genre) VALUES('фантастика');
INSERT INTO movie_genre(genre) VALUES('драма');

-- Ages:
INSERT INTO age_restriction(age) VALUES(6);
INSERT INTO age_restriction(age) VALUES(12);
INSERT INTO age_restriction(age) VALUES(16);
INSERT INTO age_restriction(age) VALUES(18);

-- Countries:
INSERT INTO movie_country(country) VALUES('Россия');
INSERT INTO movie_country(country) VALUES('США');
INSERT INTO movie_country(country) VALUES('Великобритания');
INSERT INTO movie_country(country) VALUES('Германия');

-- Movies:
INSERT INTO movie
VALUES(NULL, 1, 3, 2, 4, 2019, 5,
    'Дитя погоды',
    'Любовь и древняя магия в мегаполисе. Аниме-шедевр о ценности солнечного света от автора хита «Твое имя»',
    '2021-06-06 15:00:00',
    '2021-06-06 16:52:00',
    300
);