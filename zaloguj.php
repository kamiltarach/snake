<?php
    session_start();

    if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
    {
        header('Loaction: login.php');
        exit();
    }

    require_once "conect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    if($polaczenie->connect_errno!=0){
        echo "Error: ".$polaczenie->connect_errno."Opis: ".$polaczenie->connect_error;
        
    }else{
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if($rezultat = $polaczenie->query(
            sprintf("SELECT * FROM uzytkownicy WHERE nickname='%s'",
            mysqli_real_escape_string($polaczenie, $login)))){
            $ile_userow = $rezultat->num_rows;
            if($ile_userow>0)
            {
                $wiersz = $rezultat->fetch_assoc();

                //haszowanie hasel
                $haslo_hash = password_hash($haslo, PASSWORD_DEFAULT);

                if(password_verify($haslo, $wiersz['haslo1']))
                {
                    $_SESSION['zalogowany'] = true;
                    $_SESSION['id'] = $wiersz['id'];
                    $_SESSION['user'] = $wiersz['nickname'];
                    $_SESSION['max'] = $wiersz['max'];
                    $_SESSION['email'] = $wiersz['email'];

                    unset($_SESSION['blad']);
                    $rezultat->free_result();
                    header('Location:snake-gra.php');
                }
                else
                {
                    $_SESSION['blad'] = "<p style='color:red;'>Zle dane logowania</p>";
                }
            }
            else
            {
                $_SESSION['blad'] = "<p style='color:red;'>Zle dane logowania</p>";
            }
        }

        $polaczenie->close();
    }
?> <!-- Kamil Tarach -->