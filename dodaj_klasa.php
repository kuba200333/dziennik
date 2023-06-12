<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}

if ($_SESSION['admin'] !=1){
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

        <h4 class="inside">Dodaj klase</h4>
        <table>
        <tr><td class='3' colspan="2"></td></tr>
            <tr><td class='1'>Nazwa klasy: </td><td class='2'><input name="nazwa_klasy" type="text" required></td></tr>
            <tr><td class='1'>Skrót klasy:</td><td class='2'><input name="skrot_klasy" type="text" required></td></tr>     
           
        
        
    <?php

        $nazwa_klasy= @$_POST['nazwa_klasy'];
        $skrot_klasy= @$_POST['skrot_klasy'];

        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

        $zapytanie = "SELECT id_nauczyciela, concat(nazwisko,' ', imie) as nauczyciel FROM `nauczyciele` order by nauczyciel asc;";
        $wyslij=mysqli_query($polaczenie,$zapytanie);

        echo "<tr><td class='1'>Wychowawca:</td><td class='2'>";
        echo "<select name='nauczyciel' required>";
        echo "<option value=''</option>";
        while($row=mysqli_fetch_array($wyslij)){

            echo "<option value='".$row['nauczyciel']."'>".$row['nauczyciel']."</option>";
        }
        echo('</select></td></tr>');
        echo <<<END
        <tr class='inside'><td class="3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr></table>
        END;

        $nauczyciel= @$_POST['nauczyciel'];

        if(!empty($_POST['nazwa_klasy'])||!empty($_POST['skrot_klasy']))
        {
        $zapytanie1="SELECT id_nauczyciela from nauczyciele where concat(nazwisko,' ', imie)='".$nauczyciel."';";
        $wyslij1=mysqli_query($polaczenie,$zapytanie1);
        
        while($row1=mysqli_fetch_array($wyslij1)){
            $id_nauczyciela=$row1['id_nauczyciela'];
        }

        @$wynik="INSERT INTO klasy(id_klasy, nazwa_klasy, skrot_klasy, id_nauczyciela) VALUES ('','$nazwa_klasy','$skrot_klasy', '$id_nauczyciela')";
        
        $wyslij_wynik=mysqli_query($polaczenie,$wynik);

            echo "<p id='add'>Dodano klasę!</p>";
        }
   
        

        mysqli_close($polaczenie);

    ?>  <br>
   
    </form>
    </div>
</body>
</html>