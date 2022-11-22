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
        <form method="post" action="zaloguj.php">
            <div class="card">
                <div class="inputBox">
                    <input type="text" name="login"><span>Nickname</span><br>
                </div>
                <div class="inputBox">
                    <input type="password" name="haslo"><span>Hasło</span><br>
                </div>
                <center style="font-size:80%;">
                    <?php
                        if(isset($_SESSION['blad']))echo $_SESSION['blad'];
                    ?>
                </center>
                
                <br><input type="submit" value="Zaloguj się">
            </div>
        </form>
        <a href="index.php" style="text-decoration:none;text-align:center;color:blue;font-size:200%;">
        <h3>Strona główna</h3></a>
    </div>
</body>
</html>