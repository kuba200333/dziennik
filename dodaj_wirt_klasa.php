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
    <link rel="stylesheet" href="styl.css">
    <title>Dodaj klasę</title>
</head>
<body>
    <div class="kontener">
        <form action="" method="post">

        <h4 class="inside">Dodaj wirtualną klase</h4>
        <table>
        <tr><td class='kolumna3' colspan="2"></td></tr>
            <tr><td class='kolumna1'>Nazwa klasy: </td><td class='kolumna2'><input name="nazwa_klasy" type="text" required></td></tr>
            <tr><td class='kolumna1'>Skrót klasy:</td><td class='kolumna2'><input name="skrot_klasy" type="text" required></td></tr>     
           
        
        
    <?php

        $nazwa_klasy= @$_POST['nazwa_klasy'];
        $skrot_klasy= @$_POST['skrot_klasy'];

        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

        echo <<<END
        <tr class='inside'><td class="kolumna3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr></table>
        END;

        $nauczyciel= @$_POST['nauczyciel'];

        if(!empty($_POST['nazwa_klasy'])||!empty($_POST['skrot_klasy']))
        {
     
        @$wynik="INSERT INTO klasy(id_klasy, nazwa_klasy, skrot_klasy, wirt) VALUES (null,'$nazwa_klasy','$skrot_klasy', 1)";
        
        $wyslij_wynik=mysqli_query($polaczenie,$wynik);

            echo "<p id='add'>Dodano wirtualną klasę!</p>";
        }
   
        

        mysqli_close($polaczenie);

    ?>  <br>
   
    </form>
    </div>
</body>
</html>