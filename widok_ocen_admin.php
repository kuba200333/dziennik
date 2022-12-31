<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}
if ($_SESSION['admin'] !=1){
    header("Location: dziennik.php");
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widok ocen</title>
    <link rel="stylesheet" href="styl6.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>
    </div>

    <div id="naglowek2">
        <h2>Widok ocen</h2>
    </div>
    <div id='wybierz'>
    <form action="" method='post'>
            <?php
                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie11="SELECT skrot_klasy FROM klasy order by skrot_klasy asc;";
                $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
            
                echo "Klasa: <select name='klasy' onchange='this.form.submit()'>";
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
                $_SESSION['klasy']=$_POST['klasy'];
                
                $skrot_klasy=$_POST['klasy'];
            
                
                $zapytanie13="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
                $wyslij13=mysqli_query($polaczenie,$zapytanie13);  
            
            
                while($row13=mysqli_fetch_array($wyslij13)){
                    $id_klasy=$row13['id_klasy'];
                }
            
            
                $zapytanie10="SELECT DISTINCT p.nazwa_przedmiotu as przedmiot from nauczanie n inner join przedmioty p on n.id_przedmiot=p.id_przedmiotu inner join klasy k on n.id_klasy=k.id_klasy where k.skrot_klasy='$skrot_klasy' order by przedmiot asc;";
                $wyslij10=mysqli_query($polaczenie,$zapytanie10);  
            
                echo "przedmiot: <select name='przedmiot' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row10=mysqli_fetch_array($wyslij10)){
                    echo "<option>".$row10[0]."</option>";
                }
                echo "</select><br>";
            
                mysqli_close($polaczenie);
                
                }
                if(isset($_POST['przedmiot'])){
                echo "<br><b>".$_POST['przedmiot']."</b>, ".$_SESSION['klasy']."<br><br>";
                }
            ?>
        
            </form>
    </div>
    <div id="glowny">
        <?php
            if(isset($_POST['przedmiot'])){
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $przedmiot=$_POST['przedmiot'];
                $klasy=$_SESSION['klasy'];
                
                $zapytanie="SELECT id_przedmiotu from przedmioty where nazwa_przedmiotu='$przedmiot';";

                $wyslij=mysqli_query($polaczenie,$zapytanie);  
                while($row=mysqli_fetch_array($wyslij)){
                    $id_przedmiot=$row[0];
                }
                
                $zapytanie="SELECT id_klasy from klasy where skrot_klasy='$klasy';";
                $wyslij=mysqli_query($polaczenie,$zapytanie);  
                while($row=mysqli_fetch_array($wyslij)){
                    $id_klasy=$row[0];
                }
                echo "<br><b>Przedmiot: </b>". $przedmiot.", ".$klasy. "<br><br>";

                

                echo"<td><form id='form' action='seryjne_oceny_adm.php' method='post'>
                <input type='hidden' name='id_klasy' value='$id_klasy'>
                <input type='hidden' name='id_przedmiot' value='$id_przedmiot'>";
                

                
                echo<<<END
                
                <input class='zielonybutton' type='submit' name='usun' value='Dodaj seryjnie'>
                
                </form>
                </td>
                END;

                $zapytanie30="SELECT concat(na.nazwisko, ' ', na.imie) as nauczyciel from nauczanie n inner JOIN nauczyciele na on n.id_nauczyciel=na.id_nauczyciela where id_klasy=".$id_klasy." and id_przedmiot=$id_przedmiot";
                $wyslij30=mysqli_query($polaczenie,$zapytanie30);
                if ($wyslij30->num_rows>0){
                while($row30=mysqli_fetch_array($wyslij30)){
                    $nauczajacy=$row30[0];
                }
                }else{
                    $nauczajacy="";
                }

            $zapytanie10="SELECT concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen, id_ucznia  FROM uczniowie where id_klasy=$id_klasy UNION SELECT concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen, id_ucznia  FROM wirtualne_klasy where id_klasy=$id_klasy order by uczen asc;";

            $wyslij10=mysqli_query($polaczenie,$zapytanie10);

                echo"<table>";
                echo "<tr><th rowspan='2'>lp.</th><th rowspan='2'>uczeń</th><th rowspan='2'></th><th colspan='4'>Okres 1</th><th colspan='7'>Okres 2</th></tr>";
                echo "<tr><th>Oceny bieżące:</th><th>Śr.I</th><th>(I)</th><th>I</th><th>Oceny bieżące:</th><th>Śr.II</th><th>(II)</th><th>II</th><th>Śr.R</th><th>(R)</th><th>R</th></tr>";
                $x=1;
            while($row10=mysqli_fetch_array($wyslij10)){
                echo "<tr><td>".$x++.".</td><td style='text-align: left;'>".$row10['uczen']."</td>";
                
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
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }

                    
                    echo"</td><td>";
                    $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu 
                    inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join 
                    nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and 
                    przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and semestr=1 and nie_licz=0 and oceny.ocena between 1 and 6;";
    
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
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                
                }
                echo"</td><td>";
                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=1 and kategorie_ocen.id_kategorii=8 order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                }
                echo"</td><td style='text-align: left;'>";

                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                    inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                    inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=2 and kategorie_ocen.id_kategorii not in (5,6,7,8) order by data asc;";
    
                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }

                echo"</td><td>";
                    $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and nie_licz=0 and semestr=2 and oceny.ocena between 1 and 6;";
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
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                
                }
                echo"</td><td>";
                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and semestr=2 and kategorie_ocen.id_kategorii=8 order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                
                }
                echo"</td><td>";
                    $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii not in (5,6,7,8) and nie_licz=0 and oceny.ocena between 1 and 6;";
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
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                }
                echo"</td><td>";
                $zapytanie1="SELECT oceny.id_oceny as id_oceny, oceny.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny.komentarz as komentarz, oceny.data as data, nauczyciele.login, oceny.waga as waga, kategorie_ocen.kolor as kolor, nie_licz from oceny 
                inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                inner join nauczyciele on oceny.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$row10[0]' and przedmioty.id_przedmiotu='$id_przedmiot' and kategorie_ocen.id_kategorii=7 order by data asc;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                    }else if ($row1['ocena']==1.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                    }else if ($row1['ocena']==2.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                    }else if ($row1['ocena']==2.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                    }else if ($row1['ocena']==3.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                    }else if ($row1['ocena']==3.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                    }else if ($row1['ocena']==4.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                    }else if ($row1['ocena']==4.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                    }else if ($row1['ocena']==5.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                    }else if ($row1['ocena']==5.75){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                    }else if ($row1['ocena']==0.5){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                    }else if ($row1['ocena']==0.25){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                    }else if ($row1['ocena']==0.01){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                    }else if ($row1['ocena']==0.02){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                    }else if ($row1['ocena']==1.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                    }else if ($row1['ocena']==2.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                    }else if ($row1['ocena']==3.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                    }else if ($row1['ocena']==4.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                    }else if ($row1['ocena']==5.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                    }else if ($row1['ocena']==6.00){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                    }else if ($row1['ocena']==0.03){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                    }else if ($row1['ocena']==0.04){
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                    }else{
                        echo "<span class='box' style='background-color:".$row1['kolor'].";'><form id='".$row1['id_oceny']."'action='edycja_oceny.php' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_oceny']."`).submit();' title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: $nauczajacy &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                    }
                }
                echo"</td></tr>";
            }
                
                echo"</table>";
            }
        ?>
    </div>
    
    <div id="stopka">
       
    </div>
</div>

</body>
</html>