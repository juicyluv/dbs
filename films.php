<?php 

try {
    // connecting to the database
    require_once("db.php");
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

    <main class="flex">

        <h2 class="movie-type">Фильмы</h2>
        
        <?php 
            try {
                $limit = 12;

                $total = $pdo->query("SELECT COUNT(movie_id) FROM movie")->fetch(PDO::FETCH_COLUMN);
                $amt = ceil($total / $limit);

                $q = "  SELECT m.movie_id AS id, m.title AS title,
                        m.year AS year, mg.genre AS genre, my.type AS type
                        FROM movie AS m
                        LEFT JOIN movie_genre AS mg ON m.genre_id = mg.genre_id
                        LEFT JOIN movie_type AS my ON m.type_id = my.type_id
                        WHERE my.type = 'фильм'
                        LIMIT $limit";

                $movies = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);
            } catch(Error $e) {
                echo $e->getMessage();
            }
        ?>

        <div class="movies flex">
            <?php foreach($movies as $i => $movie) { ?>
                    <a href="film.php?id=<?php echo $movie['id']; ?>" class="movie">
                        <img src="./img/movies/<?php echo $movie['title']; ?>.jpeg">
                        <p class="title"><?php echo $movie['title']; ?></p>
                        <div class="movie-info">
                            <span class="year"><?php echo $movie['year']; ?>,</span>
                            <span class="type"><?php echo $movie['type']; ?>,</span>
                            <span class="genre"><?php echo $movie['genre']; ?></span>
                        </div>
                    </a>
                <?php } ?>
        </div>
        <div class="space"></div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="./js/films.js"></script>
</body>
</html>