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

CREATE TABLE IF NOT EXISTS movie(
    movie_id INT PRIMARY KEY AUTO_INCREMENT,
    genre_id TINYINT(1) NOT NULL,
    type_id TINYINT(1) NOT NULL,
    year YEAR NOT NULL,
    room_id TINYINT(1) NOT NULL,
    title VARCHAR(50) NOT NULL,
    description VARCHAR(500) NOT NULL,
    starts_at DATETIME NOT NULL,
    ends_at DATETIME NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    avatar VARCHAR(50) NOT NULL DEFAULT 'default.png',

    FOREIGN KEY (genre_id)
    REFERENCES movie_genre(genre_id),

    FOREIGN KEY (type_id)
    REFERENCES movie_type(type_id),

    FOREIGN KEY (room_id)
    REFERENCES movie_room(room_id)
)ENGINE=INNODB;