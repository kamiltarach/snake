<?php
    session_start();

    if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==true)) {
        header('Location: snake-gra.php');
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
    <link rel="stylesheet" href="css/login.css">
    <title>Snake - zaloguj się</title>
</head>
<body>
<div class="container">
    <div class="card"><form method="post" action="zaloguj.php">
        <h3>Zaloguj się do gry snake</h3>
            <div class="inputBox">
                <input type="text" name="login" required="required">
                <span>Nickname</span>
            </div>
            <div class="inputBox">
                <input type="password" name="haslo" required="required">
                <span>Haslo</span>
            </div>
            <center style="font-size:80%;">
                <?php
                    if(isset($_SESSION['blad']))echo $_SESSION['blad'];
                ?>
            </center>
            <button>Zaloguj</button>
            <a href="index.php" style="text-decoration:none;text-align:center;color:blue;">
            <h3>Strona główna</h3></a>
        </form></div>
    </div>
</body>
</html>