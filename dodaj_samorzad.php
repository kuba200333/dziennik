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
    <title>Dodaj samorząd klasowy</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
<h4 class="inside">Dodaj lub zmień samorząd klasowy </h4>
    <div id='semestr1'>
        <form action='' method='post'>

        <?php
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie11="SELECT skrot_klasy FROM klasy;";
            $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
            echo "<table>";
            echo "<tr><td class='1'>Wybierz klasę:</td> <td class='2'><select name='klasy' onchange='this.form.submit()'>";
            echo "<option value=''</option>";
            while($row11=mysqli_fetch_array($wyslij11)){
                echo "<option>".$row11['skrot_klasy']."</option>";
            }
            echo "</select></td></tr>";
            
            
            mysqli_close($polaczenie);
            
            if(empty($_POST['klasy'])){
                echo <<<END
                <tr class='inside'><td class='3' colspan='2'><input type='submit' value='Zamknij' name='zamknij' onclick="window.open('', '_self', ''); window.close();"></td></tr>
                END;
                }
            echo "</table>";    
        ?>
        <?php
            if(!empty($_POST['klasy'])){
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);       
                $skrot_klasy=@$_POST['klasy'];

            $zapytanie5="SELECT id_klasy FROM `klasy` where skrot_klasy='$skrot_klasy'";
            $wyslij5=mysqli_query($polaczenie,$zapytanie5);

            while($row5=mysqli_fetch_array($wyslij5)){
                $id_klasy=$row5['id_klasy'];
            }
            echo "<table>";

            $zapytanie="SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen, id_klasy, funkcja FROM `uczniowie` where id_klasy=$id_klasy";

            $wyslij=mysqli_query($polaczenie,$zapytanie);
            
            echo "<tr><td class='1'>Wybierz ucznia</td>";
            echo "<td class='2'><select name='uczniowie'>";
            echo "<option></option>";
            while($row=mysqli_fetch_array($wyslij)){
                echo "<option>".$row['uczen']."</option>";
            }
            echo "</select></td></tr>";

            $zapytanie1="SELECT * FROM `funkcje`";
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);
            echo "<tr><td class='1'>Wybierz funkcję</td>";
            echo "<td class='2'><select name='funkcje'>";
            echo "<option></option>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo "<option>".$row1['nazwa']."</option>";
            }
            echo "</select></td></tr>";

            echo<<<END
            <tr class='inside'><td class="3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr>
            END;
            echo "</table>";
            }
            if(!empty($_POST['wyslij'])){
                $polaczenie=mysqli_connect("localhost","root","","dziennik");    
                $uczen=$_POST['uczniowie'];
    
                $zapytanie2="SELECT id_ucznia FROM `uczniowie` where concat(nazwisko_ucznia, ' ', imie_ucznia)='$uczen'";
            
                $wyslij2=mysqli_query($polaczenie,$zapytanie2);
    
                while($row2=mysqli_fetch_array($wyslij2)){
                    $id_ucznia=$row2['id_ucznia'];
                }
    
    
                $funkcja=$_POST['funkcje'];
               
                $zapytanie3="SELECT id_funkcji FROM `funkcje` where nazwa='$funkcja'";
      
      
                $wyslij3=mysqli_query($polaczenie,$zapytanie3);
    
                while($row3=mysqli_fetch_array($wyslij3)){
                    $id_funkcji=$row3['id_funkcji'];
                }
    
    
                $zapytanie4="UPDATE uczniowie SET funkcja='$id_funkcji' WHERE id_ucznia='$id_ucznia'";
    
                $wyslij4=mysqli_query($polaczenie,$zapytanie4);
                mysqli_close($polaczenie);
    
                header("Location: \dziennik_lekcyjny\podglad_samorzady.php");
            }
            ?>
            </form>
    </div>

</body>
</html>