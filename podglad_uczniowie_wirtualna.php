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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uczniowie wirtualnych klas</title>
    <link rel="stylesheet" href="styl5.css">
</head>

<body>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Uczniowie wirtualnych klas</h2>
        </div>
        
        <div id='wybierz'>
            <form action="" method="post">
            <?php

                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie11="SELECT skrot_klasy FROM klasy where wirt=1 order by skrot_klasy asc;";
                $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
            
                echo "Wybierz klasę wirtualną: <select name='klasy' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row11=mysqli_fetch_array($wyslij11)){
                    echo "<option>".$row11['skrot_klasy']."</option>";
                }
                echo "</select>";
                mysqli_close($polaczenie);
                echo "</form>";
                
                if(!empty($_POST['klasy'])){
                    require "connect.php";

                    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                    $zapytanie110="SELECT nazwa_klasy FROM klasy where skrot_klasy='".$_POST['klasy']."';";
                    $wyslij110=mysqli_query($polaczenie,$zapytanie110);  
                    while($row110=mysqli_fetch_array($wyslij110)){
                        $nazwa_klasy= $row110['nazwa_klasy'];
                    }

                    echo "<p class='srodek'><b>Klasa wirtualna: </b>".$nazwa_klasy."</p>";
                }
            ?>
            <br>
            
        </div>
        <div id="glowny">
        <br>
            
                
                <?php
                    if(!empty($_POST['klasy'])){
                        $skrot_klasy=$_POST['klasy'];
                        $login=$_SESSION['login'];
                        require "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                        $zapytanie="SELECT u.id_ucznia as id, u.nazwisko_ucznia as nazwisko, u.imie_ucznia as imie, k.skrot_klasy as klasa FROM wirtualne_klasy u inner join klasy k on u.id_klasy=k.id_klasy where k.skrot_klasy='$skrot_klasy' order by nazwisko;";
                        $wyslij=mysqli_query($polaczenie,$zapytanie);
                            if ($wyslij->num_rows>0){
                                
                            echo "<table><tr><th>lp.</th><th>Nazwisko</th><th>Imie</th>";
                            if($login=='admin'){
                            echo "<th>Usuń</th>";
                            }
                            echo"</tr>";
                            $x=1;
                            while($row=mysqli_fetch_array($wyslij)){
                                echo"<tr><td style='text-align: right;'>".$x++.".</td><td>$row[1]</td><td>$row[2]</td>";
                                if($login=='admin'){
                                echo "<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_ucznia' value='".$row['id']."'><input type='submit' name='usun' value='X'></form></td>";
                                }
                                echo"</tr>";
                                
                            }
                            echo "</table>";
                        }else{
                                echo"Brak uczniów w tym oddziale";
                            }
                        mysqli_close($polaczenie);
                    }

                ?>
            
            <?php
                if(!empty($_POST['usun'])){
                $id=$_POST['id_ucznia'];


                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie="DELETE FROM wirtualne_klasy WHERE id_ucznia='$id';";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
            
                }
            ?>
        </div>

        <div id="stopka">
            <?php
                if(!empty($_POST['klasy'])){
                        echo <<<END
                            <a href="\dziennik_lekcyjny\dodaj_dowirt.php" onclick="window.open('dodaj_dowirt.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=400').focus(); return false">Dodaj ucznia do klasy wirtualnej</a>
                        END;
                }
            ?>
        </div>
    </div>

</div>
</div>
</body>
</html>