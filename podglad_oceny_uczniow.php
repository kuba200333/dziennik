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
    <link rel="stylesheet" href="styl6.css">
</head>
<body onload='kategorie()'>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Oceny uczniów</h2>
        </div>
        
        <div id='wybierz'>
        <form action="" method='post'>
            <?php
                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie11="SELECT skrot_klasy FROM klasy where wirt=0 order by skrot_klasy asc;";
                $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
            
                echo "klasy: <select name='klasy' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row11=mysqli_fetch_array($wyslij11)){
                    echo "<option>".$row11['skrot_klasy']."</option>";
                }
                echo "</select>";
                mysqli_close($polaczenie);

            ?>
                <br>
            <?php
                if(!empty($_POST['klasy'])){
        
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $skrot_klasy=$_POST['klasy'];
            
                
                $zapytanie13="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
                $wyslij13=mysqli_query($polaczenie,$zapytanie13);  
            
            
                while($row13=mysqli_fetch_array($wyslij13)){
                    $id_klasy=$row13['id_klasy'];
                }
            
            
                $zapytanie10="SELECT concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia) as uczen FROM uczniowie where id_klasy=$id_klasy order by concat(nazwisko_ucznia, ' ', imie_ucznia) asc;";
                $wyslij10=mysqli_query($polaczenie,$zapytanie10);  
            
                echo "uczeń: <select name='uczen'>";
                echo "<option value=''</option>";
                while($row10=mysqli_fetch_array($wyslij10)){
                    echo "<option>".$row10[0]."</option>";
                }
                echo "</select><br>";
            
                    $zapytanie="SELECT DISTINCT p.nazwa_przedmiotu as przedmiot from oceny o inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu inner join uczniowie u on u.id_ucznia=o.id_ucznia inner join klasy k on k.id_klasy=u.id_klasy where k.skrot_klasy='$skrot_klasy' and p.nazwa_przedmiotu !='zachowanie';";
                    $wyslij=mysqli_query($polaczenie,$zapytanie);
            
                    echo "przedmiot: <select name='przedmiot' onchange='this.form.submit()'>";
                    echo "<option value=''</option>";
                    while($row=mysqli_fetch_array($wyslij)){
                        echo "<option>".$row[0]."</option>";
                    }
                    echo "</select>";


              

                mysqli_close($polaczenie);
                
                }
                if((!empty($_POST['przedmiot']))){
                    $uczen=@$_POST['uczen'];
                    $przedmiot=@$_POST['przedmiot'];
                    echo "<br><b>Przedmiot: </b>". $przedmiot. "<br>";
                    echo "<b>Uczeń: </b>". $uczen;
                }
            ?>
        
            </form>
            <br>
          
        </div>
        <div id="glowny1">

        <?php
        if(!empty($_POST['przedmiot'])){
            $uczen=@$_POST['uczen'];
            $przedmiot=@$_POST['przedmiot'];
            $login=$_SESSION['login'];
 
            echo "<h3>Semestr 1</h3>";

    

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, oceny.waga as waga, kategorie_ocen.kolor as kolor  from oceny 
            inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
            inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' and przedmioty.nazwa_przedmiotu='$przedmiot' and semestr=1 order by data asc;";
    
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
            if ($wyslij1->num_rows>0){
                echo "<b>Śródroczna średnia ważona ocen: </b>";
    
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join 
                przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie 
                on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on 
                oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on 
                oceny.id_nauczyciela=nauczyciele.id_nauczyciela where 
                concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' 
                and przedmioty.nazwa_przedmiotu='$przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=1 and oceny.ocena between 1 and 6;";
                $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
        
                while($row2=mysqli_fetch_array($wyslij2)){
                    echo $row2[0];
                }
            echo "<br><table>";
            echo "<tr><th>ocena</th><th>kategoria</th><th>waga</th><th>Komentarz</th><th>data</th><th>dodał</th>";
            if($_SESSION['admin'] ==1){
                echo "<th>usuń</th>";
            }
            echo"</tr>";
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
                }else if ($row1['ocena']==1.00){
                    echo "1";
                }else if ($row1['ocena']==2.00){
                    echo "2";
                }else if ($row1['ocena']==3.00){
                    echo "3";
                }else if ($row1['ocena']==4.00){
                    echo "4";
                }else if ($row1['ocena']==5.00){
                    echo "5";
                }else if ($row1['ocena']==6.00){
                    echo "6";
                }else{
                    echo (int)$row1['ocena'];
                }
                
                echo "</td><td>".$row1['nazwa_kategorii']."</td><td>";
                if($row1['waga']==0 or $row1['ocena']==0.5 or $row1['ocena']==0.25){
                    echo "";
                }else{
                    echo $row1['waga'];
                }
                echo"</td><td>".$row1['komentarz']."</td><td>".$row1['data']."</td><td>".$row1['dodal']."</td>";
                if($_SESSION['admin'] ==1){
                echo"<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'><input type='submit' name='usun' value='X'></form></td></tr>";
                }else{
                    echo"</tr>";
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
        if(!empty($_POST['przedmiot'])){
            $uczen=@$_POST['uczen'];
            $przedmiot=@$_POST['przedmiot'];
            $login=$_SESSION['login'];
        
            echo "<h3>Semestr 2</h3>";

    

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, oceny.waga as waga, kategorie_ocen.kolor as kolor  from oceny 
            inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
            inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' and przedmioty.nazwa_przedmiotu='$przedmiot' and semestr=2 order by data asc;";
    
    
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
            if ($wyslij1->num_rows>0){
                echo "<b>Roczna średnia ważona ocen: </b>";
    
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia, oceny.waga as waga from oceny inner join 
                przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie 
                on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on 
                oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on 
                oceny.id_nauczyciela=nauczyciele.id_nauczyciela where 
                concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' 
                and przedmioty.nazwa_przedmiotu='$przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and oceny.ocena between 1 and 6;";
                $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
        
                while($row2=mysqli_fetch_array($wyslij2)){
                    echo $row2[0];
                }
            echo "<table>";
            echo "<tr><th>ocena</th><th>kategoria</th><th>waga</th><th>Komentarz</th><th>data</th><th>dodał</th>";
            if($_SESSION['login']=='admin'){
                echo "<th>usuń</th>";
            }
            echo"</tr>";
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
                }else if ($row1['ocena']==1.00){
                    echo "1";
                }else if ($row1['ocena']==2.00){
                    echo "2";
                }else if ($row1['ocena']==3.00){
                    echo "3";
                }else if ($row1['ocena']==4.00){
                    echo "4";
                }else if ($row1['ocena']==5.00){
                    echo "5";
                }else if ($row1['ocena']==6.00){
                    echo "6";
                }else{
                    echo (int)$row1['ocena'];
                }
                echo "</td><td>".$row1['nazwa_kategorii']."</td><td>";
                if($row1['waga']==0 or $row1['ocena']==0.5 or $row1['ocena']==0.25){
                    echo "";
                }else{
                    echo $row1['waga'];
                }
                echo"</td><td>".$row1['komentarz']."</td><td>".$row1['data']."</td><td>".$row1['dodal']."</td>";
                if($login=='admin'){
                echo"<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'><input type='submit' name='usun' value='X'></form></td></tr>";
                }else{
                    echo"</tr>";
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
        <a href="\dziennik_lekcyjny\dodaj_oceny.php" onclick="window.open('dodaj_oceny.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=400').focus(); return false">Dodaj ocenę</a>
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
</html>