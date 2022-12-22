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
    <title>Document</title>
</head>
<body>
<a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>
    <table>
    <tr><th>id klasy</th><th>Klasa</th><th>Wychowawca</th></tr>
    <?php
    require "connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    $sql = "SELECT klasy.id_klasy as id_klasy, klasy.id_nauczyciela as id_nauczyciela, klasy.nazwa_klasy as klasa, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as wychowawca FROM `klasy` inner join nauczyciele on klasy.id_nauczyciela=nauczyciele.id_nauczyciela;";
    $result= mysqli_query($polaczenie,$sql);


    while($row=mysqli_fetch_array($result)){
        echo "<tr>" . "<td>".$row["id_klasy"]. "</td>" ."<td>".$row["klasa"]. "</td>" . "<td>". $row["wychowawca"]."<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_oceny' value='".$row['id_klasy']."'><input type='submit' name='usun' value='X'></form></td>";
    }

    mysqli_close($polaczenie);
    ?>
    </table>
</body>
</html>