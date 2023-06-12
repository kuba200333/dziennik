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
    <link rel="stylesheet" href="styl14.css">
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
        <br>
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
            </form>
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
            
            
                #$zapytanie10="SELECT DISTINCT p.nazwa_przedmiotu as przedmiot from nauczanie n inner join przedmioty p on n.id_przedmiot=p.id_przedmiotu inner join klasy k on n.id_klasy=k.id_klasy where k.skrot_klasy='$skrot_klasy' order by przedmiot asc;";
                $zapytanie10="SELECT DISTINCT p.nazwa_przedmiotu as przedmiot FROM oceny o inner join uczniowie u on u.id_ucznia=o.id_ucznia inner join
                 klasy k on k.id_klasy=u.id_klasy inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu where k.skrot_klasy='$skrot_klasy' order by przedmiot asc;";
                $wyslij10=mysqli_query($polaczenie,$zapytanie10);  
            
                echo "<table>";
                echo"<tr><th>przedmiot</th><th>Dodający oceny</th><th>Przejrzyj</th></tr>";
                while($row10=mysqli_fetch_array($wyslij10)){
                    echo"<tr><td><b>".$row10[0]."</b></td><td>";
                    $sql="SELECT DISTINCT p.nazwa_przedmiotu as przedmiot, concat(n.nazwisko,' ',n.imie) as nauczyciel from nauczanie na inner join przedmioty p on p.id_przedmiotu=na.id_przedmiot inner join nauczyciele n on n.id_nauczyciela=na.id_nauczyciel inner join klasy k on k.id_klasy=na.id_klasy LEFT JOIN przyp_wirt pw ON pw.id_macierz = k.id_klasy OR pw.id_wirt = k.id_klasy  where (k.id_klasy = $id_klasy OR pw.id_macierz = $id_klasy) and p.nazwa_przedmiotu='".$row10[0]."';";

                    $wyslij=mysqli_query($polaczenie,$sql);
                    $count = mysqli_num_rows($wyslij);
                    $i = 0;
                    while ($row12 = mysqli_fetch_array($wyslij)) {
                        echo '<span>' . $row12[1] . '</span>';
                        if (++$i != $count) {
                            echo ', ';
                        }
                    }
                    echo"</td><td>";
                    echo"<form action='widok_ocen_naucz.php' method='post'>
                    <input type='hidden' name='klasy' value='$skrot_klasy'>
                    <input type='hidden' name='przedmiot' value='".$row10['przedmiot']."'>
                    <input type='submit' name='usun' value='X'></form></td>";
                    
                }
                echo "</table>";
                mysqli_close($polaczenie);
                
                }

            ?>
            
    </div>
    
    <div id="stopka">
       
    </div>
</div>

    
</body>
</html>