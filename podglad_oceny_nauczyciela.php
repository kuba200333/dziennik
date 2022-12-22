<<<<<<< HEAD
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
    <title>Podgląd ocen</title>
    <link rel="stylesheet" href="styl6.css">
</head>
<body>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\moje_przedmioty.php">Powrót do nauczanych przedmiotów <br></a>

        </div>
        <div id="naglowek2">

            <h2>Oceny uczniów nauczane w danej klasie</h2>
        </div>
        
        <div id='wybierz'>
        
        <?php
            
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

            if(isset($_POST['id_klasy'])){
            $_SESSION['id_klasy']=$_POST['id_klasy'];
            $_SESSION['id_przedmiot']=$_POST['id_przedmiot'];

            $id_klasy=$_SESSION['id_klasy'];
            $id_przedmiot=$_SESSION['id_przedmiot'];
            }
            if(!isset($_POST['id_klasy'])){
    
                $id_klasy=$_SESSION['id_klasy'];
                $id_przedmiot=$_SESSION['id_przedmiot'];
            }

            
            echo "<br>";
    

            $zapytanie10="SELECT concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen FROM uczniowie where id_klasy=$id_klasy UNION SELECT concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen FROM wirtualne_klasy where id_klasy=$id_klasy order by uczen asc;";

                $wyslij10=mysqli_query($polaczenie,$zapytanie10);  

            
            echo "<form action='' method='post'>";
                echo "uczeń: <select name='uczen' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row10=mysqli_fetch_array($wyslij10)){
                    echo "<option>".$row10[0]."</option>";
                }
                echo "</select><br>";

            
            echo "<input type='hidden' name='id_przedmiot' value='$id_przedmiot'>";
            
            echo"</form>";
            
            mysqli_close($polaczenie);
                
            
                if((!empty($_POST['uczen']))){
                    require "connect.php";

                    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                    $uczen=@$_POST['uczen'];
                    $_SESSION['uczen']=$uczen;
                    $id_przedmiot=@$_POST['id_przedmiot'];

                    $zapytanie11="SELECT nazwa_przedmiotu from przedmioty where id_przedmiotu=$id_przedmiot;";
                    
                    $wyslij11=mysqli_query($polaczenie,$zapytanie11);
                    while($row11=mysqli_fetch_array($wyslij11)){
                        $przedmiot=$row11[0];
                        $_SESSION['przedmiot']=$przedmiot;
                    }
                    echo "<br><b>Przedmiot: </b>". $przedmiot. "<br>";
                    echo "<b>Uczeń: </b>". $uczen;
                }
            ?>
        
            
            <br>
          
        </div>
        <div id="glowny1">

            <?php
        if(!empty($_POST['uczen'])){
            $login=$_SESSION['login'];
            $uczen=@$_POST['uczen'];
            $id_przedmiotu=@$_POST['id_przedmiot'];

            echo "<h3>Semestr 1</h3>";

            $zapytanie3="SELECT id_ucznia FROM uczniowie where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)='$uczen';";
            $wyslij3=mysqli_query($polaczenie,$zapytanie3);
            while($row3=mysqli_fetch_array($wyslij3)){
                $id_ucznia=$row3[0];
            }

            $zapytanie4="SELECT count(*) from frekwencja where id_przedmiot=$id_przedmiot and id_ucznia=$id_ucznia and typ_ob in('zw','sp','ob') and semestr=1;";

            
            $wyslij4=mysqli_query($polaczenie,$zapytanie4);
            while($row4=mysqli_fetch_array($wyslij4)){
                $obecnosc=$row4[0];
            }

            $zapytanie5="SELECT count(*) from frekwencja where id_przedmiot=$id_przedmiot and id_ucznia=$id_ucznia and typ_ob in('u','nb') and semestr=1;";

            $wyslij5=mysqli_query($polaczenie,$zapytanie5);
            while($row5=mysqli_fetch_array($wyslij5)){
                $nieobecnosc=$row5[0];
            }
            if($nieobecnosc+$obecnosc==0){
                echo"<br><b>Frekwencja:</b> 0%<br>";
            }else{
                echo "<br><b>Frekwencja:</b> ".round(($obecnosc/($nieobecnosc+$obecnosc)*100),2)."%<br>";
            }
            
            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor from oceny 
            inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
            inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' and przedmioty.id_przedmiotu='$id_przedmiotu' and semestr=1 order by data asc;";
            
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
            if ($wyslij1->num_rows>0){
                echo "<b>Śródroczna średnia ważona ocen: </b>";
    
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join 
                przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie 
                on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on 
                oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on 
                oceny.id_nauczyciela=nauczyciele.id_nauczyciela where 
                concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' 
                and przedmioty.id_przedmiotu='$id_przedmiotu' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=1 and oceny.ocena between 1 and 6;";
                $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
        
                while($row2=mysqli_fetch_array($wyslij2)){
                    if($row2[0]==null){
                        echo "-";
                    }else{
                        echo $row2[0];
                    }
                }

                echo "<table>";
                echo "<tr><th>ocena</th><th>kategoria</th><th>waga</th><th>Komentarz</th><th>data</th><th>dodał</th><th>usuń</th></tr>";
                while($row1=mysqli_fetch_array($wyslij1)){
                    echo "<tr style='background-color:".$row1['kolor'].";'><td id=".$row1['ocena'].">";
                    if($row1['ocena']==1.5){
                        echo "1+";
                    }else if ($row1['ocena']==1.75){
                        echo "2-";
                    }else if ($row1['ocena']==2.5){
                        echo "2+";
                    }else if ($row1['ocena']==2.75){
                        echo "3-";
                    }else if ($row1['ocena']==3.5){
                        echo "3+";
                    }else if ($row1['ocena']==3.75){
                        echo "4-";
                    }else if ($row1['ocena']==4.5){
                        echo "4+";
                    }else if ($row1['ocena']==4.75){
                        echo "5-";
                    }else if ($row1['ocena']==5.5){
                        echo "5+";
                    }else if ($row1['ocena']==5.75){
                        echo "6-";
                    }else if ($row1['ocena']==0.5){
                        echo "+";
                    }else if ($row1['ocena']==0.25){
                        echo "-";
                    }else if ($row1['ocena']==0.01){
                        echo "nk";
                    }else if ($row1['ocena']==0.02){
                        echo "zw";
                    }else{
                        echo $row1['ocena'];
                    }
                    
           
                    echo "</td><td>".$row1['nazwa_kategorii']."</td><td>";
                    if($row1['waga']==0 or $row1['ocena']==0.5 or $row1['ocena']==0.25){
                        echo "";
                    }else{
                        echo $row1['waga'];
                    }
                    echo"</td><td>".$row1['komentarz']."</td><td>".$row1['data']."</td><td>".$row1['dodal']."</td>";
                    if($login==$row1['login'] or $_SESSION['admin'] ==1){
                    echo"<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'><input type='submit' name='usun' value='X'></form></td></tr>";
                    }else{
                        echo"<td></td></tr>";
                    }
                }
                echo "</table>";
    

            }
            else{
                echo "Uczeń nie posiada ocen!";
            }
    
            mysqli_close($polaczenie);

        }
        ?>
        </div>

        <div id="glowny2">
        <?php
        if(!empty($_POST['uczen'])){
            $login=$_SESSION['login'];
            $uczen=@$_POST['uczen'];
            $id_przedmiotu=@$_POST['id_przedmiot'];

            echo "<h3>Semestr 2</h3>";
    
            
            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor  from oceny 
            inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
            inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' and przedmioty.id_przedmiotu='$id_przedmiotu' and semestr=2 order by data asc;";

            $zapytanie3="SELECT id_ucznia FROM uczniowie where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)='$uczen';";
            $wyslij3=mysqli_query($polaczenie,$zapytanie3);
            while($row3=mysqli_fetch_array($wyslij3)){
                $id_ucznia=$row3[0];
            }

            $zapytanie4="SELECT count(*) from frekwencja where id_przedmiot=$id_przedmiot and id_ucznia=$id_ucznia and typ_ob in('zw','sp','ob') and semestr=2;";


            $wyslij4=mysqli_query($polaczenie,$zapytanie4);
            while($row4=mysqli_fetch_array($wyslij4)){
                $obecnosc=$row4[0];
            }

            $zapytanie5="SELECT count(*) from frekwencja where id_przedmiot=$id_przedmiot and id_ucznia=$id_ucznia and typ_ob in('u','nb') and semestr=2;";

            $wyslij5=mysqli_query($polaczenie,$zapytanie5);
            while($row5=mysqli_fetch_array($wyslij5)){
                $nieobecnosc=$row5[0];
            }
            if($nieobecnosc+$obecnosc==0){
                echo"<br><b>Frekwencja:</b> 0%<br>";
            }else{
                echo "<br><b>Frekwencja:</b> ".round(($obecnosc/($nieobecnosc+$obecnosc)*100),2)."%<br>";
            }

            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
            if ($wyslij1->num_rows>0){
                echo "<b>Roczna średnia ważona ocen: </b>";
    
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join 
                przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie 
                on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on 
                oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on 
                oceny.id_nauczyciela=nauczyciele.id_nauczyciela where 
                concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' 
                and przedmioty.id_przedmiotu='$id_przedmiotu' and kategorie_ocen.id_kategorii not in (5,6,7,8) and oceny.ocena between 1 and 6;";
                $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
        
                while($row2=mysqli_fetch_array($wyslij2)){
                    if($row2[0]==null){
                        echo "-";
                    }else{
                        echo $row2[0];
                    }
                }

            echo "<table>";
            echo "<tr><th>ocena</th><th>kategoria</th><th>waga</th><th>Komentarz</th><th>data</th><th>dodał</th><th>usuń</th></tr>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo "<tr style='background-color:".$row1['kolor'].";'><td id=".$row1['ocena'].">";
                if($row1['ocena']==1.5){
                    echo "1+";
                }else if ($row1['ocena']==1.75){
                    echo "2-";
                }else if ($row1['ocena']==2.5){
                    echo "2+";
                }else if ($row1['ocena']==2.75){
                    echo "3-";
                }else if ($row1['ocena']==3.5){
                    echo "3+";
                }else if ($row1['ocena']==3.75){
                    echo "4-";
                }else if ($row1['ocena']==4.5){
                    echo "4+";
                }else if ($row1['ocena']==4.75){
                    echo "5-";
                }else if ($row1['ocena']==5.5){
                    echo "5+";
                }else if ($row1['ocena']==5.75){
                    echo "6-";
                }else if ($row1['ocena']==0.5){
                    echo "+";
                }else if ($row1['ocena']==0.25){
                    echo "-";
                }else if ($row1['ocena']==0.01){
                    echo "nk";
                }else if ($row1['ocena']==0.02){
                    echo "zw";
                }else{
                    echo $row1['ocena'];
                }
                
                echo "</td><td>".$row1['nazwa_kategorii']."</td><td>";
                if($row1['waga']==0 or $row1['ocena']==0.5 or $row1['ocena']==0.25){
                    echo "";
                }else{
                    echo $row1['waga'];
                }
                echo"</td><td>".$row1['komentarz']."</td><td>".$row1['data']."</td><td>".$row1['dodal']."</td>";
                if($login==$row1['login'] or $_SESSION['admin'] ==1){
                echo"<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'><input type='submit' name='usun' value='X'></form></td></tr>";
                }else{
                    echo"<td></td></tr>";
                }
            }
            echo "</table>";
    

            }
            else{
                echo "Uczeń nie posiada ocen!";
            }
    
            mysqli_close($polaczenie);

        }
        ?>
        </div>

        <div id="stopka">
            <?php
            if(!empty($_POST['uczen'])){
                echo <<<END
                    <a href="\dziennik_lekcyjny\dodaj_oceny_ucz.php" onclick="window.open('dodaj_oceny_ucz.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=400').focus(); return false">Dodaj ocenę</a>
                END;
        }
        ?>
        </div>
    </div>

        <?php
                if(!empty($_POST['usun'])){
                $id_oceny=$_POST['id_oceny'];


                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie="DELETE FROM oceny WHERE id_oceny='$id_oceny';";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
          
                }
                ?>


