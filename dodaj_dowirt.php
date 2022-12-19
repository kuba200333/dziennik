<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
    
    if ($_SESSION['login']!='admin'){
        header("Location: dziennik.php");
    }
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


            echo "<table>";
            echo "<tr><td colspan='2' class='kolumna3'></td></tr>";

            if(!isset($_POST['klasyall'])){
            $zapytanie1="SELECT skrot_klasy FROM klasy where wirt=0 order by skrot_klasy asc ;";
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  

            echo "<tr><td class='kolumna1'>klasy:</td><td class='kolumna2'><select name='klasyall' required onchange='this.form.submit()' >";
            echo "<option value=''</option>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo "<option>".$row1['skrot_klasy']."</option>";
            }
            echo "</select></td></tr>";
            }
            if(isset($_POST['klasyall'])){
            $zapytanie10="SELECT skrot_klasy FROM klasy where wirt=1 order by skrot_klasy asc;";
            $wyslij10=mysqli_query($polaczenie,$zapytanie10);  

           
            echo "<tr><td class='kolumna1'>wirtualna klasa:</td><td class='kolumna2'><select name='klasy' required>";
            echo "<option value=''</option>";
            while($row10=mysqli_fetch_array($wyslij10)){
                echo "<option>".$row10['skrot_klasy']."</option>";
            }
            echo "</select></td></tr>";

            $zapytanie7="SELECT id_klasy from klasy where skrot_klasy='".$_POST['klasyall']."';";

            $wyslij7=mysqli_query($polaczenie,$zapytanie7);
            while($row7=mysqli_fetch_array($wyslij7)){
                $id_klasy=$row7['id_klasy'];
            }
            $zapytanie2="SELECT concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia) as uczen FROM uczniowie  where id_klasy=$id_klasy order by uczen asc;";
            $wyslij2=mysqli_query($polaczenie,$zapytanie2);
    
            echo "<tr><td class='kolumna1'>uczeń:</td><td class='kolumna2'><select name='uczen' required>";
            echo "<option value=''</option>";
            while($row2=mysqli_fetch_array($wyslij2)){
                echo "<option>".$row2[0]."</option>";
            }
            echo "</select></td></tr>";

            }
            
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

                        


                $uczen=@$_POST['uczen'];
                $zapytanie30="SELECT id_ucznia from uczniowie where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)='".$uczen."';";
                $wyslij30=mysqli_query($polaczenie,$zapytanie30);  
            
            
                while($row30=mysqli_fetch_array($wyslij30)){
                    $id_ucznia=$row30['id_ucznia'];
                }

                $zapytanie300="SELECT imie_ucznia from uczniowie where id_ucznia=$id_ucznia;";
                $wyslij300=mysqli_query($polaczenie,$zapytanie300);  
            
            
                while($row300=mysqli_fetch_array($wyslij300)){
                    $imie_ucznia=$row300['imie_ucznia'];
                }

                $zapytanie3000="SELECT nazwisko_ucznia from uczniowie where id_ucznia=$id_ucznia;";
                $wyslij3000=mysqli_query($polaczenie,$zapytanie3000);  
            
            
                while($row3000=mysqli_fetch_array($wyslij3000)){
                    $nazwisko_ucznia=$row3000['nazwisko_ucznia'];
                }

                $zapytanie4="INSERT INTO wirtualne_klasy (id_klasy, id_ucznia, imie_ucznia, nazwisko_ucznia) VALUES ($id_klasy,$id_ucznia,'$imie_ucznia', '$nazwisko_ucznia');";

                $wyslij4=mysqli_query($polaczenie,$zapytanie4);

                echo "<p id='add'>Dodano przydział!</p>";
            }
        ?>
    
    
</body>
</html>