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
    <title>Dodawanie seryjne ocen</title>
    <link rel="stylesheet" href="styl9.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\widok_ocen.php">Powrót do widoku ocen <br></a>
    </div>

    <div id="naglowek2">
        <h2>Dodawanie seryjnie ocen</h2>
        
    </div>
        
    <div id='glowny'>
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

            
            $zapytanie30="SELECT concat(na.nazwisko, ' ', na.imie) as nauczyciel from nauczanie n inner JOIN nauczyciele na on n.id_nauczyciel=na.id_nauczyciela where id_klasy=".$_SESSION['id_klasy']." and id_przedmiot=$id_przedmiot";
                $wyslij30=mysqli_query($polaczenie,$zapytanie30);
                if ($wyslij30->num_rows>0){
                while($row30=mysqli_fetch_array($wyslij30)){
                    $nauczajacy=$row30[0];
                }
                }else{
                    $nauczajacy="";
                }

        $zapytanie1="SELECT nazwa_klasy from klasy where id_klasy=$id_klasy;";
        $wyslij1=mysqli_query($polaczenie,$zapytanie1);
        while($row1=mysqli_fetch_array($wyslij1)){
            $nazwa_klasy=$row1[0];
        }
        $zapytanie11="SELECT nazwa_przedmiotu from przedmioty where id_przedmiotu=$id_przedmiot;";

        $wyslij11=mysqli_query($polaczenie,$zapytanie11);
        while($row11=mysqli_fetch_array($wyslij11)){
            $nazwa_przedmiotu=$row11[0];
        }

        echo"
        
        <table id='srodek'>";
        
        
        
        
        echo"<tr><td class='1'>klasa:</td> <td class='2'>".$nazwa_klasy."</td></tr>";
        echo "<tr><td class='1'>przedmiot:</td> <td class='2'>".$nazwa_przedmiotu."</td></tr>";
        $d=mktime();
        $date=date("Y-m-d", $d);
        $data=date("Y-m-d", $d);

        $zapytanie20="SELECT id from semestry where '$data' between od and do;";
        $wyslij20=mysqli_query($polaczenie,$zapytanie20);
        while($row20=mysqli_fetch_array($wyslij20)){
            $semestr=$row20[0];
        }
        echo"<tr><td class='1'>losowe oceny:</td><td class='2'>";
        echo'<button onclick="losujOceny()" class="zielonybutton">Losuj oceny</button>';
        echo"</td></tr>";

        echo"<form action='' method='post'>";
        echo "<tr><td class='1'>Wybierz datę: </td><td class='2'><input type='date' value='$date' name='data' required></td></tr>";
        echo "<option value=''</option>";

        $zapytanie5="SELECT nazwa_kategorii FROM `kategorie_ocen` where id_kategorii not in (9,10) order by nazwa_kategorii asc;";
            
        $wyslij5=mysqli_query($polaczenie,$zapytanie5);
        
        echo "<tr><td class='1'>kategoria:</td> <td class='2'><select name='kategoria'  id='info'  required>";
        echo "<option value=''</option>";
        while($row5=mysqli_fetch_array($wyslij5)){
            echo "<option>".$row5['nazwa_kategorii']."</option>";
        }
        echo "</select></td></tr>";
        echo "<tr><td class='1'>komentarz: </td><td class='2'><input type='text' id='koment' name='komentarz' onchange='komentarz_ser()'></td></tr>";

        echo"</table><br>";
        
        echo "<table>
        <tr><th>lp.</th><th>Uczeń</th><th>Oceny I</th><th>Śr.I</th><th>Oceny II</th><th>Śr.II</th><th>Śr.R</th><th>Dodaj ocenę</th><th>Komentarz</th></tr>";
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $id_klasy=$_POST['id_klasy'];
        $id_przedmiot=$_POST['id_przedmiot'];

        $zapytanie="SELECT u.id_ucznia, nr_dziennik, concat(u.nazwisko_ucznia, ' ', u.imie_ucznia) as duczen FROM uczniowie u where id_klasy=$id_klasy UNION SELECT w.id_ucznia, nr_dziennik, concat(w.nazwisko_ucznia, ' ', w.imie_ucznia) as duczen FROM wirtualne_klasy w inner join uczniowie u on u.id_ucznia=w.id_ucznia where w.id_klasy=$id_klasy ORDER BY nr_dziennik ASC;";

        $wyslij=mysqli_query($polaczenie,$zapytanie);
        $x=1;
        while($row=mysqli_fetch_array($wyslij)){
            echo '<tr id="'.$row['id_ucznia'].'"><td>'.$x++.'.</td><td style="text-align:left;">'.$row['duczen']."</td><td id='ocenka'>";
            
            $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row[2]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=1 and kategorie_ocen.id_kategorii not in (5,6,7,8)order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                if ($wyslij1->num_rows>0){
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."'  >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                
                }
            }else{
                echo "Brak ocen &nbsp";
            }
            echo"</td><td id='srodek'>";
            $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row[2]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=1 and oceny.nie_licz=0 and oceny.ocena between 1 and 6;";
    
            $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
            while($row2=mysqli_fetch_array($wyslij2)){
                if($row2[0]==''){
                    echo"&nbsp - &nbsp";
                }else{
                    echo "&nbsp".$row2[0]."&nbsp";
                }
            }
            echo"</td><td id='ocenka'>";
            $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
            inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
            inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row[2]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=2 and kategorie_ocen.id_kategorii not in (5,6,7,8)order by data asc;";

            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
            if ($wyslij1->num_rows>0){
            while($row1=mysqli_fetch_array($wyslij1)){
                if($row1['ocena']==1.5){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."'  >1+ </a></span>";
                }else if ($row1['ocena']==1.75){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                }else if ($row1['ocena']==2.5){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                }else if ($row1['ocena']==2.75){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                }else if ($row1['ocena']==3.5){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                }else if ($row1['ocena']==3.75){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                }else if ($row1['ocena']==4.5){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                }else if ($row1['ocena']==4.75){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                }else if ($row1['ocena']==5.5){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                }else if ($row1['ocena']==5.75){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                }else if ($row1['ocena']==0.5){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                }else if ($row1['ocena']==0.25){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                }else if ($row1['ocena']==0.01){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                }else if ($row1['ocena']==0.02){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                }else if ($row1['ocena']==1.00){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                }else if ($row1['ocena']==2.00){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                }else if ($row1['ocena']==3.00){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                }else if ($row1['ocena']==4.00){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                }else if ($row1['ocena']==5.00){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                }else if ($row1['ocena']==6.00){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                }else if ($row1['ocena']==0.03){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                }else if ($row1['ocena']==0.04){
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                }else{
                    echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                }
            
            }
        }else{
            echo "Brak ocen &nbsp";
        }
            echo"</td><td id='srodek'>";
            $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row[2]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=2 and oceny.nie_licz=0 and oceny.ocena between 1 and 6;";
    
            $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
            while($row2=mysqli_fetch_array($wyslij2)){
                if($row2[0]==''){
                    echo"&nbsp - &nbsp";
                }else{
                    echo "&nbsp".$row2[0]."&nbsp";
                }
            }
            echo"</td><td id='srodek'>";
            $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row[2]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and oceny.nie_licz=0 and oceny.ocena between 1 and 6;";
            $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
            while($row2=mysqli_fetch_array($wyslij2)){
                if($row2[0]==''){
                    echo"&nbsp - &nbsp";
                }else{
                    echo "&nbsp".$row2[0]."&nbsp";
                }
            }
            echo"</td><td id='srodek'>

            <input list='oceny' id='ocena' class='ocena' tabindex='$x' name='ocena[".$row['id_ucznia']."]'>
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
                <option>5</option>
                <option>5+</option>
                <option>6-</option>
                <option>6</option>
                <option>+</option>
                <option>-</option>
                <option>np</option>
                <option>nu</option>
            </datalist><input type='hidden' name='id_przedmiot' value='".$id_przedmiot."'></td>";
            echo "<td><input type=text id='kom_ser' class='kom_ser' name='kom_ser[".$row[0]."]'></td>";
            
            echo "</tr>";
        }
        
        echo "<tr><td colspan='9' style='text-align: center;'>";
        

        echo '<input type="submit" name="submit" value="Dodaj oceny"></td></tr></table></form>';
        
   
        
        if(isset($_POST['submit'])){
            $tab=$_POST['ocena'];
            $tab_kom=$_POST['kom_ser'];

            $id_przedmiot=$_POST['id_przedmiot'];
            $kategoria=$_POST['kategoria'];

            $tab=$_POST['ocena'];
            $data=$_POST['data'];
            
            $login=$_SESSION['login'];

            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie="SELECT* FROM kategorie_ocen where nazwa_kategorii='$kategoria';";
            $wyslij=mysqli_query($polaczenie,$zapytanie);
            while($row=mysqli_fetch_array($wyslij)){
                $id_kategorii=$row[0];
            }
            $zapytanie20="SELECT id from semestry where '$data' between od and do;";
            $wyslij20=mysqli_query($polaczenie,$zapytanie20);
            while($row20=mysqli_fetch_array($wyslij20)){
                $semestr=$row20[0];
            }

            $zapytanie22="SELECT waga from kategorie_ocen where nazwa_kategorii='$kategoria';";
            $wyslij22=mysqli_query($polaczenie,$zapytanie22);
            while($row22=mysqli_fetch_array($wyslij22)){
                $waga=$row22[0];
            }
      
            $zapytanie1="SELECT id_nauczyciela from nauczyciele where login='$login';";
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);
            while($row1=mysqli_fetch_array($wyslij1)){
                $id_nauczyciela=$row1[0];
            }

            foreach($tab as $keys=> $ocena){
                $komentarz = mysqli_real_escape_string($polaczenie,$tab_kom[$keys]);
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
                }else if($ocena=="nk"){
                    $ocena=0.01;
                }else if($ocena=="zw"){
                    $ocena=0.02;
                }else if($ocena=="np"){
                    $ocena=0.03;
                }else if($ocena=="nu"){
                    $ocena=0.04;
                }
                if($ocena<1 or $ocena>6){
                    $nie_licz=1;
                }else{
                    $nie_licz=0;
                }
            mysqli_query($polaczenie, "INSERT INTO oceny(`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`, nie_licz) VALUES (null, $id_przedmiot, $id_kategorii, $semestr, $ocena, $waga, '$data', $id_nauczyciela, $keys, '$komentarz', $nie_licz);");
            //echo"INSERT INTO oceny(`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`, nie_licz) VALUES (null, $id_przedmiot, $id_kategorii, $semestr, $ocena, $waga, '$data', $id_nauczyciela, $keys, '$komentarz', $nie_licz);";
            
            }
            /*js="<script>window.close()</script>";
            echo $js;*/
            header("Location: http://localhost/dziennik_lekcyjny/widok_ocen.php");
            exit;
        }
    ?>

   </div>
    <div id="stopka">
       
    </div>
</div>

    <script>
        function komentarz_ser(){
            var komentarz= document.getElementById('koment').value;
            let tablica = document.querySelectorAll(".kom_ser");
                                for (n in tablica){
                                    if (tablica[n].className == "kom_ser") {
                                        tablica[n].value = komentarz;
                                    }
                                
                    }
        }
        function losujOceny() {
        var oceny = [
            '+', '-', '2-', '2', '2+', '3-', '3', '3+', '4-', '4', '4+', '5-', '5', '5+', '6-', '6', '4-', '4', '4+', '5-', '5', '5+', '6-', '6', '4-', '4', '4+', '5-', '5', '5+', '6-', '6'
        ];

        var polaOcen = document.getElementsByClassName('ocena');
        
        for (var i = 0; i < polaOcen.length; i++) {
            var randomIndex = Math.floor(Math.random() * oceny.length);
            var losowaOcena = oceny[randomIndex];
            
            polaOcen[i].value = losowaOcena;
        }
    }
    </script>
</body>
</html>