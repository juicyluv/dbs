<?php 

// connecting to the database
require_once("db.php");

if(isset($_POST['title']) && isset($_POST['description']) &&
    isset($_POST['genre']) && isset($_POST['type']) && isset($_POST['year']) &&
    isset($_POST['room']) && isset($_POST['country']) && isset($_POST['age']) &&
    isset($_POST['starts_at']) && isset($_POST['ends_at']) && isset($_POST['price']) &&
    isset($_FILES['image'])) {
        $title = $_POST['title'];
        $desc = $_POST['description'];
        $genre_id = $_POST['genre'];
        $type_id = $_POST['type'];
        $country_id = $_POST['country'];
        $room_id = $_POST['room'];
        $age_id = $_POST['age'];
        $year = $_POST['year'];
        $start = $_POST['starts_at'];
        $end = $_POST['ends_at'];
        $price = $_POST['price'];
        $avatar = $_FILES['image']['tmp_name'];
        $avatar_path = __DIR__."/img/movies/$title.jpeg";

        $q = "INSERT INTO movie VALUES(
                NULL,
                $genre_id,
                $type_id,
                $age_id,
                $room_id,
                $country_id,
                $year,
                '$title',
                '$desc',
                '$start',
                '$end',
                $price
              )";
        try {
            $pdo->query($q);
            move_uploaded_file($avatar, $avatar_path);
            header('location: add.php');
            die();
        } catch(Error $e) {
            echo $e->getMessage();
            die();
        }
}

if(isset($_POST['new_age'])) {
    $age = $_POST['new_age'];

    $pdo->query("INSERT INTO age_restriction VALUES(NULL, $age)");
    header('location: add.php');
    die();
}

if(isset($_POST['new_country'])) {
    $country = $_POST['new_country'];

    $pdo->query("INSERT INTO movie_country VALUES(NULL, '$country')");
    header('location: add.php');
    die();
}

if(isset($_POST['new_type'])) {
    $type = $_POST['new_type'];

    $pdo->query("INSERT INTO movie_type VALUES(NULL, '$type')");
    header('location: add.php');
    die();
}

if(isset($_POST['new_room'])) {
    $room = $_POST['new_room'];

    $pdo->query("INSERT INTO movie_room VALUES(NULL, $room)");
    header('location: add.php');
    die();
}

if(isset($_POST['new_genre'])) {
    $genre = $_POST['new_genre'];

    $pdo->query("INSERT INTO movie_genre VALUES(NULL, '$genre')");
    header('location: add.php');
    die();
}

$q = "SELECT * FROM movie_type";
$types = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);

$q = "SELECT * FROM movie_country";
$countries = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);

$q = "SELECT * FROM movie_room";
$rooms = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);

$q = "SELECT * FROM movie_type";
$types = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);

$q = "SELECT * FROM movie_genre";
$genres = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);

$q = "SELECT * FROM age_restriction";
$ages = $pdo->query($q)->fetchAll(PDO::FETCH_ASSOC);

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

        <form class="add-film-form" enctype="multipart/form-data" action="add.php" method="POST">
            <h2>Добавить фильм</h2>
            <div class="option">
                <label for="title">Название:</label>
                <input required type="text" name="title">
            </div>

            <div class="option">
                <label for="description">Описание:</label>
                <input required type="text" name="description">
            </div>
            
            <div class="option">
                <label for="year">Год: </label>
                <input required type="text" name="year">
            </div>

            <div class="option">
                <label for="type">Тип: </label>
                <select required name="type">
                    <?php foreach($types as $type) { ?>
                        <option value="<?php echo $type['type_id'] ?>"><?php echo $type['type'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="option">
                <label for="genre">Жанр:</label>
                <select required name="genre">
                    <?php foreach($genres as $genre) { ?>
                        <option value="<?php echo $genre['genre_id'] ?>"><?php echo $genre['genre'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="option">
                <label for="country">Страна: </label>
                <select required name="country">
                    <?php foreach($countries as $country) { ?>
                        <option value="<?php echo $country['country_id'] ?>"><?php echo $country['country'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="option">
                <label for="room">Зал: </label>
                <select required name="room">
                    <?php foreach($rooms as $room) { ?>
                        <option value="<?php echo $room['room_id'] ?>"><?php echo $room['room'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="option">
                <label for="age">Возрастное ограничение: </label>
                <select required name="age">
                    <?php foreach($ages as $age) { ?>
                        <option value="<?php echo $age['age_id'] ?>"><?php echo $age['age'] ?>+</option>
                    <?php } ?>
                </select>
            </div>

            <div class="option">
            <label for="starts_at">Начало: </label>
            <input required type="datetime-local" name="starts_at">
            </div>
            <div class="option">
            <label for="ends_at">Конец: </label>
            <input required type="datetime-local" name="ends_at">
            </div>
            <div class="option">
            <label for="price">Цена(руб): </label>
            <input required type="text" name="price">
            </div>
            <div class="option">
            <label for="image">Обложка: </label>
            <input required type="file" name="image">
            </div>
            <button type="submit">Добавить</button>
        </form>

        <form class="add-film-form" action="add.php" method="POST">
            <h2>Добавить возрастное ограничение</h2>
            <div class="option">
                <label for="new_age">Возраст:</label>
                <input required type="text" name="new_age">
            </div>
            <button type="submit">Добавить</button>
        </form>

        <form class="add-film-form" action="add.php" method="POST">
            <h2>Добавить страну</h2>
            <div class="option">
                <label for="new_country">Страна:</label>
                <input required type="text" name="new_country">
            </div>
            <button type="submit">Добавить</button>
        </form>

        <form class="add-film-form" action="add.php" method="POST">
            <h2>Добавить тип</h2>
            <div class="option">
                <label for="new_type">Тип:</label>
                <input required type="text" name="new_type">
            </div>
            <button type="submit">Добавить</button>
        </form>

        <form class="add-film-form" action="add.php" method="POST">
            <h2>Добавить жанр</h2>
            <div class="option">
                <label for="new_genre">Жанр:</label>
                <input required type="text" name="new_genre">
            </div>
            <button type="submit">Добавить</button>
        </form>

        <form class="add-film-form" action="add.php" method="POST">
            <h2>Добавить комнату</h2>
            <div class="option">
                <label for="new_room">Номер комнаты:</label>
                <input required type="text" name="new_room">
            </div>
            <button type="submit">Добавить</button>
        </form>

        <div class="space"></div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</body>
</html>