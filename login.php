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
    <div id="header">
        <h1>Zaloguj się do gry Snake</h1><br>
    </div>
    <!--<h1 style="text-align:center;border:1px solid black;width:40%;margin:auto;">Strona w trakcie tworzenia</h1>-->
    <br><br>
    <form method="post" action="zaloguj.php">
       Nickname:<br><input type="text" name="login"><br><br>
       Hasło:<br><input type="password" name="haslo"><br><br>
       <center style="font-size:80%;">
           <?php
               if(isset($_SESSION['blad']))echo $_SESSION['blad'];
           ?>
       </center>
       <br><input type="submit" value="Zaloguj się">
    </form>
    <a href="index.php" style="text-decoration:none;text-align:center;color:blue;font-size:200%;">
    <h3>Strona główna</h3></a>
</body>
</html>