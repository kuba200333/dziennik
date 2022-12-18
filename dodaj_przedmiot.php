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
    <title>Dodaj przedmiot</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <div class="kontener">
        <h4 class="inside">Dodaj przedmiot</h4>
        <table>
        <form action="" method="post">
            <tr><td class='kolumna3' colspan="2"></td></tr>
            <tr><td class='kolumna1'>Nazwa przedmiotu:</td><td class='kolumna2'><input name="nazwa przedmiotu" type="text" placeholder="Nazwa przedmiotu" required>  </td></tr>
            <tr><td class='kolumna1'>Skrót przedmiotu:</td><td class='kolumna2'><input name="skrot_przedmiotu" type="text" placeholder="Skrót przedmiotu" required>  </td></tr>
            <tr class='inside'><td class="kolumna3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr>
        </table>
        <?php
        if(!empty($_POST['wysylacz'])){
            $nazwa_przedmiotu= $_POST['nazwa_przedmiotu'];
            $skrot_przedmiotu= $_POST['skrot_przedmiotu'];

            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
            $zapytanie="INSERT INTO przedmioty(id_przedmiotu, nazwa_przedmiotu, skrot_przedmiotu) VALUES ('','$nazwa_przedmiotu','$skrot_przedmiotu')";



            $wyslij=mysqli_query($polaczenie,$zapytanie);  
            echo "<p id='add'>Dodano przedmiot!</p>";
        }

        ?>
</body>
</html>