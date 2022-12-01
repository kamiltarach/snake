<?php
    session_start();

    if(!isset($_SESSION['zalogowany'])){
        header('Location: login.php');
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon"  href="game-iicon.png">
    <link rel="stylesheet" href="css/snake-gra.css">
    <title>Snake - Gra</title>
</head>
<body>
    <div id="header">
        <h2>Witaj w grze Snake</h2>
    </div>
    <div id="info">
        <?php
            echo 'Witaj '.$_SESSION['user'].',<br><br>';
            echo 'E-mail: '.$_SESSION['email'].'<br><br>';
            echo 'Życzymy żebyś zdobył jak najwiecej punktów!';
            echo '<br><br><a href="logout.php" style="text-decoration:none; color:blue; text-transform: uppercase;">Wyloguj się</a>';
        ?>
    </div>
    <div id="game">
        <?php
            echo '<br><br><canvas id="canvas" style="border-radius:20px;" width="500px" height="500px"></canvas>';
            echo '<script type="text/javascript" src="js/snake.js"></script>';
        ?>
    </div>
    <footer>
        <p>Autor strony: Kamil Tarach | kamiltarach.kt@gmail.com</p>
    </footer>
</body>
</html>