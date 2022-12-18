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
    <h4 class="inside">Usuń przydział nauczyciela</h4>
    <form action="" method='post'>
        <?php
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

            $zapytanie1="SELECT skrot_klasy FROM klasy order by skrot_klasy asc;";
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  

            echo "<table>";
            echo "<tr><td colspan='2' class='kolumna3'></td></tr>";
            echo "<tr><td class='kolumna1'>klasy:</td><td class='kolumna2'><select name='klasy' >";
            echo "<option value=''</option>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo "<option>".$row1['skrot_klasy']."</option>";
            }
            echo "</select></td></tr>";
        

            $zapytanie="SELECT DISTINCT nazwa_przedmiotu from nauczanie inner join przedmioty on nauczanie.id_przedmiot=przedmioty.id_przedmiotu where nazwa_przedmiotu != 'zachowanie' order by nazwa_przedmiotu asc;";
            $wyslij=mysqli_query($polaczenie,$zapytanie);
    
            echo "<tr><td class='kolumna1'>przedmiot:</td><td class='kolumna2'><select name='przedmiot'>";
            echo "<option value=''</option>";
            while($row=mysqli_fetch_array($wyslij)){
                echo "<option>".$row[0]."</option>";
            }
            echo "</select></td></tr>";
            

            $zapytanie2="SELECT DISTINCT concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as nauczyciel FROM nauczyciele inner join nauczanie on nauczyciele.id_nauczyciela=nauczanie.id_nauczyciel  order by nauczyciel asc;";
            $wyslij2=mysqli_query($polaczenie,$zapytanie2);
    
            echo "<tr><td class='kolumna1'>nauczyciel:</td><td class='kolumna2'><select name='nauczyciel'>";
            echo "<option value=''</option>";
            while($row2=mysqli_fetch_array($wyslij2)){
                echo "<option>".$row2[0]."</option>";
            }
            echo "</select></td></tr>";
            
            
            mysqli_close($polaczenie);

        ?>
        <tr><td class="kolumna3" colspan="2"><input value="Usuń" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr>
        </table>

    </form></div> 
        <?php
            if(!empty($_POST['wysylacz'])){

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $skrot_klasy=$_POST['klasy'];
            
                
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

                $zapytanie4="DELETE FROM nauczanie WHERE id_klasy=$id_klasy and id_przedmiot=$id_przedmiotu and id_nauczyciel=$id_nauczyciela";
                $wyslij4=mysqli_query($polaczenie,$zapytanie4);
                echo "<p id='add'>Usunięto przydział!</p>";
            }
        ?>
    
    
</body>
</html>