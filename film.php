<?php 

// connecting to the database
require_once("db.php");

try {

    $query = array();
    $query_str = parse_str($_SERVER["QUERY_STRING"], $query);

    if(!isset($query["id"])) {
        throw new Error("Не задан id");
    }

    $movie_id = $query['id'];

    $q = "SELECT m.title AS title, m.description AS description,
        m.year AS year, m.price AS price, 
        DATE_FORMAT(m.starts_at, '%Y-%m-%d %k:%i') AS start, 
        TIMEDIFF(m.ends_at, m.starts_at) AS duration,
        mg.genre AS genre, ar.age AS age,
        mc.country AS country, mr.room AS room, my.type AS type
        FROM movie AS m
        LEFT JOIN movie_genre AS mg ON m.genre_id = mg.genre_id
        LEFT JOIN movie_room AS mr ON m.room_id = mr.room_id
        LEFT JOIN movie_type AS my ON m.type_id = my.type_id
        LEFT JOIN age_restriction AS ar ON m.age_id = ar.age_id
        LEFT JOIN movie_country AS mc ON m.country_id = mc.country_id
        WHERE m.movie_id = $movie_id";

    $statement = $pdo->prepare($q);
    $statement->execute();

    $movie = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(!$movie) {
        throw new Error("Фильм не найден");
    }

    $movie = $movie[0];
} catch(Error $e) {
    echo $e->getMessage();
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кинотеатр Heisenberg</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/style.css">
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon">
</head>
<body>
    <nav>
        <ul>
            <li><a class="name" href="index.php"><i class="fa fa-film"></i> Heisenberg</a></li>
            <li><a href="index.php">Главная</a></li>
            <li><a href="films.php">Фильмы</a></li>
            <li><a href="cartoons.php">Мультфильмы</a></li>
            <li><a href="add.php">Добавить фильм</a></li>
        </ul>
    </nav>

    <main>
        <div class="film">
            <img class="film-avatar" src="./img/movies/<?php echo $movie["title"]?>.jpeg" alt="">
            <div class="film-info">
                <p class="film-title"><?php echo $movie["title"]; ?></p>
                <hr>
                <p class="film-description"><?php echo $movie["description"]; ?></p>
                <hr>
                <div class="additional-info">
                    <p class="film-type">Тип: <?php echo $movie["type"]; ?></p>
                    <p class="film-genre">Жанр: <?php echo $movie["genre"]; ?></p>
                    <p class="film-country">Страна: <?php echo $movie["country"]; ?></p>
                    <p class="film-year">Год: <?php echo $movie["year"]; ?></p>
                    <p class="film-start">Начало: <?php echo $movie["start"]; ?></p>
                    <p class="film-duration">Длительность: <?php echo $movie["duration"]; ?></p>
                    <p class="film-age">Возрастное ограничение: <?php echo $movie["age"]; ?>+</p>
                    <p class="film-price">Цена: <?php echo $movie["price"]; ?>руб</p>
                    <p class="film-room">Зал: №<?php echo $movie["room"]; ?></p>
                </div>
                <button class="buy-ticket">Купить билет</button>
            </div>
        </div>
        <div class="space"></div>
    </main>
</body>
</html>