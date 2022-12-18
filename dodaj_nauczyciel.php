<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}

if ($_SESSION['login']!='admin'){
    header("Location: dziennik.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj nauczyciela</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
        <div class="kontener">
            <form action="" method="post">

        <h4 class="inside">Dodaj nauczyciela</h4>
        <table>
            <tr><td class='kolumna3' colspan="2"></td></tr>
            <tr><td class='kolumna1'>Nazwisko nauczyciela:</td><td class='kolumna2'><input name="nazwisko" type="text"  required></td></tr>
            <tr><td class='kolumna1'>Imie nauczyciela:</td><td class='kolumna2'><input name="imie" type="text"  required></td></tr>
            <tr><td class='kolumna1'>login:</td><td class='kolumna2'><input name="login" type="text"  required></td></tr>
            <tr><td class='kolumna1'>hasło:</td><td class='kolumna2'><input name="haslo" type="password"  required></td></tr>
            <tr><td class='kolumna1'>email:</td><td class='kolumna2'><input name="email" type="email"  required></td></tr>
            <tr class='inside'><td class="kolumna3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr>
        </form>
        </table>
        <?php

            if(!empty($_POST['wysylacz'])){
              

                $haslo=$_POST['haslo'];
                $email=$_POST['email'];

                $l=str_replace(" ","",$login=$_POST['login']);
                $i=str_replace(" ","",$imie= @$_POST['imie']);
                $n=str_replace(" ","",$nazwisko= @$_POST['nazwisko']);
                $haslo_hash= password_hash($haslo, PASSWORD_DEFAULT);

                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        

                $sql="INSERT INTO nauczyciele(id_nauczyciela, imie, nazwisko, login, haslo, email) VALUES (null,'$i','$n','$l', '$haslo_hash','$email')";
                echo $sql;
                $result= mysqli_query($polaczenie,$sql);
    
                echo "<p id='add'>Dodano nauczyciela!</p>";
                mysqli_close($polaczenie);

            }
        ?>
    </div>
</body>
</html>