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
        <h1>Witaj w grze Snake</h1><br>
    </div>
        <!--<h1 style="text-align:center;border:1px solid black;width:40%;margin:auto;">Strona w trakcie tworzenia</h1>-->
    <br><br>
    <center>
        <?php
            echo 'Witaj '.$_SESSION['user'].'!&nbsp&nbsp | &nbsp&nbsp';
            echo 'E-mail: '.$_SESSION['email'].'&nbsp&nbsp | &nbsp&nbsp';
            echo 'Wynik gry: '.$_SESSION['max'];
            echo '<br><br><a href="logout.php" style="text-decoration:none; color:blue;">Wyloguj się</a>';
            echo '<br><br><canvas id="canvas" style="border-radius:20px;" width="400px" height="400px"></canvas>';
            echo '<script type="text/javascript" src="js/snake.js"></script>';
        ?>
    </center>
</body>
</html>