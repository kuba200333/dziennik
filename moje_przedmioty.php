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
    <title>Moje przedmioty</title>
    <link rel="stylesheet" href="styl7.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>
    </div>

    <div id="naglowek2">
        <h2>Moje przedmioty</h2>
    </div>
        
    <div id="glowny">
        <br><br>
           <?php
                require "connect.php";
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                
                $login=$_SESSION['login'];
                $zapytanie="SELECT k.nazwa_klasy as klasa, p.nazwa_przedmiotu as przedmiot, n.id_klasy as id_klasy, n.id_przedmiot as id_przedmiot FROM nauczanie n inner join klasy k on n.id_klasy=k.id_klasy 
                inner join przedmioty p on p.id_przedmiotu=n.id_przedmiot inner join nauczyciele na on na.id_nauczyciela=n.id_nauczyciel where na.login='$login' order by k.nazwa_klasy, p.nazwa_przedmiotu asc;";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
                if ($wyslij->num_rows>0){
                echo "<table>
                <tr><th>lp.</th><th>przedmiot</th><th>klasa (grupa)</th><th>oceny uczniów</th><th>dodawanie ocen seryjnie</th><th>sprawdzenie frekwencji</th></tr>
                ";
                $x=1;
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<tr><td style='text-align: right;'>".$x++.".</td><td>".$row[1]."</td><td>".$row[0]."</td><td class='usuwanie'><form action='podglad_oceny_nauczyciela.php' method='post'><input type='hidden' name='id_klasy' value='".$row[2]."'><input type='hidden' name='id_przedmiot' value='".$row[3]."'><input type='submit' name='usun' value='X'></form></td>
                    <td class='usuwanie'><form action='seryjne_oceny.php' method='post'><input type='hidden' name='klasa' value='".$row[0]."'><input type='hidden' name='id_klasy' value='".$row[2]."'><input type='hidden' name='nazwa_przedmiotu' value='".$row[1]."'><input type='hidden' name='id_przedmiot' value='".$row[3]."'><input type='submit' name='usun' value='X'></form></td>
                    <td class='usuwanie'><form action='obecnosc.php' method='post'><input type='hidden' name='klasa' value='".$row[0]."'><input type='hidden' name='id_klasy' value='".$row[2]."'><input type='hidden' name='id_przedmiot' value='".$row[3]."'><input type='submit' name='usun' value='X'></form></td>
                    </tr>";
                }
                echo "</table>";
                }else{
                    echo "Nie uczysz w żadnej klasie!";
                }
           ?>
    </div>
    
    <div id="stopka">
       
    </div>
</div>

    </form>
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
    <title>Nauczyciele</title>
    <link rel="stylesheet" href="styl7.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>
    </div>

    <div id="naglowek2">
        <h2>Moje przedmioty</h2>
    </div>
        
    <div id="glowny">
        <br><br>
           <?php
                require "connect.php";
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                
                $login=$_SESSION['login'];
                $zapytanie="SELECT k.nazwa_klasy as klasa, p.nazwa_przedmiotu as przedmiot, n.id_klasy as id_klasy, n.id_przedmiot as id_przedmiot FROM nauczanie n inner join klasy k on n.id_klasy=k.id_klasy 
                inner join przedmioty p on p.id_przedmiotu=n.id_przedmiot inner join nauczyciele na on na.id_nauczyciela=n.id_nauczyciel where na.login='$login' order by k.nazwa_klasy, p.nazwa_przedmiotu asc;";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
                if ($wyslij->num_rows>0){
                echo "<table>
                <tr><th>lp.</th><th>przedmiot</th><th>klasa (grupa)</th><th>oceny uczniów</th><th>dodawanie ocen seryjnie</th><th>sprawdzenie frekwencji</th></tr>
                ";
                $x=1;
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<tr><td style='text-align: right;'>".$x++.".</td><td>".$row[1]."</td><td>".$row[0]."</td><td class='usuwanie'><form action='podglad_oceny_nauczyciela.php' method='post'><input type='hidden' name='id_klasy' value='".$row[2]."'><input type='hidden' name='id_przedmiot' value='".$row[3]."'><input type='submit' name='usun' value='wybierz'></form></td>
                    <td class='usuwanie'><form action='seryjne_oceny.php' method='post'><input type='hidden' name='klasa' value='".$row[0]."'><input type='hidden' name='id_klasy' value='".$row[2]."'><input type='hidden' name='id_przedmiot' value='".$row[3]."'><input type='submit' name='usun' value='wybierz'></form></td>
                    <td class='usuwanie'><form action='obecnosc.php' method='post'><input type='hidden' name='klasa' value='".$row[0]."'><input type='hidden' name='id_klasy' value='".$row[2]."'><input type='hidden' name='id_przedmiot' value='".$row[3]."'><input type='submit' name='usun' value='wybierz'></form></td>
                    </tr>";
                }
                echo "</table>";
                }else{
                    echo "Nie uczysz w żadnej klasie!";
                }
           ?>
    </div>
    
    <div id="stopka">
       
    </div>
</div>

    </form>
</body>
>>>>>>> a2b89c71cd09f84b2babb0669484c902f01892c4
</html>