<?php 

try {
    // connecting to the database
    require_once("db.php");

    // если пользователь фильтрует или сортирует данные
    if(isset($_POST["order"]) && isset($_POST["year"])
        && isset($_POST["genre"]) && isset($_POST["country"])) {

            

            $year = $genre = $country = "";

            $where = "";

            if($_POST["year"] !== "all") {
                $where .= $where === "" ? "year = ".$_POST["year"] : " AND year = ".$_POST["year"];
            }
            if($_POST["genre"] !== "all") {
                $where .= $where === "" ? "genre = '".$_POST["genre"]."'" : " AND genre = '".$_POST["genre"]."'";
            }
            if($_POST["country"] !== "all") {
                $where .= $where === "" ? "country = '".$_POST["country"]."'" : " AND country = '".$_POST["country"]."'";
            }

            
            $q = "SELECT m.movie_id AS id, m.title AS title,
                  m.year AS year, mg.genre AS genre, my.type AS type
                  FROM movie AS m
                  LEFT JOIN movie_genre AS mg ON m.genre_id = mg.genre_id
                  LEFT JOIN movie_type AS my ON m.type_id = my.type_id"
                  . ($where === "" ? "WHERE ".$where : "") ." LIMIT 6";

        $movies = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);
        } else {
        $q = "  SELECT m.movie_id AS id, m.title AS title,
                m.year AS year, mg.genre AS genre, my.type AS type
                FROM movie AS m
                LEFT JOIN movie_genre AS mg ON m.genre_id = mg.genre_id
                LEFT JOIN movie_type AS my ON m.type_id = my.type_id
                LIMIT 6";

        $movies = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);
    }

    if(!$movies) {
        throw new Error('Фильмы не найдены');
    }
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
        <header class="flex">
            <h2 class="title">Кинотеатр Heisenberg</h2>
        </header>
        <div class="space"></div>
        <div class="today">
            <h2>СЕГОДНЯ В КИНО</h2>
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
        </div>
        <div class="space"></div>
        <div class="other">
        <h2>ДРУГИЕ ПОКАЗЫ</h2>
            <?php 
                try {
                    $q = "  SELECT m.movie_id AS id, m.title AS title,
                            m.year AS year, mg.genre AS genre, my.type AS type
                            FROM movie AS m
                            LEFT JOIN movie_genre AS mg ON m.genre_id = mg.genre_id
                            LEFT JOIN movie_type AS my ON m.type_id = my.type_id";

                    $movies = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);

                    $q = "SELECT DISTINCT year FROM movie";
                    $years = $pdo->query($q)->fetchAll(PDO::FETCH_COLUMN);

                    $q = "SELECT type FROM movie_type";
                    $types = $pdo->query($q)->fetchAll(PDO::FETCH_COLUMN);

                    $q = "SELECT country FROM movie_country";
                    $countries = $pdo->query($q)->fetchAll(PDO::FETCH_COLUMN);
                } catch(Error $e) {
                    echo $e->getMessage();
                }
            ?>
            <form class="filter-form" action="index.php" method="POST">
                <div class="filter">
                    <label>Фильтр</label>
                    <label for="year">Год:</label>
                    <select name="year" class="filter-years">
                    <option selected value="all">Все</option>
                        <?php foreach($years as $year) { ?>
                            <option value="<?php echo $year ?>"><?php echo $year ?></option>
                        <?php } ?>
                    </select>
                    <label for="genre">Жанр:</label>
                    <select name="genre" class="filter-genre">
                        <option selected value="all">Все</option>
                        <?php foreach($types as $type) { ?>
                            <option value="<?php echo $type ?>"><?php echo $type ?></option>
                        <?php } ?>
                    </select>
                    <label for="country">Страна:</label>
                    <select name="country" class="filter-country">
                        <option selected value="all">Все</option>
                        <?php foreach($countries as $country) { ?>
                            <option value="<?php echo $country ?>"><?php echo $country ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="order">
                    <label>Сортировка по: </label>
                    <select name="order">
                            <option selected value="date">дате</option>
                            <option value="title">названию</option>
                            <option value="year">годам выпуска</option>
                            <option value="genre">жанрам</option>
                            <option value="country">странам</option>
                    </select>
                </div>
                <button type="submit">Поиск</button>
            </form>

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
        </div>
        <div class="space"></div>
    </main> 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="./js/index.js"></script>
</body>
</html>