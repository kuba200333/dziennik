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
    <title>Nauczyciele</title>
    <link rel="stylesheet" href="styl7.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
    <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>
        </div>

        <div id="naglowek2">
            <h2>Nauczyciele</h2>
        </div>
        
        <div id="glowny">
            <table>
            <tr><th>Nazwisko</th><th>Imie</th>
            <?php
            if($_SESSION['login']=='admin'){
                echo "<th>usuń</th>";
            }
            ?>
            </tr>
        <?php
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $sql = "SELECT nauczyciele.id_nauczyciela as id_nauczyciela, nauczyciele.nazwisko as nazwisko, nauczyciele.imie as imie FROM nauczyciele where nauczyciele.nazwisko !='admin' order by nazwisko asc;";
            $result= mysqli_query($polaczenie,$sql);

            while($row=mysqli_fetch_array($result)){
                echo "<tr>" . "<td>" . $row["nazwisko"]. "<td>".$row["imie"]. "</td>";
                if($_SESSION['login']=='admin'){
                    echo"<td class='usuwanie'><form action='podglad_oceny_nauczyciela.php' method='post'><input type='hidden' name='id_nauczyciela' value='".$row["id_nauczyciela"]."'><input type='submit' name='usun' value='X'></form></td>";
                }
                echo"</tr>";
            }

            mysqli_close($polaczenie);
        ?>
        </table>
        <?php
        if(!empty($_POST['usun'])){
        $id_nauczyciela=$_POST['id_nauczyciela'];
        
        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $zapytanie="DELETE FROM nauczyciele WHERE id_nauczyciela='$id_nauczyciela';";
        $wyslij=mysqli_query($polaczenie,$zapytanie);

        }
        ?>
        </div>
        <div id="stopka">
            
        </div>
    </div>

    </form>
</body>
</html>