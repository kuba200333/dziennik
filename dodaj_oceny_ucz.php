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
    <title>Dodawanie ocen z przedmiotu</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
<div class="kontener">
        <h4 class="inside">Dodaj ocenę </h4>
        <table>
        <form action="" method='post'>
        <tr><td class='kolumna3' colspan="2"></td></tr>

        <br>

        <?php
            
            $login=$_SESSION['login'];
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            

            echo "<tr><td class='kolumna1'>klasa:</td> <td class='kolumna2'>";

            $zapytanie="SELECT nazwa_klasy from klasy where id_klasy=".$_SESSION['id_klasy'].";";
            $wyslij=mysqli_query($polaczenie,$zapytanie);
            while($row=mysqli_fetch_array($wyslij)){
                echo $row[0];
                $skrot_klasy=$row[0];
            }
            echo "</td></tr>";    
            $zapytanie13="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
            $wyslij13=mysqli_query($polaczenie,$zapytanie13);  
        
        
            while($row13=mysqli_fetch_array($wyslij13)){
                $id_klasy=$row13['id_klasy'];
            }
        

            $zapytanie10="SELECT concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen FROM uczniowie where id_klasy=".$_SESSION['id_klasy']." order by concat(nazwisko_ucznia, ' ', imie_ucznia) asc;";
            $wyslij10=mysqli_query($polaczenie,$zapytanie10);  
            /*
            echo "<tr><td class='kolumna1'>uczeń:</td> <td class='kolumna2'>
            <select name='uczen' required> ";
            echo "<option value=''</option>";
            while($row10=mysqli_fetch_array($wyslij10)){
                echo "<option>".$row10[0]."</option>";
            }
            echo "</select>

            </td></tr>";
            */
            echo "<tr><td class='kolumna1'>uczeń:</td> <td class='kolumna2'>".$_SESSION['uczen']."</td></tr>";
            /*
            $login=$_SESSION['login'];
            if($login != 'admin'){
                $zapytanie="SELECT DISTINCT p.nazwa_przedmiotu as przedmiot FROM nauczanie n inner join klasy k on n.id_klasy=k.id_klasy inner join przedmioty p on n.id_przedmiot=p.id_przedmiotu 
                inner join nauczyciele na on n.id_nauczyciel=na.id_nauczyciela where k.skrot_klasy='$skrot_klasy' and na.login='$login' order by p.nazwa_przedmiotu asc;";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
        
                echo "<tr><td class='kolumna1'>przedmiot:</td> <td class='kolumna2'>";
                if ($wyslij->num_rows>0){
                echo"<select name='przedmiot' required>";
                echo "<option value=''</option>";
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<option>".$row[0]."</option>";
                }
                echo "</select></td></tr>";
                } else{
                    $nie_uczy=1;
                    echo "Nie uczysz w tej klasie";
                }
            }
            if($login == 'admin'){
                $zapytanie="SELECT DISTINCT p.nazwa_przedmiotu as przedmiot FROM nauczanie n inner join klasy k on n.id_klasy=k.id_klasy inner join przedmioty p on n.id_przedmiot=p.id_przedmiotu 
                inner join nauczyciele na on n.id_nauczyciel=na.id_nauczyciela where k.skrot_klasy='$skrot_klasy' order by p.nazwa_przedmiotu asc;";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
            
                echo "<tr><td class='kolumna1'>przedmiot:</td> <td class='kolumna2'>";
                if ($wyslij->num_rows>0){
                echo"<select name='przedmiot' required>";
                echo "<option value=''</option>";
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<option>".$row[0]."</option>";
                }
                echo "</select></td></tr>";
                } else{
                    echo "Nie uczysz w tej klasie";
                }
            }
*/
            echo "<tr><td class='kolumna1'>przedmiot:</td> <td class='kolumna2'>".$_SESSION['przedmiot']."</td></tr>";

            $zapytanie5="SELECT nazwa_kategorii FROM `kategorie_ocen` where id_kategorii not in (9,10) order by nazwa_kategorii asc;";
            
            $wyslij5=mysqli_query($polaczenie,$zapytanie5);
            
            echo "<tr><td class='kolumna1'>kategoria:</td> <td class='kolumna2'><select name='kategoria' required>";
            echo "<option value=''</option>";
            while($row5=mysqli_fetch_array($wyslij5)){
                echo "<option>".$row5['nazwa_kategorii']."</option>";
            }
            echo "</select></td></tr>";        
            
            echo <<<END
            <tr><td class='kolumna1'>ocena</td><td class='kolumna2'>
            <input list='oceny' name='ocena'>
            <datalist id='oceny' required>
                <option>1</option>
                <option>1+</option>
                <option>2-</option>
                <option>2</option>
                <option>2+</option>
                <option>3-</option>
                <option>3</option>
                <option>3+</option>
                <option>4-</option>
                <option>4</option>
                <option>4+</option>
                <option>5-</option>
                <option selected>5</option>
                <option>5+</option>
                <option>6-</option>
                <option>6</option>
                <option>+</option>
                <option>-</option>
            </datalist>
            
            </td></tr>

            </td></tr>

            
            END;
            $zapytanie1="SELECT id_nauczyciela, concat(nazwisko, ' ', imie) as nauczyciel FROM `nauczyciele` where login='$login';";
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);
    
            $login=$_SESSION['login'];
            echo "<tr><td class='kolumna1'>nauczyciel:</td> <td class='kolumna2'>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo $row1['nauczyciel']."<input type='hidden' value='$row1[1]' name='nauczyciel'>";  
            }
            echo "</tr>";

            $d=mktime();
            $date=date("Y-m-d", $d);

            echo "<tr><td class='kolumna1'>data</td><td class='kolumna2'><input type='date' value='$date' name='data' required></td></tr>";

            echo "<tr><td class='kolumna1'>komentarz</td><td class='kolumna2'><textarea name='komentarz'></textarea></td></tr>";
            
            if(isset($nie_uczy)){
                echo <<<END
                <tr class='inside'><td class='kolumna3' colspan='2'><input type='submit' value='Zamknij' name='zamknij' onclick="window.open('', '_self', ''); window.close();"></td></tr>
                END;
            }
            if(!isset($nie_uczy)){
                echo <<<END
                <tr class='inside'><td class='kolumna3' colspan='2'>
                <input value='Dodaj' type='submit' name='wysylacz'>
                <input type='submit' value='Zamknij' name='zamknij' onclick="window.open('', '_self', ''); window.close();"></td></tr>
                END;
            }

            mysqli_close($polaczenie);
        



    echo "</table></form>";


    
    if (isset($_POST['wysylacz'])) {
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $data=$_POST['data'];  
        $ocena=$_POST['ocena'];  
        $uczen=$_SESSION['uczen'];
        $komentarz=$_POST['komentarz'];
        
        $kategoria=$_POST['kategoria'];
        $nauczyciel=$_POST['nauczyciel'];  
       

        if($ocena=="1+"){
            $ocena=1.5;
        }else if($ocena=="2-"){
            $ocena=1.75;
        }else if($ocena=="2+"){
            $ocena=2.5;
        }else if($ocena=="3-"){
            $ocena=2.75;
        }else if($ocena=="3+"){
            $ocena=3.5;
        }else if($ocena=="4-"){
            $ocena=3.75;
        }else if($ocena=="4+"){
            $ocena=4.5;
        }else if($ocena=="5-"){
            $ocena=4.75;
        }else if($ocena=="5+"){
            $ocena=5.5;
        }else if($ocena=="6-"){
            $ocena=5.75;
        }else if($ocena=="+"){
            $ocena=0.5;
        }else if($ocena=="-"){
            $ocena=0.25;
        }

        
        $id_przedmiotu=$_SESSION['id_przedmiot'];
        
    
        $zapytanie4="SELECT id_nauczyciela from `nauczyciele` where concat(nazwisko, ' ', imie)='$nauczyciel';";

        $wyslij4=mysqli_query($polaczenie,$zapytanie4);
    

        while($row4=mysqli_fetch_array($wyslij4)){
            $id_nauczyciela=$row4['id_nauczyciela'];
        }

        $zapytanie7="SELECT id_kategorii from kategorie_ocen where nazwa_kategorii='$kategoria';";

        $wyslij7=mysqli_query($polaczenie,$zapytanie7);
    

        while($row7=mysqli_fetch_array($wyslij7)){
            $id_kategorii=$row7['id_kategorii'];
        }

                
        $zapytanie9="SELECT id_ucznia FROM uczniowie where concat(nazwisko_ucznia, ' ', imie_ucznia)='$uczen';";

        $wyslij9=mysqli_query($polaczenie,$zapytanie9);  

        while($row9=mysqli_fetch_array($wyslij9)){
            $id_ucznia=$row9['id_ucznia'];
        }


        $zapytanie12="SELECT waga from kategorie_ocen where id_kategorii=$id_kategorii;";
        $wyslij12=mysqli_query($polaczenie,$zapytanie12);  

        while($row12=mysqli_fetch_array($wyslij12)){
            $waga=$row12['waga'];
        }

        $zapytanie20="SELECT id from semestry where '$data' between od and do;";
        $wyslij20=mysqli_query($polaczenie,$zapytanie20);
        while($row20=mysqli_fetch_array($wyslij20)){
            $semestr=$row20[0];
        }

        
        $zapytanie3="INSERT INTO oceny (id_oceny, id_przedmiotu, ocena, data, id_nauczyciela, id_kategorii, id_ucznia, semestr,komentarz, waga) VALUES (null,".$id_przedmiotu.",$ocena,'$data',$id_nauczyciela, $id_kategorii, $id_ucznia, $semestr, '$komentarz', $waga);";

        $wyslij3=mysqli_query($polaczenie,$zapytanie3);

        mysqli_close($polaczenie);
    }
    
    ?>
    </div>
</body>
</html>