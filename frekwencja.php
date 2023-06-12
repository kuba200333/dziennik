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
        <form action="" method='get'>
            <?php

            
                require "connect.php";
                $pol = @new mysqli($host, $db_user, $db_password, $db_name);

                $zapytanie="SELECT k.skrot_klasy FROM klasy k inner join nauczyciele n on k.id_nauczyciela=n.id_nauczyciela where n.login='".$_SESSION['login']."';";
                $wyslij=mysqli_query($pol,$zapytanie);
                while($row=mysqli_fetch_array($wyslij)){
                    $skrot_klasy=$row[0];
                }

                $zapytanie10="SELECT concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia) as uczen FROM uczniowie inner join klasy on uczniowie.id_klasy=klasy.id_klasy where klasy.skrot_klasy='$skrot_klasy' order by concat(nazwisko_ucznia, ' ', imie_ucznia) asc;";
                $wyslij10=mysqli_query($pol,$zapytanie10);  

                echo "uczeń: <select name='uczen' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row10=mysqli_fetch_array($wyslij10)){
                    echo "<option>".$row10[0]."</option>";
                }
                echo "</select><br>";

                if(isset($_POST['uczen'])){
                    echo "<br><b>".$_GET['uczen']."</b>";
                }
            ?>
            </form>
        </div>
        <div id="glowny">

            <?php

                if(isset($_GET['uczen'])){
                $uczen=$_GET['uczen'];

                $zap2="SELECT id_ucznia from uczniowie where concat(uczniowie.nazwisko_ucznia, ' ', uczniowie.imie_ucznia)='$uczen';";
                $wys2=mysqli_query($pol,$zap2);
                while($row2=mysqli_fetch_array($wys2)){
                    $id_ucznia=$row2[0];

                echo "<table>";
                echo "<tr><th>Data</th>";
                $zap2="SELECT DISTINCT nr_lekcji FROM `frekwencja` order by nr_lekcji asc;";
                $wys2=mysqli_query($pol,$zap2);
                while($row2=mysqli_fetch_array($wys2)){
                    echo "<th>".$row2[0]."</th>";
                }
                echo "</tr>";
                $zap="SELECT DISTINCT data FROM frekwencja where id_ucznia=$id_ucznia ORDER BY data desc;";
                $wys=mysqli_query($pol,$zap);
                while($row=mysqli_fetch_array($wys)){
                    echo "<tr><th>".$row['data']."</th>";
      
                    $zap2="SELECT DISTINCT nr_lekcji FROM `frekwencja` order by nr_lekcji asc;";
                    $wys2=mysqli_query($pol,$zap2);
                    while($row2=mysqli_fetch_array($wys2)){
                        echo "<td>";
                        $zap1="SELECT f.id_frekwencji, f.id_ucznia , f.data, f.semestr, kf.nazwa_frekwencji, f.typ_ob, f.nr_lekcji, p.nazwa_przedmiotu, concat(n.nazwisko, ' ', n.imie) as nauczyciel, 
                        kf.kolor, f.temat FROM frekwencja f join kategorie_frekwencji kf on f.typ_ob=kf.skrot_frekwencji join nauczyciele n on f.id_nauczyciel=n.id_nauczyciela join przedmioty p on 
                        f.id_przedmiot=p.id_przedmiotu where f.id_ucznia=$id_ucznia and f.data= '".$row['data']."' and f.nr_lekcji=".$row2[0]." ORDER BY f.data desc, f.nr_lekcji asc;";

                        $wys1=mysqli_query($pol,$zap1);
                        while($row1=mysqli_fetch_array($wys1)){
    
                        echo "<span class='ocena' style='background-color:".$row1[9]."'><form id='".$row1['id_frekwencji']."'action='edycja_frekwencji.php' method='post'><input type='hidden' name='id_frekwencji' value='".$row1['id_frekwencji']."'></form><a href='#' onclick='document.getElementById(`".$row1['id_frekwencji']."`).submit();' title='Rodzaj: ".$row1[4]."&#10;Data: ".$row1['2']."&#10;Lekcja: ".$row1[7]."&#10;Temat zajęć: ".$row1[10]."&#10;Nauczyciel: ".$row1[8]."&#10;Godzina lekcyjna: ".$row1[6]."&#10;Dodał: ".$row1[8]."'>".$row1[5]."</a></span>";
                    }
                        echo"</td>";
                    }

                    echo "</td>";
                    echo"</tr>";
                }
            }}
            ?>
            </table>
        </div>

        <div id="stopka">
        
        </div>
    </div>



</body>
</html>