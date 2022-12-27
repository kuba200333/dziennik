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
    <title>Zachowanie uczniów</title>
    <link rel="stylesheet" href="styl6.css">
</head>
<body onload='kategorie()'>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Zachowanie uczniów</h2>
        </div>
        
        <div id='wybierz'>
        <form action="" method='post'>
        <?php
            $login=$_SESSION['login'];
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie11="SELECT skrot_klasy as klasa FROM klasy order by skrot_klasy asc;";
            $wyslij11=mysqli_query($polaczenie,$zapytanie11);  

            if ($wyslij11->num_rows>0){
            echo "klasa: <select name='klasy' onchange='this.form.submit()'>";
            echo "<option value=''</option>";
            while($row11=mysqli_fetch_array($wyslij11)){
                echo "<option>".$row11['klasa']."</option>";
            }
            echo "</select>";
            }else{
                echo "Nie uczysz w żadnej klasie";
            }
            
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
            
                echo "uczeń: <select name='uczen' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row10=mysqli_fetch_array($wyslij10)){
                    echo "<option>".$row10[0]."</option>";
                }
                echo "</select><br>";
            
    
                mysqli_close($polaczenie);
                
                }
                if((!empty($_POST['uczen']))){
                    $uczen=@$_POST['uczen'];

                    echo "<br><b>Uczeń: </b>". $uczen;
                }
            ?>
        
            </form>
            <br>
          
        </div>
        <div id="glowny1">

        <?php
        if(!empty($_POST['uczen'])){
            $uczen=@$_POST['uczen'];
            $przedmiot="zachowanie";
            echo "<h3>Semestr 1</h3>";

    

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie1="SELECT oceny_zachowanie.id_oceny as id_oceny, oceny_zachowanie.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny_zachowanie.komentarz as komentarz, oceny_zachowanie.data as data, nauczyciele.login as login from oceny_zachowanie 
            inner join przedmioty on oceny_zachowanie.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny_zachowanie.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny_zachowanie.id_kategorii=kategorie_ocen.id_kategorii 
            inner join nauczyciele on oceny_zachowanie.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' and przedmioty.nazwa_przedmiotu='$przedmiot' and semestr=1 order by data asc;";
    
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
            if ($wyslij1->num_rows>0){
            echo "<table>";
            echo "<tr><th>ocena</th><th>kategoria</th><th>Komentarz</th><th>data</th><th>dodał</th><th>usuń</th></tr>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo "<tr class=".$row1['kategoria']."><td id=".$row1['ocena'].">";


                if($row1['ocena']==0){
                    echo "";
                    }
                    else if($row1['ocena']==6){
                        echo "wzorowe";
                    }
                    else if($row1['ocena']==5){
                        echo "bardzo dobre";
                    }
                    else if($row1['ocena']==4){
                        echo "dobre";
                    }
                    else if($row1['ocena']==3){
                        echo "poprawne";
                    }
                    else if($row1['ocena']==2){
                        echo "nieodpowiednie";
                    }
                    else if($row1['ocena']==1){
                        echo "naganne";
                    }

                echo "</td><td>".$row1['nazwa_kategorii']."</td><td>".$row1['komentarz']."</td><td>".$row1['data']."</td><td>".$row1['dodal']."</td>";
                if($_SESSION['admin'] ==1){
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
            $uczen=@$_POST['uczen'];
            $przedmiot='zachowanie';
            echo "<h3>Semestr 2</h3>";
    
            require "connect.php";
            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie1="SELECT oceny_zachowanie.id_oceny as id_oceny, oceny_zachowanie.ocena as ocena, kategorie_ocen.skrót_kategorii as kategoria, kategorie_ocen.nazwa_kategorii as nazwa_kategorii, concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as dodal, oceny_zachowanie.komentarz as komentarz, oceny_zachowanie.data as data, nauczyciele.login as login from oceny_zachowanie 
            inner join przedmioty on oceny_zachowanie.id_przedmiotu=przedmioty.id_przedmiotu inner join uczniowie on oceny_zachowanie.id_ucznia=uczniowie.id_ucznia inner join kategorie_ocen on oceny_zachowanie.id_kategorii=kategorie_ocen.id_kategorii 
            inner join nauczyciele on oceny_zachowanie.id_nauczyciela=nauczyciele.id_nauczyciela where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)= '$uczen' and przedmioty.nazwa_przedmiotu='$przedmiot' and semestr=2 order by data asc;";
    
    
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
            if($wyslij1->num_rows>0){
            echo "<table>";
            echo "<tr><th>ocena</th><th>kategoria</th><th>Komentarz</th><th>data</th><th>dodał</th><th>usuń</th></tr>";
            while($row1=mysqli_fetch_array($wyslij1)){
                echo "<tr class=".$row1['kategoria']."><td id=".$row1['ocena'].">";


                if($row1['ocena']==0){
                    echo "";
                    }
                    else if($row1['ocena']==6){
                        echo "wzorowe";
                    }
                    else if($row1['ocena']==5){
                        echo "bardzo dobre";
                    }
                    else if($row1['ocena']==4){
                        echo "dobre";
                    }
                    else if($row1['ocena']==3){
                        echo "poprawne";
                    }
                    else if($row1['ocena']==2){
                        echo "nieodpowiednie";
                    }
                    else if($row1['ocena']==1){
                        echo "naganne";
                    }
                    echo "</td><td>".$row1['nazwa_kategorii']."</td><td>".$row1['komentarz']."</td><td>".$row1['data']."</td><td>".$row1['dodal']."</td>";
                    if($login==$row1['login']){
                    echo"<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_oceny' value='".$row1['id_oceny']."'><input type='submit' name='usun' value='X'></form></td></tr>";
                    }else{
                        echo"<td></td></tr>";
                    }
            }
            echo "</table>";
        }   else{
            echo "Uczeń nie posiada ocen!";
        }
    
            mysqli_close($polaczenie);

        }
        ?>
        </div>

        <div id="stopka">
        <a href="\dziennik_lekcyjny\dodaj_zachowanie.php" onclick="window.open('dodaj_zachowanie.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=400').focus(); return false">Dodaj ocenę</a>
        </div>
    </div>

        <?php
                if(!empty($_POST['usun'])){
                $id_oceny=$_POST['id_oceny'];

                require "connect.php";
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie="DELETE FROM oceny_zachowanie WHERE id_oceny='$id_oceny';";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
            
                }
                ?>
         <script>
                    function kategorie(){
                            let tablica = document.querySelectorAll(".spr, .odp_ust, .zad, .kartk, .prop_srodr, .prop_rocz, .roczna, .śródroczna, .uwaga, .pochwała, .prac_klas, .akt, .zad_dom, .inna, .prac_lekc");
                                for (n in tablica){
                                    if (tablica[n].className == "spr") {
                                        tablica[n].style.backgroundColor="greenyellow";
                                    } if (tablica[n].className == "zad") {
                                        tablica[n].style.backgroundColor="silver";
                                    } if (tablica[n].className == "kartk") {
                                        tablica[n].style.backgroundColor="mediumorchid";
                                    }if (tablica[n].className == "roczna") {
                                        tablica[n].style.backgroundColor="lightskyblue";
                                    }if (tablica[n].className == "śródroczna") {
                                        tablica[n].style.backgroundColor="lightskyblue";
                                    }if (tablica[n].className == "odp_ust") {
                                        tablica[n].style.backgroundColor="#FFD700";
                                    }if (tablica[n].className == "uwaga") {
                                        tablica[n].style.backgroundColor="lightsalmon";
                                    }if (tablica[n].className == "pochwała") {
                                        tablica[n].style.backgroundColor="darkseagreen";
                                    }if (tablica[n].className == "prac_klas") {
                                        tablica[n].style.backgroundColor="#FF0000";
                                    }if (tablica[n].className == "prop_srodr") {
                                        tablica[n].style.backgroundColor="lightskyblue";
                                    }if (tablica[n].className == "prop_rocz") {
                                        tablica[n].style.backgroundColor="lightskyblue";
                                    }if (tablica[n].className == "akt") {
                                        tablica[n].style.backgroundColor="silver";
                                    }if (tablica[n].className == "zad_dom") {
                                        tablica[n].style.backgroundColor="#FF8C00";
                                    }if (tablica[n].className == "inna") {
                                        tablica[n].style.backgroundColor="khaki";
                                    }if (tablica[n].className == "prac_lekc") {
                                        tablica[n].style.backgroundColor="#FFA07A";
                                    }
                                    
                                }
                                
                    }
            

                    
            
         </script>
</body>
</html>