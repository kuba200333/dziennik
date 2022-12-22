<<<<<<< HEAD
<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uczniowie</title>
    <link rel="stylesheet" href="styl5.css">
</head>

<body>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Uczniowie</h2>
        </div>
        
        <div id='wybierz'>
            <form action="" method="post">
            <?php
                
                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie11="SELECT skrot_klasy FROM klasy where wirt=0 order by skrot_klasy asc;";
                $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
            
                echo "Wybierz klasę: <select name='klasy' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row11=mysqli_fetch_array($wyslij11)){
                    echo "<option>".$row11['skrot_klasy']."</option>";
                }
                echo "</select>";
                mysqli_close($polaczenie);
                echo "</form>";
                
                if(!empty($_POST['klasy'])){
                    echo "<p class='srodek'><b>Klasa: </b>".$_POST['klasy']."</p>";
                }
            ?>
            <br>
            
        </div>
        <div id="glowny">
        <br>
            <table>
                
                <?php
                    if(!empty($_POST['klasy'])){
                        $skrot_klasy=$_POST['klasy'];
                        $login=$_SESSION['login'];
                        require "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                        $zapytanie="SELECT u.id_ucznia as id, u.nazwisko_ucznia as nazwisko, u.imie_ucznia as imie, k.skrot_klasy as klasa FROM uczniowie u inner join klasy k on u.id_klasy=k.id_klasy where k.skrot_klasy='$skrot_klasy' order by nazwisko;";
                        $wyslij=mysqli_query($polaczenie,$zapytanie);
                            if ($wyslij->num_rows>0){
                            echo "<tr><th>lp.</th><th>Nazwisko</th><th>Imie</th>";
                            if($_SESSION['admin'] ==1){
                            echo "<th>Usuń</th>";
                            }
                            echo"</tr>";
                            $x=1;
                            while($row=mysqli_fetch_array($wyslij)){
                                echo"<tr><td style='text-align: right;'>".$x++.".</td><td>$row[1]</td><td>$row[2]</td>";
                                if($_SESSION['admin'] ==1){
                                echo "<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_ucznia' value='".$row['id']."'><input type='submit' name='usun' value='X'></form></td>";
                                }
                                echo"</tr>";
                            }
                        }else{
                                echo"Brak uczniów w tym oddziale";
                            }
                        mysqli_close($polaczenie);
                    }
                ?>
            </table>
            <?php
                if(!empty($_POST['usun'])){
                $id=$_POST['id_ucznia'];


                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie="DELETE FROM uczniowie WHERE id_ucznia='$id';";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
            
                }
            ?>
        </div>

        <div id="stopka">
            
        </div>
    </div>

</div>
</div>
</body>
=======
<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uczniowie</title>
    <link rel="stylesheet" href="styl5.css">
</head>

<body>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Uczniowie</h2>
        </div>
        
        <div id='wybierz'>
            <form action="" method="post">
            <?php
                if(empty($_POST['klasy'])){
                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie11="SELECT skrot_klasy FROM klasy where wirt=0 order by skrot_klasy asc;";
                $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
            
                echo "Wybierz klasę: <select name='klasy' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row11=mysqli_fetch_array($wyslij11)){
                    echo "<option>".$row11['skrot_klasy']."</option>";
                }
                echo "</select>";
                mysqli_close($polaczenie);
                echo "</form>";
                }
                if(!empty($_POST['klasy'])){
                    echo "<p class='srodek'><b>Klasa: </b>".$_POST['klasy']."</p>";
                }
            ?>
            <br>
            
        </div>
        <div id="glowny">
        <br>
            <table>
                
                <?php
                    if(!empty($_POST['klasy'])){
                        $skrot_klasy=$_POST['klasy'];
                        $login=$_SESSION['login'];
                        require "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                        $zapytanie="SELECT u.id_ucznia as id, u.nazwisko_ucznia as nazwisko, u.imie_ucznia as imie, k.skrot_klasy as klasa FROM uczniowie u inner join klasy k on u.id_klasy=k.id_klasy where k.skrot_klasy='$skrot_klasy' order by nazwisko;";
                        $wyslij=mysqli_query($polaczenie,$zapytanie);
                            if ($wyslij->num_rows>0){
                            echo "<tr><th>lp.</th><th>Nazwisko</th><th>Imie</th>";
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
                        }else{
                                echo"Brak uczniów w tym oddziale";
                            }
                        mysqli_close($polaczenie);
                    }
                ?>
            </table>
            <?php
                if(!empty($_POST['usun'])){
                $id=$_POST['id_ucznia'];


                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie="DELETE FROM uczniowie WHERE id_ucznia='$id';";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
            
                }
            ?>
        </div>

        <div id="stopka">
            
        </div>
    </div>

</div>
</div>
</body>
>>>>>>> a2b89c71cd09f84b2babb0669484c902f01892c4
</html>