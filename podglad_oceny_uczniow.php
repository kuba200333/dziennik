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
<body>
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
            
            
                $zapytanie10="SELECT concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia) as uczen FROM uczniowie where id_klasy=$id_klasy order by concat(nazwisko_ucznia, ' ', imie_ucznia) asc;";
                $wyslij10=mysqli_query($polaczenie,$zapytanie10);  
            
                echo "Uczeń: <select name='uczen' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row10=mysqli_fetch_array($wyslij10)){
                    echo "<option>".$row10[0]."</option>";
                }
                echo "</select><br>";
            
                mysqli_close($polaczenie);
                
                }
                if(isset($_POST['uczen'])){
                echo "<br><b>".$_POST['uczen']."</b>, ".$_SESSION['klasy']."<br><br>";
                }
            ?>
        
            </form>
            <br>
          
        </div>
        <div id="glowny">
        <?php
            if(isset($_POST['uczen'])){
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $uczen=$_POST['uczen'];
                $klasy=$_SESSION['klasy'];
                
                $zapytanie="SELECT id_ucznia from uczniowie where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)='$uczen';";
                $wyslij=mysqli_query($polaczenie,$zapytanie);  
                while($row=mysqli_fetch_array($wyslij)){
                    $id_ucznia=$row[0];
                }
                
                $zapytanie="SELECT id_klasy from klasy where skrot_klasy='$klasy';";
                $wyslij=mysqli_query($polaczenie,$zapytanie);  
                while($row=mysqli_fetch_array($wyslij)){
                    $id_klasy=$row[0];
                }
                
                
                $zapytanie="SELECT DISTINCT p.nazwa_przedmiotu as przedmiot from oceny o inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu inner join uczniowie u on u.id_ucznia=o.id_ucznia inner join klasy k on k.id_klasy=u.id_klasy where k.skrot_klasy='$klasy' and p.nazwa_przedmiotu !='zachowanie' order by przedmiot asc;";
                $wyslij=mysqli_query($polaczenie,$zapytanie);  
                
                echo "<table id='tabela1'>";
                echo "<tr><th rowspan='2'>lp.</th><th rowspan='2'>przedmiot</th><th colspan='4'>Okres 1</th><th colspan='7'>Okres 2</th></tr>";
                echo "<tr><th>Oceny bieżące:</th><th>Śr.I</th><th>(I)</th><th>I</th><th>Oceny bieżące:</th><th>Śr.II</th><th>(II)</th><th>II</th><th>Śr.R</th><th>(R)</th><th>R</th></tr>";
                $x=1;
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<tr><td>".$x++.".</td><td style='text-align: left;'>".$row[0]."</td>";
                    echo"<td style='text-align: left;'>";
                    $zapytanie1="SELECT o.id_oceny as id_oceny, o.ocena as ocena, ko.skrót_kategorii as kategoria, ko.nazwa_kategorii as nazwa_kategorii,concat(na.nazwisko, ' ', na.imie) as dodal, o.komentarz as komentarz, o.data as data, 
                    na.login, o.waga as waga, ko.kolor as kolor, nie_licz FROM oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join klasy k on u.id_klasy=k.id_klasy inner JOIN 
                    przedmioty p on o.id_przedmiotu=p.id_przedmiotu INNER JOIN kategorie_ocen ko on o.id_kategorii=ko.id_kategorii inner JOIN nauczyciele na on o.id_nauczyciela=na.id_nauczyciela 
                    where o.id_ucznia=$id_ucznia and p.nazwa_przedmiotu='$row[0]' and k.id_klasy=$id_klasy and ko.id_kategorii not in (5,6,7,8) and o.semestr=1 order by data asc;";

                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                    echo "</td><td>";
                    $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia 
                    inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                    where oceny.id_ucznia=$id_ucznia and przedmioty.nazwa_przedmiotu='$row[0]' and nie_licz=0 and semestr=1 and kategorie_ocen.id_kategorii not in (5,6,7,8);";
     
                    $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                    while($row2=mysqli_fetch_array($wyslij2)){
                        if($row2[0]==''){
                            echo"-";
                        }else{
                            echo $row2[0];
                        }
                    }
                    echo"</td><td>";
                    $zapytanie1="SELECT o.id_oceny as id_oceny, o.ocena as ocena, ko.skrót_kategorii as kategoria, ko.nazwa_kategorii as nazwa_kategorii,concat(na.nazwisko, ' ', na.imie) as dodal, o.komentarz as komentarz, o.data as data, 
                    na.login, o.waga as waga, ko.kolor as kolor, nie_licz FROM oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join klasy k on u.id_klasy=k.id_klasy inner JOIN 
                    przedmioty p on o.id_przedmiotu=p.id_przedmiotu INNER JOIN kategorie_ocen ko on o.id_kategorii=ko.id_kategorii inner JOIN nauczyciele na on o.id_nauczyciela=na.id_nauczyciela 
                    where o.id_ucznia=$id_ucznia and p.nazwa_przedmiotu='$row[0]' and k.id_klasy=$id_klasy and ko.id_kategorii=5 and semestr=1 order by data asc;";

                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                    echo"</td><td>";
                    $zapytanie1="SELECT o.id_oceny as id_oceny, o.ocena as ocena, ko.skrót_kategorii as kategoria, ko.nazwa_kategorii as nazwa_kategorii,concat(na.nazwisko, ' ', na.imie) as dodal, o.komentarz as komentarz, o.data as data, 
                    na.login, o.waga as waga, ko.kolor as kolor, nie_licz FROM oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join klasy k on u.id_klasy=k.id_klasy inner JOIN 
                    przedmioty p on o.id_przedmiotu=p.id_przedmiotu INNER JOIN kategorie_ocen ko on o.id_kategorii=ko.id_kategorii inner JOIN nauczyciele na on o.id_nauczyciela=na.id_nauczyciela 
                    where o.id_ucznia=$id_ucznia and p.nazwa_przedmiotu='$row[0]' and k.id_klasy=$id_klasy and ko.id_kategorii=8 and semestr=1 order by data asc;";

                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                    echo"</td><td style='text-align: left;'>";
                    $zapytanie1="SELECT o.id_oceny as id_oceny, o.ocena as ocena, ko.skrót_kategorii as kategoria, ko.nazwa_kategorii as nazwa_kategorii,concat(na.nazwisko, ' ', na.imie) as dodal, o.komentarz as komentarz, o.data as data, 
                    na.login, o.waga as waga, ko.kolor as kolor, nie_licz FROM oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join klasy k on u.id_klasy=k.id_klasy inner JOIN 
                    przedmioty p on o.id_przedmiotu=p.id_przedmiotu INNER JOIN kategorie_ocen ko on o.id_kategorii=ko.id_kategorii inner JOIN nauczyciele na on o.id_nauczyciela=na.id_nauczyciela 
                    where o.id_ucznia=$id_ucznia and p.nazwa_przedmiotu='$row[0]' and k.id_klasy=$id_klasy and ko.id_kategorii not in (5,6,7,8) and o.semestr=2 order by data asc;";

                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel:".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Waga: ".$row1['waga']."&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                    echo"</td><td>";
                        $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia 
                        inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                        where oceny.id_ucznia=$id_ucznia and przedmioty.nazwa_przedmiotu='$row[0]' and nie_licz=0 and semestr=2 and kategorie_ocen.id_kategorii not in (5,6,7,8);";
        
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo"-";
                            }else{
                                echo $row2[0];
                            }
                        }
                    echo"</td><td>";
                    $zapytanie1="SELECT o.id_oceny as id_oceny, o.ocena as ocena, ko.skrót_kategorii as kategoria, ko.nazwa_kategorii as nazwa_kategorii,concat(na.nazwisko, ' ', na.imie) as dodal, o.komentarz as komentarz, o.data as data, 
                    na.login, o.waga as waga, ko.kolor as kolor, nie_licz FROM oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join klasy k on u.id_klasy=k.id_klasy inner JOIN 
                    przedmioty p on o.id_przedmiotu=p.id_przedmiotu INNER JOIN kategorie_ocen ko on o.id_kategorii=ko.id_kategorii inner JOIN nauczyciele na on o.id_nauczyciela=na.id_nauczyciela 
                    where o.id_ucznia=$id_ucznia and p.nazwa_przedmiotu='$row[0]' and k.id_klasy=$id_klasy and ko.id_kategorii=5 and semestr=2 and nie_licz=0 order by data asc;";

                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                    echo"</td><td>";
                    $zapytanie1="SELECT o.id_oceny as id_oceny, o.ocena as ocena, ko.skrót_kategorii as kategoria, ko.nazwa_kategorii as nazwa_kategorii,concat(na.nazwisko, ' ', na.imie) as dodal, o.komentarz as komentarz, o.data as data, 
                    na.login, o.waga as waga, ko.kolor as kolor, nie_licz FROM oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join klasy k on u.id_klasy=k.id_klasy inner JOIN 
                    przedmioty p on o.id_przedmiotu=p.id_przedmiotu INNER JOIN kategorie_ocen ko on o.id_kategorii=ko.id_kategorii inner JOIN nauczyciele na on o.id_nauczyciela=na.id_nauczyciela 
                    where o.id_ucznia=$id_ucznia and p.nazwa_przedmiotu='$row[0]' and k.id_klasy=$id_klasy and ko.id_kategorii=8 and o.semestr=2 order by data asc;";

                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                    echo"</td><td>";
                    $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia 
                        inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                        where oceny.id_ucznia=$id_ucznia and przedmioty.nazwa_przedmiotu='$row[0]' and nie_licz=0 and kategorie_ocen.id_kategorii not in (5,6,7,8);";
        
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo"-";
                            }else{
                                echo $row2[0];
                            }
                        }
                    echo"</td><td>";
                    $zapytanie1="SELECT o.id_oceny as id_oceny, o.ocena as ocena, ko.skrót_kategorii as kategoria, ko.nazwa_kategorii as nazwa_kategorii,concat(na.nazwisko, ' ', na.imie) as dodal, o.komentarz as komentarz, o.data as data, 
                    na.login, o.waga as waga, ko.kolor as kolor, nie_licz FROM oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join klasy k on u.id_klasy=k.id_klasy inner JOIN 
                    przedmioty p on o.id_przedmiotu=p.id_przedmiotu INNER JOIN kategorie_ocen ko on o.id_kategorii=ko.id_kategorii inner JOIN nauczyciele na on o.id_nauczyciela=na.id_nauczyciela 
                    where o.id_ucznia=$id_ucznia and p.nazwa_przedmiotu='$row[0]' and k.id_klasy=$id_klasy and ko.id_kategorii=6 order by data asc;";

                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                    echo"</td><td>";
                    $zapytanie1="SELECT o.id_oceny as id_oceny, o.ocena as ocena, ko.skrót_kategorii as kategoria, ko.nazwa_kategorii as nazwa_kategorii,concat(na.nazwisko, ' ', na.imie) as dodal, o.komentarz as komentarz, o.data as data, 
                    na.login, o.waga as waga, ko.kolor as kolor, nie_licz FROM oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join klasy k on u.id_klasy=k.id_klasy inner JOIN 
                    przedmioty p on o.id_przedmiotu=p.id_przedmiotu INNER JOIN kategorie_ocen ko on o.id_kategorii=ko.id_kategorii inner JOIN nauczyciele na on o.id_nauczyciela=na.id_nauczyciela 
                    where o.id_ucznia=$id_ucznia and p.nazwa_przedmiotu='$row[0]' and k.id_klasy=$id_klasy and ko.id_kategorii=7 order by data asc;";

                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                    while($row1=mysqli_fetch_array($wyslij1)){
                        if($row1['ocena']==1.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1+ </a></span>";
                        }else if ($row1['ocena']==1.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2- </a></span>";
                        }else if ($row1['ocena']==2.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2+ </a></span>";
                        }else if ($row1['ocena']==2.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3- </a></span>";
                        }else if ($row1['ocena']==3.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3+ </a></span>";
                        }else if ($row1['ocena']==3.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4- </a></span>";
                        }else if ($row1['ocena']==4.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4+ </a></span>";
                        }else if ($row1['ocena']==4.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5- </a></span>";
                        }else if ($row1['ocena']==5.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5+ </a></span>";
                        }else if ($row1['ocena']==5.75){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6- </a></span>";
                        }else if ($row1['ocena']==0.5){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >+ </a></span>";
                        }else if ($row1['ocena']==0.25){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >- </a></span>";
                        }else if ($row1['ocena']==0.01){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieklasyfikowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nk </a></span>";
                        }else if ($row1['ocena']==0.02){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: zwolniony&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >zw </a></span>";
                        }else if ($row1['ocena']==1.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >1 </a></span>";
                        }else if ($row1['ocena']==2.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >2 </a></span>";
                        }else if ($row1['ocena']==3.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >3 </a></span>";
                        }else if ($row1['ocena']==4.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >4 </a></span>";
                        }else if ($row1['ocena']==5.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >5 </a></span>";
                        }else if ($row1['ocena']==6.00){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >6 </a></span>";
                        }else if ($row1['ocena']==0.03){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieprzygotowany&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >np </a></span>";
                        }else if ($row1['ocena']==0.04){
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Ocena: nieuczęszczał&#10;Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >nu </a></span>";
                        }else{
                            echo "<span class='box' style='background-color:".$row1['kolor'].";'><a title='Kategoria: ".$row1['nazwa_kategorii']."&#10;Data: ".$row1['data']."&#10;Nauczyciel: ".$row1['dodal']." &#10;Licz do średniej: nie&#10;&#10;Dodał: ".$row1['dodal']."&#10;&#10;Komentarz: ".$row1['komentarz']."' >".(int)$row1['ocena']."</a></span>";
                        }
                    }
                    echo"</td></tr>";
                    
                }
                echo "<tr><td colspan='13'></td></tr>";
                echo "<tr><td colspan='3'></td>";
                echo "<td>";
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia 
                        inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                        where oceny.id_ucznia=$id_ucznia and oceny.semestr=1 and nie_licz=0 and kategorie_ocen.id_kategorii not in (5,6,7,8);";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo "-";
                            }else{
                                echo $row2[0];
                            }
                        }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(ocena),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii where oceny.id_ucznia=$id_ucznia and oceny.semestr=1 and oceny.id_kategorii=5;";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo "-";
                            }else{
                                echo $row2[0];
                            }
                        }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(ocena),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii where oceny.id_ucznia=$id_ucznia and oceny.semestr=1 and oceny.id_kategorii=8;";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo "-";
                            }else{
                                echo $row2[0];
                            }
                        }
                echo "</td>";
                echo "<td></td>";
                echo "<td>";
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia 
                        inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                        where oceny.id_ucznia=$id_ucznia and oceny.semestr=2 and nie_licz=0 and kategorie_ocen.id_kategorii not in (5,6,7,8);";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo "-";
                            }else{
                                echo $row2[0];
                            }
                        }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(ocena),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii where oceny.id_ucznia=$id_ucznia and oceny.semestr=2 and oceny.id_kategorii=5;";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo "-";
                            }else{
                                echo $row2[0];
                            }
                        }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(ocena),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii where oceny.id_ucznia=$id_ucznia and oceny.semestr=2 and oceny.id_kategorii=8;";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo "-";
                            }else{
                                echo $row2[0];
                            }
                        }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round((SUM(ocena*oceny.waga)/SUM(oceny.waga)),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia 
                        inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii 
                        where oceny.id_ucznia=$id_ucznia and nie_licz=0 and kategorie_ocen.id_kategorii not in (5,6,7,8);";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo "-";
                            }else{
                                echo $row2[0];
                            }
                        }
                echo "</td>";
                echo "<td>";
                $zapytanie2="SELECT round(avg(ocena),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii where oceny.id_ucznia=$id_ucznia  and oceny.id_kategorii=6;";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo "-";
                            }else{
                                echo $row2[0];
                            }
                        }
                echo "</td>";
                echo "<td id='ocenka'>";
                $zapytanie2="SELECT round(avg(ocena),2) as srednia from oceny inner join uczniowie on oceny.id_ucznia=uczniowie.id_ucznia inner join przedmioty on oceny.id_przedmiotu=przedmioty.id_przedmiotu inner join kategorie_ocen on oceny.id_kategorii=kategorie_ocen.id_kategorii where oceny.id_ucznia=$id_ucznia  and oceny.id_kategorii=7;";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            if($row2[0]==''){
                                echo "-";
                            }else{
                                echo $row2[0];
                            }
                        }
                echo "</td>";
                echo"</tr>";
                echo "</table>";
            }
            
        ?>
        </div>

        <div id="stopka">
        
        </div>
    </div>
    <script>
    var tabela1= document.getElementById('tabela1'); 
    var komorki1= tabela1.querySelectorAll('#ocenka, #zachowanie');

    
    for(var i=0; i<komorki1.length; i++){
        if(komorki1[i].innerHTML>=4.75){
            komorki1[i].style.backgroundImage='linear-gradient(90deg, rgb(202, 202, 202) 50%, rgb(181, 50, 50) 50%)';
            komorki1[i].style.fontWeight='bold';
        }else if(komorki1[i].innerHTML>=4.5 && komorki1[i].innerHTML<4.75){
            komorki1[i].style.backgroundColor='rgb(255,215,0)';
            komorki1[i].style.fontWeight='bold';
        }
    }
    
</script>

</body>
</html>