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
    <title>Dodawanie seryjne ocen</title>
    <link rel="stylesheet" href="styl9.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\widok_ocen_admin.php">Powrót do widoku ocen <br></a>
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
        
        <table><form action='' method='post'>
        <tr><td class='3' colspan='2'></td></tr>
        <tr><td class='1'>klasa:</td> <td class='2'>".$nazwa_klasy."</td></tr>";
        echo "<tr><td class='1'>przedmiot:</td> <td class='2'>".$nazwa_przedmiotu."</td></tr>";
        $d=mktime();
        $date=date("Y-m-d", $d);

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
        echo "<tr><td class='1'>komentarz: </td><td class='2'><input type='text' id='koment' name='komentarz' onchange='komentarz_ser()'></td></tr>
        
        <tr><td class='3' colspan='2'></td></tr>
        </table><br>";

        echo "<table>
        <tr><th>lp.</th><th>uczen</th><th>ocena</th><th>komentarz</th></tr>";
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $id_klasy=$_POST['id_klasy'];
        $id_przedmiot=$_POST['id_przedmiot'];

        $zapytanie10="SELECT wirt FROM klasy where id_klasy=$id_klasy;";

                $wyslij10=mysqli_query($polaczenie,$zapytanie10);
                while($row10=mysqli_fetch_array($wyslij10)){
                    $wirt=$row10[0];
                }
                if($wirt==0){
                    $zapytanie="SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as duczen FROM uczniowie where id_klasy=$id_klasy order by nazwisko_ucznia asc, imie_ucznia asc;";
                }else{
                    $zapytanie="SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as duczen FROM wirtualne_klasy where id_klasy=$id_klasy order by nazwisko_ucznia asc, imie_ucznia asc;";

                }
        

        $wyslij=mysqli_query($polaczenie,$zapytanie);
        $x=1;
        while($row=mysqli_fetch_array($wyslij)){
            echo '<tr id="'.$row[0].'"><td>'.$x++.'.</td><td style="text-align:left;">'.$row['duczen']."</td><td>
            <input list='oceny' id='ocena' class='ocena' name='ocena[".$row[0]."]'>
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
        
        echo "</table>";
        echo '<input type="submit" name="submit"></td></form>';

        
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
            header("Location: http://localhost/dziennik_lekcyjny/widok_ocen_admin.php");
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
        
    </script>
</body>
</html>