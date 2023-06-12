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
    <title>Dodawanie ocen z zachowania</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
<div class="kontener">
        <h4 class="inside">Dodaj ocenę </h4>
        <table>
        <form action="" method='post'>
        <tr><td class='3' colspan="2"></td></tr>
        <?php
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie11="SELECT skrot_klasy FROM klasy where wirt=0 order by skrot_klasy asc;";
            $wyslij11=mysqli_query($polaczenie,$zapytanie11);  

            echo "<tr><td class='1'>klasa:</td> <td class='2'>";
            if(empty($_POST['klasy'])){
            echo"<select name='klasy' onchange='this.form.submit()'>";
            echo "<option value=''</option>";
            while($row11=mysqli_fetch_array($wyslij11)){
                echo "<option>".$row11['skrot_klasy']."</option>";
            }
            echo "</select>";
            } else{
                echo $_POST['klasy'];
            }
            mysqli_close($polaczenie);
            
            if(empty($_POST['klasy'])){
                echo <<<END
                <tr class='inside'><td class='3' colspan='2'><input type='submit' value='Zamknij' name='zamknij' onclick="window.open('', '_self', ''); window.close();"></td></tr>
                END;
                }
        ?>     
           
  

        <br>

        <?php
            if(!empty($_POST['klasy'])){
            echo<<<END
            
                <tr><td class='1'>ocena</td><td class='2'>
                    <select name='ocena'>
                        <option></option>
                        <option>wzorowe</option>
                        <option>bardzo dobre</option>
                        <option>dobre</option>
                        <option>poprawne</option>
                        <option>nieodpowiednie</option>
                        <option>naganne</option>
                    </select>
                </tr>

                </td></tr>

                
                
            END;
          
            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);       
            $skrot_klasy=@$_POST['klasy'];

    
            $zapytanie13="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
            $wyslij13=mysqli_query($polaczenie,$zapytanie13);  
        
        
            while($row13=mysqli_fetch_array($wyslij13)){
                $id_klasy=$row13['id_klasy'];
            }
        

            $zapytanie10="SELECT concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen FROM uczniowie where id_klasy=$id_klasy order by uczen asc;";
            $wyslij10=mysqli_query($polaczenie,$zapytanie10);  
            
            echo "<tr><td class='1'>uczeń:</td> <td class='2'><select name='uczen'>";
            echo "<option value=''</option>";
            while($row10=mysqli_fetch_array($wyslij10)){
                echo "<option>".$row10[0]."</option>";
            }
            echo "</select></td></tr>";


    
            $zapytanie5="SELECT nazwa_kategorii FROM `kategorie_ocen` where id_kategorii in (5,6,7,8);";
            
            $wyslij5=mysqli_query($polaczenie,$zapytanie5);
            
            echo "<tr><td class='1'>kategoria:</td> <td class='2'><select name='kategoria'>";
            echo "<option value=''</option>";
            while($row5=mysqli_fetch_array($wyslij5)){
                echo "<option>".$row5['nazwa_kategorii']."</option>";
            }
            echo "</select></td></tr>";        
    
            $login=$_SESSION['login'];
            $zapytanie1="SELECT id_nauczyciela, concat(nazwisko, ' ', imie) as nauczyciel FROM `nauczyciele` where login='$login';";
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);
    
    
            echo "<tr><td class='1'>nauczyciel:</td> <td class='2'>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo $row1['nauczyciel']."<input type='hidden' value='$row1[1]' name='nauczyciel'>";
            }
            echo "</tr>";

            $d=mktime();
            $date=date("Y-m-d", $d);

            echo "<tr><td class='1'>data</td><td class='2'><input type='date' value='$date' name='data'></td></tr>";

            echo "<tr><td class='1'>komentarz</td><td class='2'><textarea name='komentarz'></textarea></td></tr>";
        
            mysqli_close($polaczenie);
            echo <<<END
            <tr><td class="3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'><input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr>
            END;
        }
        ?> 
        
        
        </table>
</form>
<?php
    
    if (isset($_POST['wysylacz'])) {
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $data=$_POST['data'];  
        $przedmiot='zachowanie';
        $ocena=$_POST['ocena'];  
        $uczen=$_POST['uczen'];
        $komentarz=$_POST['komentarz'];
        $kategoria=$_POST['kategoria'];
        $nauczyciel=$_POST['nauczyciel'];  
        $zapytanie2='SELECT id_przedmiotu from przedmioty where nazwa_przedmiotu="'.$przedmiot.'";';
        $wyslij2=mysqli_query($polaczenie,$zapytanie2);

        if($ocena=='wzorowe'){
            $ocena=6;
        }else if($ocena=='bardzo dobre'){
            $ocena=5;
        }else if($ocena=='dobre'){
            $ocena=4;
        }else if($ocena=='poprawne'){
            $ocena=3;
        }else if($ocena=='nieodpowiednie'){
            $ocena=2;
        }else if($ocena=='naganne'){
            $ocena=1;
        }else if($ocena=='negatywne'){
            $ocena=0;
        }else if($ocena=='pozytywne'){
            $ocena=0;
        }



        while($row2=mysqli_fetch_array($wyslij2)){
            $id_przedmiotu=$row2['id_przedmiotu'];
        }
    
        $zapytanie4="SELECT id_nauczyciela from nauczyciele where concat(nazwisko, ' ', imie)='$nauczyciel';";

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

        $zapytanie20="SELECT id from semestry where '$data' between od and do;";
        $wyslij20=mysqli_query($polaczenie,$zapytanie20);
        while($row20=mysqli_fetch_array($wyslij20)){
            $semestr=$row20[0];
        }
        if($semestr==1){
        $zapytanie3="INSERT INTO oceny_zachowanie (id_oceny, id_przedmiotu, ocena, data, id_nauczyciela, id_kategorii, id_ucznia, semestr,komentarz) VALUES (null,".$id_przedmiotu.",$ocena,'$data',$id_nauczyciela, $id_kategorii, $id_ucznia, $semestr, '$komentarz');";
        }else if($semestr=2){
            $zapytanie3="INSERT INTO oceny_zachowanie2 (id_oceny, id_przedmiotu, ocena, data, id_nauczyciela, id_kategorii, id_ucznia, semestr,komentarz) VALUES (null,".$id_przedmiotu.",$ocena,'$data',$id_nauczyciela, $id_kategorii, $id_ucznia, $semestr, '$komentarz');";
        }
        $wyslij3=mysqli_query($polaczenie,$zapytanie3);

        mysqli_close($polaczenie);
   
    }
    
    ?>
    </div>
</body>
</html>