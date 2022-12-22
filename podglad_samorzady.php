<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Samorzady klasowe</title>
    <link rel="stylesheet" href="styl3.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
    <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>
        </div>

        <div id="naglowek2">
            <h2>Samorządy klasowe</h2>
        </div>
        
        <div id="glowny">
        <?php
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie="SELECT klasy.skrot_klasy as klasa, concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia) as uczen, funkcje.nazwa as funkcja from uczniowie inner join klasy on uczniowie.id_klasy=klasy.id_klasy inner join funkcje on uczniowie.funkcja=funkcje.id_funkcji where id_funkcji in (0,1,2) order by klasa asc;";
            $wyslij=mysqli_query($polaczenie,$zapytanie);
            if($wyslij->num_rows>0){
            echo "<table>";
            echo "<tr><th>Klasa</th><th>Funkcja</th><th>Nazwisko i imie ucznia</th></tr>";
            while($row=mysqli_fetch_array($wyslij)){
                echo "<tr>" . "<td>".$row["klasa"]. "</td>" ."<td>".$row["funkcja"]. "</td>" . "<td>". $row["uczen"]."";
            }
            echo "</table>";
            }else{
                echo "<br>Brak zapisów o samorządach klasowych";
            }
        ?>
        
        
        </div>
        <div id="stopka">
        <a class='center' href="\dziennik_lekcyjny\dodaj_samorzad.php" onclick="window.open('dodaj_samorzad.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=300').focus(); return false">Zmień/dodaj przedstawicieli klas</a>
        </div>
    </div>

    </form>
</body>
</html>