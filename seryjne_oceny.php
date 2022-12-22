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
    <title>Dodawanie seryjne ocen</title>
    <link rel="stylesheet" href="styl9.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\moje_przedmioty.php">Powrót do nauczanych przedmiotów <br></a>
    </div>

    <div id="naglowek2">
        <h2>Dodawanie seryjnie ocen</h2>
    </div>
        
    <div id='glowny'>
    <?php
        require "connect.php";
        
        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        echo"
        
        <table><form action='' method='post'>
        <tr><td class='kolumna3' colspan='2'></td></tr>
        <tr><td class='kolumna1'>klasa:</td> <td class='kolumna2'>".$_POST['klasa']."</td></tr>";
        echo "<tr><td class='kolumna1'>przedmiot:</td> <td class='kolumna2'>".$_POST['nazwa_przedmiotu']."</td></tr>";
        echo "<tr><td class='kolumna1'>Wybierz datę: </td><td class='kolumna2'><input type='date' id='theDate' name='data' required></td></tr>";
        echo "<option value=''</option>";

        $zapytanie5="SELECT nazwa_kategorii FROM `kategorie_ocen` where id_kategorii not in (9,10) order by nazwa_kategorii asc;";
            
        $wyslij5=mysqli_query($polaczenie,$zapytanie5);
        
        echo "<tr><td class='kolumna1'>kategoria:</td> <td class='kolumna2'><select name='kategoria'  id='info'  required>";
        echo "<option value=''</option>";
        while($row5=mysqli_fetch_array($wyslij5)){
            echo "<option>".$row5['nazwa_kategorii']."</option>";
        }
        echo "</select></td></tr>";
        echo "<tr><td class='kolumna1'>komentarz: </td><td class='kolumna2'><input type='text' id='koment' name='komentarz' onchange='komentarz_ser()'></td></tr>
        
        <tr><td class='kolumna3' colspan='2'></td></tr>
        </table><br>";

        echo "<table>
        <tr><th>lp.</th><th>uczen</th><th>ocena</th><th>komentarz</th></tr>";
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $id_klasy=$_POST['id_klasy'];
        $id_przedmiot=$_POST['id_przedmiot'];

        $zapytanie="SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as duczen FROM uczniowie where id_klasy=$id_klasy UNION SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen FROM wirtualne_klasy where id_klasy=$id_klasy ORDER BY duczen ASC;";

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
                <option selected>5</option>
                <option>5+</option>
                <option>6-</option>
                <option>6</option>
                <option>+</option>
                <option>-</option>
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
                $komentarz = $tab_kom[$keys];
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
                }
                if($ocena<1 or $ocena>6){
                    $nie_licz=1;
                }else{
                    $nie_licz=0;
                }
            mysqli_query($polaczenie, "INSERT INTO oceny(`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`, nie_licz) VALUES (null, $id_przedmiot, $id_kategorii, $semestr, $ocena, $waga, '$data', $id_nauczyciela, $keys, '$komentarz', $nie_licz);");
            //echo"INSERT INTO oceny(`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`, nie_licz) VALUES (null, $id_przedmiot, $id_kategorii, $semestr, $ocena, $waga, '$data', $id_nauczyciela, $keys, '$komentarz', $nie_licz);";
            
            }
            header("Location: http://localhost/dziennik_lekcyjny/moje_przedmioty.php");
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
    <title>Oceny seryjnie</title>
    <style>
        table{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
        td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        tr{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th{
            border: 1px solid black;
            border-collapse: collapse;
        }
        td.wyglad input{
            appearance: none;
            width: 10px;
            height: 10px;
            border: 1px solid black;
        }
        td.wyglad input:checked{
            background-color: black;
        }
        .kolumna1{
            width: 30%;
            background-color: rgba(255, 253, 251, 0.909);
        }
        .kolumna2{
            width: 70%;
            background-color: rgb(236, 236, 236);
        }
        .kolumna3{
            width: 100%;
            background-color: rgb(236, 236, 236);
        }
    </style>
</head>
<body>
<form action="" method="post">
        
    <?php
        require "connect.php";
        
        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        echo"
        <table>
        <tr><td class='kolumna3' colspan='2'></td></tr>
        <tr><td class='kolumna1'>klasa:</td> <td class='kolumna2'>".$_POST['klasa']."</td></tr>";
        echo "<tr><td class='kolumna1'>Wybierz datę: </td><td class='kolumna2'><input type='date' name='data' required></td></tr>";
        echo "<option value=''</option>";

        $zapytanie5="SELECT nazwa_kategorii FROM `kategorie_ocen` where id_kategorii not in (9,10) order by nazwa_kategorii asc;";
            
        $wyslij5=mysqli_query($polaczenie,$zapytanie5);
        
        echo "<tr><td class='kolumna1'>kategoria:</td> <td class='kolumna2'><select name='kategoria' required>";
        echo "<option value=''</option>";
        while($row5=mysqli_fetch_array($wyslij5)){
            echo "<option>".$row5['nazwa_kategorii']."</option>";
        }
        echo "</select></td></tr>";
        echo "<tr><td class='kolumna1'>komentarz: </td><td class='kolumna2'><input type='text' name='komentarz'></td></tr>
        </table><br>";

        echo "<table>
        <tr><th>lp.</th><th>uczen</th><th>ocena</th></tr>";
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $id_klasy=$_POST['id_klasy'];
        $id_przedmiot=$_POST['id_przedmiot'];
        $zapytanie="SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen FROM uczniowie where id_klasy=$id_klasy UNION SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen FROM wirtualne_klasy where id_klasy=$id_klasy ORDER BY uczen ASC;";
        $wyslij=mysqli_query($polaczenie,$zapytanie);
        $x=1;
        while($row=mysqli_fetch_array($wyslij)){
            echo '<tr id="'.$row[0].'"><td>'.$x++.'.</td><td style="text-align:left;">'.$row['uczen']."</td><td>
            <input list='oceny' name='ocena[".$row[0]."]'>
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
            </datalist><input type='hidden' name='id_przedmiot' value='".$id_przedmiot."'></td></tr>";
        }
        
        echo "</table>";
        echo '<input type="submit" name="submit"></td></form>';

        if(isset($_POST['submit'])){

            $tab=$_POST['ocena'];
            $id_przedmiot=$_POST['id_przedmiot'];
            $kategoria=$_POST['kategoria'];

            print_r ($tab=$_POST['ocena']);
            $data=$_POST['data'];
            $komentarz=$_POST['komentarz'];
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

            foreach($tab as $key=> $ocena){
                if($key !=""){
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
                mysqli_query($polaczenie, "INSERT INTO oceny(`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`) VALUES (null, $id_przedmiot, $id_kategorii, $semestr, $ocena, $waga, '$data', $id_nauczyciela, $key, '$komentarz');");
                //echo"INSERT INTO oceny(`id_oceny`, `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`) VALUES (null, $id_przedmiot, $id_kategorii, $semestr, $ocena, $waga, '$data', $id_nauczyciela, $key, '$komentarz');";
                }
            }
            header("Location: http://localhost/dziennik_lekcyjny/moje_przedmioty.php");
        }
    ?>
</body>
>>>>>>> a2b89c71cd09f84b2babb0669484c902f01892c4
</html>