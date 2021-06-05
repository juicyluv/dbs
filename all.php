<?php 

// connecting to the database
require_once("db.php");

try {
    $q = 
        "SELECT m.movie_id AS id, m.title AS title,
         m.year AS year, m.avatar AS avatar,
         mg.genre AS genre, my.type AS type
         FROM movie AS m
         LEFT JOIN movie_genre AS mg ON m.genre_id = mg.genre_id
         LEFT JOIN movie_type AS my ON m.type_id = my.type_id
        ";

    $statement = $pdo->prepare($q);
    $statement->execute();

    $movies = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch(Error $e) {
    echo $e->getMessage();
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
</head>
<body>
    <nav>
        <ul>
            <li><a class="name" href="index.php"><i class="fa fa-film"></i> Heisenberg</a></li>
            <li><a href="index.php">Главная</a></li>
            <li><a href="films.php">Фильмы</a></li>
            <li><a href="cartoons.php">Мультфильмы</a></li>
            <li><a href="all.php">Все показы</a></li>
        </ul>
    </nav>

    <main class="flex">
        <header class="flex">
            <h2 class="title">Кинотеатр Heisenberg</h2>
            <img src="./img/cinema.jpg" alt="">
        </header>

        <h2>Все показы</h2>

        <div class="movies flex">
            <?php foreach($movies as $i => $movie) { ?>
                <a href="film.php?id=<?php echo $movie['id']; ?>" class="movie">
                    <img src="./img/<?php echo $movie['avatar']; ?>">
                    <p class="title"><?php echo $movie['title']; ?></p>
                    <div class="movie-info">
                        <span class="year"><?php echo $movie['year']; ?>,</span>
                        <span class="type"><?php echo $movie['type']; ?>,</span>
                        <span class="genre"><?php echo $movie['genre']; ?></span>
                    </div>
                </a>
            <?php } ?>
        </div>
    </main>
</body>
</html>