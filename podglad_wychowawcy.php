<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klasy</title>
    <link rel="stylesheet" href="styl3.css">
</head>
<body>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Klasy</h2>
        </div>
        
        <div id="glowny">
            <table>
            <tr><th>Klasa</th><th>Wychowawca</th></tr>
            <?php
                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $sql = "SELECT klasy.skrot_klasy as klasa, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as wychowawca from klasy inner join nauczyciele on klasy.id_nauczyciela=nauczyciele.id_nauczyciela order by klasa asc;";
            
                $result= mysqli_query($polaczenie,$sql);

                while($row=mysqli_fetch_array($result)){
                    echo "<tr>" . "<td class='srodek'>".$row["klasa"]. "</td>" . "<td>" . $row["wychowawca"]."</td></tr>";
                }

                mysqli_close($polaczenie);
            ?>
            </table>
        </div>
        <div id="stopka">
            
        </div>
    </div>


    

</body>
</html>