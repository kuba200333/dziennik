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
    <title>Oceny uczniów</title>
    <link rel="stylesheet" href="styl8.css">
</head>
<body>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Semestry</h2>
        </div>
        
        
        <div id="glowny1">
            <br><br><br>
            <h3>Ustalanie trwania semestrów:</h3>
            
            <?php
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie="SELECT id FROM semestry";
            $wyslij=mysqli_query($polaczenie,$zapytanie);
            
            echo "<table><form action='' method='post'><tr><td>Wybierz numer semestru: </td><td><select name='semestr'>";
            while($row=mysqli_fetch_array($wyslij)){
                echo "<option>".$row[0]."</option>";
            }
            echo "</select></td></tr>";

            echo "<tr><td>Czas trwania od: </td><td><input type='date' name='data_od'></td></tr>";
            echo "<tr><td>Czas trwania do: </td><td><input type='date' name='data_do'></td></tr>";
            echo "<tr><td colspan='2'><input type='submit' name='submit'></td></tr>";
            echo "</form></table>";


            if(isset($_POST['submit'])){
                $id=$_POST['semestr'];
                $od=$_POST['data_od'];
                $do=$_POST['data_do'];

                $zapytanie1="UPDATE semestry SET od='$od', do='$do' where id=$id";
                $wyslij1=mysqli_query($polaczenie,$zapytanie1);
            }
            ?>
        </div>

        <div id="glowny2">
            <br><br><br>
            <h3>Lista semestrów wraz z przedziałem trwania:</h3>
            <table>
                <tr><td colspan="3">
                    
                </td></tr>
                <th>numer semestru</th><th>trwa od</th><th>trwa do</th>
                <?php
                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie="SELECT * FROM semestry";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<tr><td>".$row[0]."</td><td>".$row[1]."</td><td>".$row[2]."</td><tr>";
                }
                ?>
                <tr><td colspan="3"></td></tr>
            </table>
        </div>

        <div id="stopka">
        
        </div>
    </div>
</body>
</html>