</body>
=======
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
    <title>Podgląd ocen</title>
    <link rel="stylesheet" href="styl6.css">
</head>
<body>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\moje_przedmioty.php">Powrót do nauczanych przedmiotów <br></a>

        </div>
        <div id="naglowek2">

            <h2>Oceny uczniów nauczane w danej klasie</h2>
        </div>
        
        <div id='wybierz'>
        
        <?php
            
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

            if(isset($_POST['id_klasy'])){
            $_SESSION['id_klasy']=$_POST['id_klasy'];
            $_SESSION['id_przedmiot']=$_POST['id_przedmiot'];

            $id_klasy=$_SESSION['id_klasy'];
            $id_przedmiot=$_SESSION['id_przedmiot'];
            }
            if(!isset($_POST['id_klasy'])){
    
                $id_klasy=$_SESSION['id_klasy'];
                $id_przedmiot=$_SESSION['id_przedmiot'];
            }

            
            echo "<br>";
    

            $zapytanie10="SELECT concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen FROM uczniowie where id_klasy=$id_klasy UNION SELECT concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen FROM wirtualne_klasy where id_klasy=$id_klasy order by uczen asc;";

                $wyslij10=mysqli_query($polaczenie,$zapytanie10);  

            
            echo "<form action='' method='post'>";
                echo "uczeń: <select name='uczen' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row10=mysqli_fetch_array($wyslij10)){
                    echo "<option>".$row10[0]."</option>";
                }
                echo "</select><br>";

            
            echo "<input type='hidden' name='id_przedmiot' value='$id_przedmiot'>";
            
            echo"</form>";
            
            mysqli_close($polaczenie);
                
            
                if((!empty($_POST['uczen']))){
                    require "connect.php";

                    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                    $uczen=@$_POST['uczen'];
                    $_SESSION['uczen']=$uczen;
                    $id_przedmiot=@$_POST['id_przedmiot'];

                    $zapytanie11="SELECT nazwa_przedmiotu from przedmioty where id_przedmiotu=$id_przedmiot;";
                    
                    $wyslij11=mysqli_query($polaczenie,$zapytanie11);
                    while($row11=mysqli_fetch_array($wyslij11)){
                        $przedmiot=$row11[0];
                        $_SESSION['przedmiot']=$przedmiot;
                    }
                    echo "<br><b>Przedmiot: </b>". $przedmiot. "<br>";
                    echo "<b>Uczeń: </b>". $uczen;
                }
            ?>
        
            
            <br>
          
        </div>
        <div id="glowny1">

            <?php
        if(!empty($_POST['uczen'])){
            $login=$_SESSION['login'];
            $uczen=@$_POST['uczen'];
            $id_przedmiotu=@$_POST['id_przedmiot'];

            echo "<h3>Semestr 1</h3>";

            $zapytanie3="SELECT id_ucznia FROM uczniowie where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)='$uczen';";
            $wyslij3=mysqli_query($polaczenie,$zapytanie3);
            while($row3=mysqli_fetch_array($wyslij3)){
                $id_ucznia=$row3[0];
            }

            $zapytanie4="SELECT count(*) from frekwencja where id_przedmiot=$id_przedmiot and id_ucznia=$id_ucznia and typ_ob in('zw','sp','ob') and semestr=1;";

            
            $wyslij4=mysqli_query($polaczenie,$zapytanie4);
            while($row4=mysqli_fetch_array($wyslij4)){
                $obecnosc=$row4[0];
            }

            $zapytanie5="SELECT count(*) from frekwencja where id_przedmiot=$id_przedmiot and id_ucznia=$id_ucznia and typ_ob in('u','nb') and semestr=1;";

            $wyslij5=mysqli_query($polaczenie,$zapytanie5);
            while($row5=mysqli_fetch_array($wyslij5)){
                $nieobecnosc=$row5[0];
            }
            if($nieobecnosc+$obecnosc==0){
                echo"<br><b>Frekwencja:</b> 0%<br>";
            }else{
                echo "<br><b>Frekwencja:</b> ".round(($obecnosc/($nieobecnosc+$obecnosc)*100),2)."%<br>";
            }
            
            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor from oceny 
            inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
            inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' and przedmioty.id_przedmiotu='$id_przedmiotu' and semestr=1 order by data asc;";
            
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
            if ($wyslij1->num_rows>0){
                echo "<b>Średnia ważona ocen: </b>";
    
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join 
                przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie 
                on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on 
                oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on 
                oceny.id_nauczyciela=nauczyciele.id_nauczyciela where 
                concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' 
                and przedmioty.id_przedmiotu='$id_przedmiotu' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=1 and oceny.ocena between 1 and 6;";
                $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
        
                while($row2=mysqli_fetch_array($wyslij2)){
                    if($row2[0]==null){
                        echo "-";
                    }else{
                        echo $row2[0];
                    }
                }

                echo "<table>";
                echo "<tr><th>ocena</th><th>kategoria</th><th>waga</th><th>Komentarz</th><th>data</th><th>dodał</th><th>usuń</th></tr>";
                while($row1=mysqli_fetch_array($wyslij1)){
                    echo "<tr style='background-color:".$row1['kolor'].";'><td id=".$row1['ocena'].">";
                    if($row1['ocena']==1.5){
                        echo "1+";
                    }else if ($row1['ocena']==1.75){
                        echo "2-";
                    }else if ($row1['ocena']==2.5){
                        echo "2+";
                    }else if ($row1['ocena']==2.75){
                        echo "3-";
                    }else if ($row1['ocena']==3.5){
                        echo "3+";
                    }else if ($row1['ocena']==3.75){
                        echo "4-";
                    }else if ($row1['ocena']==4.5){
                        echo "4+";
                    }else if ($row1['ocena']==4.75){
                        echo "5-";
                    }else if ($row1['ocena']==5.5){
                        echo "5+";
                    }else if ($row1['ocena']==5.75){
                        echo "6-";
                    }else if ($row1['ocena']==0.5){
                        echo "+";
                    }else if ($row1['ocena']==0.25){
                        echo "-";
                    }else{
                        echo $row1['ocena'];
                    }
                    
           
                    echo "</td><td>".$row1['nazwa_kategorii']."</td><td>";
                    if($row1['waga']==0 or $row1['ocena']==0.5 or $row1['ocena']==0.25){
                        echo "";
                    }else{
                        echo $row1['waga'];
                    }
                    echo"</td><td>".$row1['komentarz']."</td><td>".$row1['data']."</td><td>".$row1['dodal']."</td>";
                    if($login==$row1['login']){
                    echo"<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'><input type='submit' name='usun' value='X'></form></td></tr>";
                    }else{
                        echo"<td></td></tr>";
                    }
                }
                echo "</table>";
    

            }
            else{
                echo "Uczeń nie posiada ocen!";
            }
    
            mysqli_close($polaczenie);

        }
        ?>
        </div>

        <div id="glowny2">
        <?php
        if(!empty($_POST['uczen'])){
            $login=$_SESSION['login'];
            $uczen=@$_POST['uczen'];
            $id_przedmiotu=@$_POST['id_przedmiot'];

            echo "<h3>Semestr 2</h3>";
    
            
            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor  from oceny 
            inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
            inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' and przedmioty.id_przedmiotu='$id_przedmiotu' and semestr=2 order by data asc;";

            $zapytanie3="SELECT id_ucznia FROM uczniowie where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)='$uczen';";
            $wyslij3=mysqli_query($polaczenie,$zapytanie3);
            while($row3=mysqli_fetch_array($wyslij3)){
                $id_ucznia=$row3[0];
            }

            $zapytanie4="SELECT count(*) from frekwencja where id_przedmiot=$id_przedmiot and id_ucznia=$id_ucznia and typ_ob in('zw','sp','ob') and semestr=2;";


            $wyslij4=mysqli_query($polaczenie,$zapytanie4);
            while($row4=mysqli_fetch_array($wyslij4)){
                $obecnosc=$row4[0];
            }

            $zapytanie5="SELECT count(*) from frekwencja where id_przedmiot=$id_przedmiot and id_ucznia=$id_ucznia and typ_ob in('u','nb') and semestr=2;";

            $wyslij5=mysqli_query($polaczenie,$zapytanie5);
            while($row5=mysqli_fetch_array($wyslij5)){
                $nieobecnosc=$row5[0];
            }
            if($nieobecnosc+$obecnosc==0){
                echo"<br><b>Frekwencja:</b> 0%<br>";
            }else{
                echo "<br><b>Frekwencja:</b> ".round(($obecnosc/($nieobecnosc+$obecnosc)*100),2)."%<br>";
            }

            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
            if ($wyslij1->num_rows>0){
                echo "<b>Średnia ważona ocen: </b>";
    
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join 
                przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie 
                on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on 
                oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on 
                oceny.id_nauczyciela=nauczyciele.id_nauczyciela where 
                concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' 
                and przedmioty.id_przedmiotu='$id_przedmiotu' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=2 and oceny.ocena between 1 and 6;";
                $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
        
                while($row2=mysqli_fetch_array($wyslij2)){
                    if($row2[0]==null){
                        echo "-";
                    }else{
                        echo $row2[0];
                    }
                }

            echo "<table>";
            echo "<tr><th>ocena</th><th>kategoria</th><th>waga</th><th>Komentarz</th><th>data</th><th>dodał</th><th>usuń</th></tr>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo "<tr style='background-color:".$row1['kolor'].";'><td id=".$row1['ocena'].">";
                if($row1['ocena']==1.5){
                    echo "1+";
                }else if ($row1['ocena']==1.75){
                    echo "2-";
                }else if ($row1['ocena']==2.5){
                    echo "2+";
                }else if ($row1['ocena']==2.75){
                    echo "3-";
                }else if ($row1['ocena']==3.5){
                    echo "3+";
                }else if ($row1['ocena']==3.75){
                    echo "4-";
                }else if ($row1['ocena']==4.5){
                    echo "4+";
                }else if ($row1['ocena']==4.75){
                    echo "5-";
                }else if ($row1['ocena']==5.5){
                    echo "5+";
                }else if ($row1['ocena']==5.75){
                    echo "6-";
                }else if ($row1['ocena']==0.5){
                    echo "+";
                }else if ($row1['ocena']==0.25){
                    echo "-";
                }else{
                    echo $row1['ocena'];
                }
                
                echo "</td><td>".$row1['nazwa_kategorii']."</td><td>";
                if($row1['waga']==0 or $row1['ocena']==0.5 or $row1['ocena']==0.25){
                    echo "";
                }else{
                    echo $row1['waga'];
                }
                echo"</td><td>".$row1['komentarz']."</td><td>".$row1['data']."</td><td>".$row1['dodal']."</td>";
                if($login==$row1['login']){
                echo"<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'><input type='submit' name='usun' value='X'></form></td></tr>";
                }else{
                    echo"<td></td></tr>";
                }
            }
            echo "</table>";
    

            }
            else{
                echo "Uczeń nie posiada ocen!";
            }
    
            mysqli_close($polaczenie);

        }
        ?>
        </div>

        <div id="stopka">
            <?php
            if(!empty($_POST['uczen'])){
                echo <<<END
                    <a href="\dziennik_lekcyjny\dodaj_oceny_ucz.php" onclick="window.open('dodaj_oceny_ucz.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=400').focus(); return false">Dodaj ocenę</a>
                END;
        }
        ?>
        </div>
    </div>

        <?php
                if(!empty($_POST['usun'])){
                $id_oceny=$_POST['id_oceny'];


                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie="DELETE FROM oceny WHERE id_oceny='$id_oceny';";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
          
                }
                ?>


</body>
>>>>>>> a2b89c71cd09f84b2babb0669484c902f01892c4
</html>