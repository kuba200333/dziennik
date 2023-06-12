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
    <title>Zaległości ocenowe</title>
    <link rel="stylesheet" href="styl5.css">
</head>

<body>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Zaległości ocenowe</h2>
        </div>
        
        <div id='wybierz'>
            <form action="" method="post">
            <?php
                
                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie11="SELECT id_kategorii, nazwa_kategorii FROM `kategorie_ocen` where id_kategorii in(5,6,7,8) order by nazwa_kategorii asc;";
                $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
            
                echo "Wybierz typ: <select name='klasy' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row11=mysqli_fetch_array($wyslij11)){
                    echo "<option value='".$row11['id_kategorii']."'>".$row11['nazwa_kategorii']."</option>";
                }
                echo "</select>";
                mysqli_close($polaczenie);
                echo "</form>";
                
        
            ?>
            <br>
            
        </div>
        <div id="glowny">
        <br>
            <table>
                
                <?php
                    if(!empty($_POST['klasy'])){
                        require "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                        $zap="SELECT nazwa_kategorii from kategorie_ocen where id_kategorii=".$_POST['klasy'].";";
                        $send1=mysqli_query($polaczenie,$zap);  
                        while($row=mysqli_fetch_array($send1)){
                            echo "<b>Kategoria ocen:</b> ".$row['nazwa_kategorii']."<br><br>";
                        }
                        
                        $sql="SELECT p.nazwa_przedmiotu, k.nazwa_klasy, concat(nt.nazwisko,' ', nt.imie) as nauczyciel
                        FROM przedmioty p
                        JOIN nauczanie n ON n.id_przedmiot = p.id_przedmiotu
                        JOIN klasy k ON k.id_klasy = n.id_klasy
                        JOIN nauczyciele nt ON nt.id_nauczyciela = n.id_nauczyciel
                        LEFT JOIN oceny o ON o.id_przedmiotu = p.id_przedmiotu AND o.id_kategorii = ".$_POST['klasy']." AND o.id_nauczyciela = nt.id_nauczyciela
                        WHERE n.id_klasy IS NOT NULL AND o.id_oceny IS NULL  
                        ORDER BY nauczyciel ASC, nazwa_przedmiotu asc";
                        $send=mysqli_query($polaczenie,$sql);  
                       
                        echo "<table>";
                        echo"<tr><th>ID</th><th>Przedmiot</th><th>Klasa/grupa</th><th>Nauczyciel</th></tr>";
                        $x=1;
                        while($row=mysqli_fetch_array($send)){
                            echo"<tr><td>".$x++.".</td><td>".$row['nazwa_przedmiotu']."</td><td>".$row['nazwa_klasy']."</td><td>".$row['nauczyciel']."</td></tr>";
                        }
                        echo "</table>";
                        mysqli_close($polaczenie);
                    }
                ?>
            </table>
           
        </div>

        <div id="stopka">
            
        </div>
    </div>

</div>
</div>
</body>
</html>