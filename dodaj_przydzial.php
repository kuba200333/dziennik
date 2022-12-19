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
    <link rel="stylesheet" href="styl.css">
    <title>Dodaj przydział</title>
</head>
<body>
    <div class="kontener">
    <h4 class="inside">Dodaj przydział nauczycielowi</h4>
    <form action="" method='post'>
        <?php
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

            $zapytanie1="SELECT skrot_klasy FROM klasy order by skrot_klasy asc;";
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  

            echo "<table>";
            echo "<tr><td colspan='2' class='kolumna3'></td></tr>";
            echo "<tr><td class='kolumna1'>klasy:</td><td class='kolumna2'><select name='klasy'>";
            echo "<option value=''</option>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo "<option>".$row1['skrot_klasy']."</option>";
            }
            echo "</select></td></tr>";

            $zapytanie="SELECT nazwa_przedmiotu FROM przedmioty where nazwa_przedmiotu != 'zachowanie' order by nazwa_przedmiotu asc;";
            $wyslij=mysqli_query($polaczenie,$zapytanie);
    
            echo "<tr><td class='kolumna1'>przedmiot:</td><td class='kolumna2'><select name='przedmiot'>";
            echo "<option value=''</option>";
            while($row=mysqli_fetch_array($wyslij)){
                echo "<option>".$row[0]."</option>";
            }
            echo "</select></td></tr>";

            $zapytanie2="SELECT concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as nauczyciel FROM nauczyciele order by nauczyciel asc;";
            $wyslij2=mysqli_query($polaczenie,$zapytanie2);
    
            echo "<tr><td class='kolumna1'>nauczyciel:</td><td class='kolumna2'><select name='nauczyciel'>";
            echo "<option value=''</option>";
            while($row2=mysqli_fetch_array($wyslij2)){
                echo "<option>".$row2[0]."</option>";
            }
            echo "</select></td></tr>";

            
            mysqli_close($polaczenie);

        ?>
        <tr class='inside'><td class="kolumna3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr>
        </table>

    </form></div> 
        <?php
            if(!empty($_POST['wysylacz'])){
                
                $skrot_klasy=$_POST['klasy'];
            
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie13="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
                $wyslij13=mysqli_query($polaczenie,$zapytanie13);  
            
            
                while($row13=mysqli_fetch_array($wyslij13)){
                    $id_klasy=$row13['id_klasy'];
                }

                $przedmiot=@$_POST['przedmiot'];

                            
                $zapytanie3="SELECT id_przedmiotu from przedmioty where nazwa_przedmiotu='".$przedmiot."';";
                $wyslij3=mysqli_query($polaczenie,$zapytanie3);  
            
            
                while($row3=mysqli_fetch_array($wyslij3)){
                    $id_przedmiotu=$row3['id_przedmiotu'];
                }


                $nauczyciel=@$_POST['nauczyciel'];
                $zapytanie30="SELECT id_nauczyciela from nauczyciele where concat(nauczyciele.nazwisko, ' ', nauczyciele.imie)='".$nauczyciel."';";
                $wyslij30=mysqli_query($polaczenie,$zapytanie30);  
            
            
                while($row30=mysqli_fetch_array($wyslij30)){
                    $id_nauczyciela=$row30['id_nauczyciela'];
                }

                $zapytanie4="INSERT INTO nauczanie (id_klasy, id_przedmiot, id_nauczyciel) VALUES ($id_klasy,$id_przedmiotu,$id_nauczyciela)";
                $wyslij4=mysqli_query($polaczenie,$zapytanie4);

                echo "<p id='add'>Dodano przydział!</p>";
            }
        ?>
    
    
</body>
</html>