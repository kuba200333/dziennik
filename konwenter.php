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
    <title>Dodaj przedmiot</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <div class="kontener">
        <h4 class="inside">Dodaj przedmiot</h4>
        <table>
        <form action="" method="post">
            <tr><td class='3' colspan="2"></td></tr>
            <tr><td class='1'>Rodzaj konwersji: </td>
            <td class='2'>
                
                <input type='radio' id='plus' name='typ' value='plus'>
                <label for='plus'>Zamień plusy</label><br>
                <input type='radio' id='minus' name='typ' value='minus'>
                <label for='minus'>Zamień minusy</label>
            </td></tr>
            <tr><td class='1'>Wybierz kategorie:</td>
            <td class='2'>
                <?php
                    if(isset($_POST['id_przedmiot'])){
                        
                        $_SESSION['id_przedmiot']=$_POST['id_przedmiot'];
            
                        
                        $id_przedmiot=$_SESSION['id_przedmiot'];
                    }
                    require "connect.php";
                    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                    $sql="SELECT DISTINCT k.nazwa_kategorii, o.id_kategorii FROM `oceny` o inner join kategorie_ocen k on k.id_kategorii=o.id_kategorii inner join uczniowie u on u.id_ucznia=o.id_ucznia inner join klasy kl on kl.id_klasy=u.id_klasy where ocena in (0.5, 0.25) and o.id_przedmiotu=".$_POST['id_przedmiot']." ";
                    $send=mysqli_query($polaczenie,$sql);  
                    while($row=mysqli_fetch_array($send)){
                        echo"<input type='radio' name='kategoria' id='".$row[0]."' value='".$row[1]."'>";
                        echo "<label for='".$row[0]."'>".$row[0]."</label><br>";
                    }
                ?>
            </td></tr>
            <tr><td class='1'>Liczba znaków do zmiany:</td><td class='2'><input type='number' name='ile' value='3'></td></tr>
            <tr><td class='1'>Semestr:</td><td class='2'><select name='semestr'><option>1</option><option>2</option></td></tr>
            <tr><td class='1'>Zamień na ocenę:</td><td class='2'>
            <input list='oceny' id='ocena' name='ocena' class='ocena'>
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
            </datalist>
            </td></tr>
            <tr><td class='1'>Kategoria oceny:</td><td class='2'>
            <?php
                $sql="SELECT id_kategorii, nazwa_kategorii FROM `kategorie_ocen` where id_kategorii not in (9,10) order by nazwa_kategorii asc;";
                $send=mysqli_query($polaczenie,$sql);
                echo "<select name='kategoria_nowa'>";
                while($row=mysqli_fetch_array($send)){
                    echo"<option value='".$row['id_kategorii']."'>".$row['nazwa_kategorii']."</option>";
                }
                echo "</select>";
            ?>
            </td></tr>
            <tr><td class='1'>Wystaw z datą:</td><td class='2'>
                <?php
                $d=mktime();
                $date=date("Y-m-d", $d);
                $data=date("Y-m-d", $d);
                echo"<input type='date' name='data' value='$data'>";
                ?>
            </td></tr>
            <tr class='inside'><td class="3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'></form>&nbsp<form action='widok_ocen.php' method='post'><input type='submit' value='Zamknij' name='zamknij'"></form></td></tr>
        </table>
        <?php
        if(!empty($_POST['wysylacz'])){
           
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
            $typ= $_POST['typ'];
            $id_kategorii=$_POST['kategoria'];
            $ile_znakow= $_POST['ile'];
            $semestr= $_POST['semestr'];
            $ocena=$_POST['ocena'];
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
            $id_kategorii_nowej=$_POST['kategoria_nowa'];

            $zapytanie1="SELECT waga from kategorie_ocen where id_kategorii=$id_kategorii_nowej;";
            $wyslij1=mysqli_query($polaczenie,$zapytanie1);
            while($row1=mysqli_fetch_array($wyslij1)){
                $waga=$row1['waga'];
            }

            $data= $_POST['data'];
            $zapytanie20="SELECT id_nauczyciela from nauczyciele where login='".$_SESSION['login']."';";
                    $wyslij20=mysqli_query($polaczenie,$zapytanie20);
                    while($row20=mysqli_fetch_array($wyslij20)){
                        $id_nauczyciela=$row20[0];
                    }

            if($typ='plus'){
                $sql="SELECT id_ucznia FROM `oceny` where id_przedmiotu=".$_SESSION['id_przedmiot']." and ocena=0.5 and id_kategorii=$id_kategorii group by id_ucznia HAVING count(*)=$ile_znakow;";
                $send=mysqli_query($polaczenie,$sql);
                while($row=mysqli_fetch_array($send)){
                    $sql1="DELETE FROM oceny where id_ucznia=".$row[0]." and ocena=0.5 and id_kategorii=$id_kategorii and semestr=$semestr LIMIT $ile_znakow";
                    $send1=mysqli_query($polaczenie,$sql1);
                    $sql2="INSERT INTO `oceny`( `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`, `nie_licz`) VALUES (".$_SESSION['id_przedmiot'].",$id_kategorii_nowej,$semestr,$ocena,$waga,'$data',$id_nauczyciela,".$row[0].",'',0)";
                    $send2=mysqli_query($polaczenie,$sql2);
        
                }
            }else if($typ='minus'){
                $sql="SELECT id_ucznia FROM `oceny` where id_przedmiotu=".$_SESSION['id_przedmiot']." and ocena=0.25 and id_kategorii=$id_kategorii group by id_ucznia HAVING count(*)=$ile_znakow;";
                $send=mysqli_query($polaczenie,$sql);
                while($row=mysqli_fetch_array($send)){
                    $sql1="DELETE FROM oceny where id_ucznia=".$row[0]." and ocena=0.25 and id_kategorii=$id_kategorii and semestr=$semestr LIMIT $ile_znakow";
                    $send1=mysqli_query($polaczenie,$sql1);
                    $sql2="INSERT INTO `oceny`( `id_przedmiotu`, `id_kategorii`, `semestr`, `ocena`, `waga`, `data`, `id_nauczyciela`, `id_ucznia`, `komentarz`, `nie_licz`) VALUES (".$_SESSION['id_przedmiot'].",$id_kategorii_nowej,$semestr,$ocena,$waga,'$data',$id_nauczyciela,".$row[0].",'',0)";
                    $send2=mysqli_query($polaczenie,$sql2);

                }
            }
 
            header("Location: http://localhost/dziennik_lekcyjny/widok_ocen.php");
            exit();
        }

        ?>
</body>
</html>