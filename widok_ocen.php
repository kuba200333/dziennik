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
    <title>Widok ocen</title>
    <link rel="stylesheet" href="styl12.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\moje_przedmioty.php">Powrót moich przedmiotów <br></a>
    </div>

    <div id="naglowek2">
        <h2>Widok ocen</h2>
    </div>
        
    <div id="glowny">
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
                
                    require "connect.php";

                    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                    $uczen=@$_POST['uczen'];
                    $_SESSION['uczen']=$uczen;
                    

                    $zapytanie1="SELECT nazwa_klasy from klasy where id_klasy=".$_SESSION['id_klasy'].";";

                    
                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);
                    while($row1=mysqli_fetch_array($wyslij1)){
                        $klasa=$row1[0];
                        $_SESSION['klasa']=$klasa;
                    }

                    $zapytanie11="SELECT nazwa_przedmiotu from przedmioty where id_przedmiotu=$id_przedmiot;";
                    
                    $wyslij11=mysqli_query($polaczenie,$zapytanie11);
                    while($row11=mysqli_fetch_array($wyslij11)){
                        $przedmiot=$row11[0];
                        $_SESSION['przedmiot']=$przedmiot;
                    }



                echo "<br><b>Przedmiot: </b>". $przedmiot.", ".$klasa. "<br><br>";

                

                echo"<td><form id='form' action='seryjne_oceny.php' method='post'>
                <input type='hidden' name='id_klasy' value='$id_klasy'>
                <input type='hidden' name='id_przedmiot' value='$id_przedmiot'>";
                

                
                echo<<<END
                
                <input class='zielonybutton' type='submit' name='usun' value='Dodaj seryjnie'>
                
                </form>
                </td>
                END;
                echo"<td><form id='form' action='konwenter.php' method='post'>
                <input type='hidden' name='id_klasy' value='$id_klasy'>
                <input type='hidden' name='id_przedmiot' value='$id_przedmiot'>";
                

                
                echo<<<END
                
                <input class='zielonybutton' type='submit' name='usun' value='Zamien plusy/minusy'>
                
                </form>
                </td>
                END;

                $zapytanie30="SELECT concat(na.nazwisko, ' ', na.imie) as nauczyciel from nauczanie n inner JOIN nauczyciele na on n.id_nauczyciel=na.id_nauczyciela where id_klasy=".$_SESSION['id_klasy']." and id_przedmiot=$id_przedmiot";
                $wyslij30=mysqli_query($polaczenie,$zapytanie30);
                if ($wyslij30->num_rows>0){
                while($row30=mysqli_fetch_array($wyslij30)){
                    $nauczajacy=$row30[0];
                }
                }else{
                    $nauczajacy="";
                }

                $zapytanie10="SELECT wirt FROM klasy where id_klasy=$id_klasy;";

                $wyslij10=mysqli_query($polaczenie,$zapytanie10);
                while($row10=mysqli_fetch_array($wyslij10)){
                    $wirt=$row10[0];
                }
                if($wirt==0){
                    $zapytanie10="SELECT concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen, id_ucznia, nr_dziennik  FROM uczniowie where id_klasy=$id_klasy order by nr_dziennik asc, uczen asc;";
                }else{
                    $zapytanie10="SELECT concat(w.nazwisko_ucznia, ' ', w.imie_ucznia) as uczen, w.id_ucznia, u.nr_dziennik  FROM wirtualne_klasy w inner join uczniowie u on w.id_ucznia=u.id_ucznia where w.id_klasy=$id_klasy order by u.nr_dziennik asc, uczen asc;";
                    
                }

            

            $wyslij10=mysqli_query($polaczenie,$zapytanie10);

                echo"<table>";
                echo "<tr><th rowspan='2'>lp.</th><th rowspan='2'>uczeń</th><th rowspan='2'></th><th colspan='4'>Okres 1</th><th colspan='7'>Okres 2</th></tr>";
                echo "<tr><th>Oceny bieżące:</th><th>Śr.I</th><th>(I)</th><th>I</th><th>Oceny bieżące:</th><th>Śr.II</th><th>(II)</th><th>II</th><th>Śr.R</th><th>(R)</th><th>R</th></tr>";
                $x=1;
            while($row10=mysqli_fetch_array($wyslij10)){
                echo "<tr><td>".$row10['nr_dziennik'].".</td><td style='text-align: left;'>".$row10['uczen']."</td>";
                
                echo"<td><form id='forms' action='dodaj_oceny_ucz.php' method='post'>
                <input type='hidden' name='id_klasy' value='$id_klasy'>
                <input type='hidden' name='id_przedmiot' value='$id_przedmiot'>
                <input type='hidden' name='uczen' value='".$row10['uczen']."'>";

                
                echo<<<END
                <input type='submit'  name='usun' value='+'>
                
                </form>
                </td>
                END;
                echo"<td style='text-align: left;'>";
                    $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                    inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                    inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=1 and kategorie_ocen.id_kategorii not in (5,6,7,8) order by data asc;";

                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    if ($wyslij1->num_rows>0){
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."'  >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                }else{
                    echo "Brak ocen";
                }

                    
                    echo"</td><td>";
                    $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=1 and oceny.nie_licz=0 and oceny.ocena between 1 and 6;";
    
                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                    
                    echo"</td><td>";
                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=1 and kategorie_ocen.id_kategorii=5 order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1); 
                if ($wyslij1->num_rows>0){ 
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                
                }
            }else{
                echo "-";
            }
                echo"</td><td>";
                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=1 and kategorie_ocen.id_kategorii=8 order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                if ($wyslij1->num_rows>0){
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                }
            }else{
                    echo "-";
                }
                echo"</td><td style='text-align: left;'>";

                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                    inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                    inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=2 and kategorie_ocen.id_kategorii not in (5,6,7,8) order by data asc;";
    
                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    if ($wyslij1->num_rows>0){
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                }else{
                    echo "Brak ocen";
                }

                echo"</td><td>";
                    $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=2 and oceny.nie_licz=0 and oceny.ocena between 1 and 6;";
                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                
                echo"</td><td>";
                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=2 and kategorie_ocen.id_kategorii=5 order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                if ($wyslij1->num_rows>0){
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                
                }
            }else{
                echo "-";
            }
                echo"</td><td>";
                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=2 and kategorie_ocen.id_kategorii=8 order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                if ($wyslij1->num_rows>0){
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                
                }
            }else{
                echo"-";
            }
                echo"</td><td>";
                    $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and oceny.nie_licz=0 and oceny.ocena between 1 and 6;";
                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo"</td><td>";
                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii=6 order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                if ($wyslij1->num_rows>0){
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                }
            }else{
                echo "-";
            }
                echo"</td><td>";
                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii=7 order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                if ($wyslij1->num_rows>0){
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='ocena' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                }
            }else{
                echo"-";
            }
                echo"</td></tr>";
            }
                /*echo"<tr><td colspan='14'></td>";
                echo"<tr><td colspan='4'></td>";
                echo "<td>";
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where  przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=1 and oceny.nie_licz=0 and oceny.ocena between 1 and 6;";
                echo $zapytanie2;
                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(oceny.ocena),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where  przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii=5 and semestr=1 and oceny.ocena between 1 and 6;";

                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(oceny.ocena),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where  przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii=8 and semestr=1 and oceny.ocena between 1 and 6;";

                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo "</td>";
                echo "<td></td>";
                echo "<td>";
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where  przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=2 and oceny.nie_licz=0 and oceny.ocena between 1 and 6;";

                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(oceny.ocena),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where  przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii=5 and semestr=2 and oceny.ocena between 1 and 6;";

                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(oceny.ocena),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where  przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii=8 and semestr=2 and oceny.ocena between 1 and 6;";

                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where  przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and oceny.nie_licz=0 and oceny.ocena between 1 and 6;";

                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(oceny.ocena),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where  przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii=6 and oceny.ocena between 1 and 6;";

                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(oceny.ocena),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where  przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii=7 and oceny.ocena between 1 and 6;";

                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                echo "</td></tr>";*/
                echo"</table>";
            ?>
    </div>
    
    <div id="stopka">
       
    </div>
</div>

</body>
</html>