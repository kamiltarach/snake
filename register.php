<?php
    session_start();

    if(isset($_POST['email']))
    {
        //udana walidacja? załóżmy ze tak!
        $itworks = true;

        //sprawdz poprawnosc nickname'ow
        $nick = $_POST['nick'];

        if((strlen($nick)<3) || (strlen($nick)>20))
        { //sprawdzanie dlugosci nicka
            $itworks = false;
            $_SESSION['e_nick'] = "Nick musi posiadac od 3 do 20 znakow";
        }

        if(ctype_alnum($nick)==false)
        {
            $itworks = false;
            $_SESSION['e_nick'] = "Nick moze skladac sie tylko z liter i cyfr (bez polskich znakow!";
        }

        //sprawdz poprawnosc email
        $email = $_POST['email'];
        $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        if((filter_var($emailS, FILTER_VALIDATE_EMAIL)==false) || ($emailS!=$email))
        {
            $itworks = false;
            $_SESSION['e_email'] = "Podaj poprawny adres email";            
        }

        //sprawdz poprawnosc hasla
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if((strlen($haslo1)<8) || (strlen($haslo1)>20))
        {
            $itworks = false;
            $_SESSION['e_haslo'] = "Hasło musi zawierać od 8 do 20 znaków";
        }
        if($haslo1!=$haslo2)
        {
            $itworks = false;
            $_SESSION['e_haslo'] = "Podane hasła nie są identyczne!";
        }

        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        //sprawdzanie akceptacji regulaminu
        $regulamin = $_POST['regulamin'];
        if(!isset($regulamin))
        {
            $itworks = false;
            $_SESSION['e_regulamin'] = "Musisz zaakceptować regulamin!";
        }

        //Zapamiętaj wprowadzone dane
		$_SESSION['fr_nick'] = $nick;
		$_SESSION['fr_email'] = $email;
		$_SESSION['fr_haslo1'] = $haslo1;
		$_SESSION['fr_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['fr_regulamin'] = true;

        require_once "conect.php";
        mysqli_report(MYSQLI_REPORT_STRICT);

        try
        {
            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            if($polaczenie->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                //czy mail juz istnieje?
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");
                
                if(!$rezultat) throw new Exception($polaczenie->error);

                $how_many_emails = $rezultat->num_rows;
                if($how_many_emails>0)
                {
                    $itworks = false;
                    $_SESSION['e_email'] = "Istnieje już konto z tym adresem email";
                }

                //czy ten nick jest jiz urzywany?
                $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE nickname='$nick'");
                
                if(!$rezultat) throw new Exception($polaczenie->error);

                $how_many_nicks = $rezultat->num_rows;
                if($how_many_nicks>0)
                {
                    $itworks = false;
                    $_SESSION['e_nick'] = "Istnieje już gracz o takim Nicku! Wybierz inny!";
                } 
        
                if($itworks==true){
                    //Hura, udana walidacja, wszystkie testy zaliczone
                    $new_user = "INSERT INTO uzytkownicy (id, nickname, email, haslo1, haslo2, max)
                    VALUES (NULL, '$nick', '$email', '$haslo_hash', '$haslo_hash', 12)";
                    if($polaczenie -> query($new_user))
                    {
                        header('Location: welcome.php');
                    }else{
                        echo $polaczenie->error;
                    }
                }
                $polaczenie->close();
            }
        }
        catch(Exception $e)
        {
            echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności. Prosimy o rejestracje w innym terminie.</span>';
            echo '<br>Informacja deweloperska: '.$e;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="game-iicon.png">
    <link rel="stylesheet" href="css/register.css">
    <title>Snake - zarejestruj się</title>
</head>
<body>
<div class="container">
    <div class="card">
        <form method="post">
            <h3>Zarejestruj się do gry snake</h3>
                <div class="inputBox">
                    <input type="text" name="nick" required="required" value="<?php
                    if (isset($_SESSION['fr_nick'])){echo $_SESSION['fr_nick'];unset($_SESSION['fr_nick']);}?>">
                    <span>Nickname</span>
                    <br><?php if(isset($_SESSION['e_nick'])){echo '<div class="error">'.$_SESSION['e_nick'].'</div>';unset($_SESSION['e_nick']);}?>
                </div>

                <div class="inputBox">
                    <input type="text" name="email" required="required" value="<?php 
                    if (isset($_SESSION['fr_email'])){echo $_SESSION['fr_email'];unset($_SESSION['fr_email']);}?>">
                    <span>Email</span>
                    <br><?php if(isset($_SESSION['e_email'])){echo '<div class="error">'.$_SESSION['e_email'].'</div>';unset($_SESSION['e_email']);}?>
                </div>

                <div class="inputBox">
                    <input type="password" name="haslo1" required="required" value="<?php
                    if (isset($_SESSION['fr_haslo1'])){echo $_SESSION['fr_haslo1'];unset($_SESSION['fr_haslo1']);}?>">
                    <span>Hasło</span>
                    <?php if(isset($_SESSION['e_haslo'])){echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';unset($_SESSION['e_haslo']);}?>
                </div>

                <div class="inputBox">
                    <input type="password" name="haslo2" value="<?php
                    if (isset($_SESSION['fr_haslo2'])){echo $_SESSION['fr_haslo2'];unset($_SESSION['fr_haslo2']);}?>">
                    <span>Powtórz hasło</span>
                </div>
                
                <label>
                    <div class="inputBox">
                        <input type="checkbox" name="regulamin" checked <?php
                        if (isset($_SESSION['fr_regulamin'])){echo "checked";unset($_SESSION['fr_regulamin']);}?>>Akcjeptuje 
                        <a href="regulamin.php" style="text-decoration:none;color:blue;">Regulamin</a>
                        <?php if(isset($_SESSION['e_regulamin'])){echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';unset($_SESSION['e_regulamin']);}?>
                    </div>
                </label>
                
            <button>Zarejestruj się</button>
            <a href="index.php" style="text-decoration:none;"><h3>Strona główna</h3></a>
        </form>
    </div>
</div>
</body>
</html>