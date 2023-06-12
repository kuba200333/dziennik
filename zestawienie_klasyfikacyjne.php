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
    <link rel="stylesheet" href="styl11.css">
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
            
                echo "Wybierz klasę: <select name='klasy' required>";
                echo "<option value=''></option>";
                while($row11=mysqli_fetch_array($wyslij11)){
                    echo "<option>".$row11['skrot_klasy']."</option>";
                }
                echo "</select><br>";

                echo "Wybierz okres: <select name='okres' onchange='this.form.submit()'>";
                echo "<option value=''></option>";
                echo "<option value='śródroczna'>śródroczna</option>";
                echo "<option value='roczna'>roczna</option>";
                echo "</select>";

                mysqli_close($polaczenie);
                echo "</form>";

            ?>
            
        </div>
        <div id="glowny">

                <?php
                $okres=@$_POST['okres'];
                    if($okres=='śródroczna'){
                        
                        require "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                        echo "<p><b>Klasa:</b> ".$_POST['klasy']."</p>";
                        $zapytanie="SELECT id_klasy from klasy where skrot_klasy='".$_POST['klasy']."';";
                        $wyslij=mysqli_query($polaczenie,$zapytanie);  
                        while($row=mysqli_fetch_array($wyslij)){
                            $id_klasy=$row[0];
                        }
                        $zapytanie1="SELECT concat(n.nazwisko,' ',n.imie) as nauczyciel FROM klasy k 
                        inner join nauczyciele n on k.id_nauczyciela=n.id_nauczyciela where 
                        id_klasy=$id_klasy;";

                        $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                        while($row1=mysqli_fetch_array($wyslij1)){
                            $wychowawca=$row1[0];
                        }
                        echo "<p><b>Wychowawca:</b> ".$wychowawca."</p>";
                        echo "<h3>Podsumowanie klasyfikacji śródrocznej</h3><br>";

                        echo "<table><tr><td class='srodek'><b>Liczba uczniów</b></td><td>";
                        $zapytanie2="SELECT count(*) as ilu FROM `uczniowie` where id_klasy=$id_klasy;";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            $ilu_uczniow=$row2[0];
                        }
                        echo $ilu_uczniow;
                        echo "</td></tr></table><br>";

                        echo "<table><tr><td colspan='2' class='srodek'><b>Liczba uczniów wg ocen</b></td></tr>";
                        $zapytanie3="SELECT count(DISTINCT o.id_ucznia) as ile FROM `oceny` o 
                        inner join uczniowie u on o.id_ucznia=u.id_ucznia 
                        where o.ocena=1 and o.id_kategorii=8 and u.id_klasy=$id_klasy;";
                        $wyslij3=mysqli_query($polaczenie,$zapytanie3);  
                        while($row3=mysqli_fetch_array($wyslij3)){
                            $ilu_uczniow1=$row3[0];
                        }

                        $zapytanie4="SELECT count(o.id_ucznia) as ile FROM `oceny` o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.ocena like 0.01 and o.id_kategorii=8 and u.id_klasy=$id_klasy;";
                        $wyslij4=mysqli_query($polaczenie,$zapytanie4);  
                        while($row4=mysqli_fetch_array($wyslij4)){
                            $ilu_z_nk=$row4[0];
                        }

                        $oblicz_ilu_bez1=$ilu_uczniow-$ilu_uczniow1-$ilu_z_nk;
                        echo "<tr><td>bez ocen niedostatecznych</td><td>".$oblicz_ilu_bez1."</td>";
                        echo "<tr><td>z ocenami niedostatecznymi</td><td>".$ilu_uczniow1."</td>";
                    
                        echo "<tr><td>nieklasyfikowanych</td><td>".$ilu_z_nk."</td></table><br>";

                        $zapytanie5="SELECT concat(u.nazwisko_ucznia, ' ',u.imie_ucznia) as uczen, p.nazwa_przedmiotu as przedmiot FROM `oceny` o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu where round(o.ocena,2)= 0.01 and o.id_kategorii=8 and u.id_klasy=$id_klasy;";
                        $wyslij5=mysqli_query($polaczenie,$zapytanie5);  

                        if ($wyslij5->num_rows>0){
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną nieklasyfikowany</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            $x=1;
                            while($row5=mysqli_fetch_array($wyslij5)){
                                echo "<td>".$x++."</td><td>".$row5[0]."</td><td>".$row5[1]."</td></tr>";
                            }
                            echo "</table><br>";
                        }else{
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną nieklasyfikowany</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            echo "<tr><td class='srodek' colspan='3'>Brak</td></tr></table><br>";
                        }
                        $zapytanie6="SELECT concat(u.nazwisko_ucznia, ' ',u.imie_ucznia) as uczen, p.nazwa_przedmiotu as przedmiot FROM `oceny` o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu where o.ocena= 1 and o.id_kategorii=8 and u.id_klasy=$id_klasy;";
                        $wyslij6=mysqli_query($polaczenie,$zapytanie6);  

                        if ($wyslij6->num_rows>0){
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną niedostateczny</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            $x=1;
                            while($row6=mysqli_fetch_array($wyslij6)){
                                echo "<td>".$x++."</td><td>".$row6[0]."</td><td>".$row6[1]."</td></tr>";
                            }
                            echo "</table><br>";
                        }else{
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną niedostateczny</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            echo "<tr><td class='srodek' colspan='3'>Brak</td></tr></table><br>";
                        }

                        $zapytanie7="SELECT concat(u.nazwisko_ucznia, ' ',u.imie_ucznia) as uczen, p.nazwa_przedmiotu as przedmiot FROM `oceny` o inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu where o.ocena= 0.02 and o.id_kategorii=8 and u.id_klasy=$id_klasy;";
                        $wyslij7=mysqli_query($polaczenie,$zapytanie7);  

                        if ($wyslij7->num_rows>0){
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną zwolniony</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            $x=1;
                            while($row7=mysqli_fetch_array($wyslij7)){
                                echo "<td>".$x++."</td><td>".$row7[0]."</td><td>".$row7[1]."</td></tr>";
                            }
                            echo "</table><br>";
                        }

                        $zapytanie8="SELECT round(avg(o.ocena),2) as srednia from oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia WHERE id_kategorii=8 and id_klasy=$id_klasy;";
                        $wyslij8=mysqli_query($polaczenie,$zapytanie8);
                        while($row8=mysqli_fetch_array($wyslij8)){
                            $srednia=$row8[0];
                        }
                        echo "<table><tr><td class='srodek'><b>Średnia klasy</b></td><td>".$srednia."</td></tr></table><br>";


                        $zapytanie9="SELECT concat(u.nazwisko_ucznia, ' ', u.imie_ucznia) as uczen, round(avg(o.ocena),2) as srednia, z.ocena as zachowanie from oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia left OUTER JOIN oceny_zachowanie z on o.id_ucznia=z.id_ucznia WHERE o.id_kategorii=8 and id_klasy=$id_klasy group by uczen having srednia>=4.5;";
                        $wyslij9=mysqli_query($polaczenie,$zapytanie9);
                        if ($wyslij9->num_rows>0){
                            echo "<table><tr><td colspan='4' class='srodek'><b>Uczniowie ze średnią co najmniej 4,50</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>Nazwisko i imię ucznia</b></td><td><b>Średnia</b></td><td><b>Zachowanie</b></td></tr>";

                            $x=1;

                            while($row9=mysqli_fetch_array($wyslij9)){
                                echo "<td>".$x++."</td><td>".$row9[0]."</td><td>".$row9[1]."</td><td>";
                                if($row9[2]==6){
                                    echo "wzorowe";
                                }else if($row9[2]==5){
                                    echo "bardzo dobre";
                                }else if($row9[2]==4){
                                    echo "dobre";
                                }else if($row9[2]==3){
                                    echo "poprawne";
                                }else if($row9[2]==2){
                                    echo "nieodpowiednie";
                                }else if($row9[2]==1){
                                    echo "naganne";
                                }else{
                                    echo $row9[2];
                                }
                                
                                
                                echo"</td></tr>";
                            }
                            echo "</table><br>";
                        }
                        $zapytanie10="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=8 and o.ocena=6 and u.id_klasy=$id_klasy;";
                        $wyslij10=mysqli_query($polaczenie,$zapytanie10);
                        while($row10=mysqli_fetch_array($wyslij10)){
                            $wz=$row10[0];
                        }
    
                        $zapytanie11="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=8 and o.ocena=5 and u.id_klasy=$id_klasy;";
                        $wyslij11=mysqli_query($polaczenie,$zapytanie11);
                        while($row11=mysqli_fetch_array($wyslij11)){
                            $bdb=$row11[0];
                        }
                        $zapytanie12="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=8 and o.ocena=4 and u.id_klasy=$id_klasy;";
                        $wyslij12=mysqli_query($polaczenie,$zapytanie12);
                        while($row12=mysqli_fetch_array($wyslij12)){
                            $db=$row12[0];
                        }
                        $zapytanie13="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=8 and o.ocena=3 and u.id_klasy=$id_klasy;";
                        $wyslij13=mysqli_query($polaczenie,$zapytanie13);
                        while($row13=mysqli_fetch_array($wyslij13)){
                            $pop=$row13[0];
                        }
                        $zapytanie14="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=8 and o.ocena=2 and u.id_klasy=$id_klasy;";
                        $wyslij14=mysqli_query($polaczenie,$zapytanie14);
                        while($row14=mysqli_fetch_array($wyslij14)){
                            $nieodp=$row14[0];
                        }
                        $zapytanie15="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=8 and o.ocena=1 and u.id_klasy=$id_klasy;";
                        $wyslij15=mysqli_query($polaczenie,$zapytanie15);
                        while($row15=mysqli_fetch_array($wyslij15)){
                            $ng=$row15[0];
                        }
                        echo "<table><tr><td class='srodek' colspan='2'><b>Liczby uczniów wg ocen zachowania</b></td></tr>";
                        echo "<tr><td><b>z oceną wzorową</b></td><td>$wz</td></tr>";
                        echo "<tr><td><b>z oceną bardzo dobrą</b></td><td>$bdb</td></tr>";
                        echo "<tr><td><b>z oceną dobrą </b></td><td>$db</td></tr>";
                        echo "<tr><td><b>z oceną poprawną</b></td><td>$pop</td></tr>";
                        echo "<tr><td><b>z oceną nieodpowiednią</b></td><td>$nieodp</td></tr>";
                        echo "<tr><td><b>z oceną naganną</b></td><td>$ng</td></tr></table><br>";

                        $zapytanie16="SELECT concat(u.nazwisko_ucznia, ' ', u.imie_ucznia) as uczen from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=8 and o.ocena=1 and u.id_klasy=$id_klasy;";
                        $wyslij16=mysqli_query($polaczenie,$zapytanie16);  

                        
                            echo "<table><tr><td colspan='4' class='srodek'><b>Uczniowie z naganną oceną z zachowania</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>Nazwisko i imię ucznia</b></td><td><b>Średnia</b></td><td><b>Zachowanie</b></td></tr>";
                        if ($wyslij16->num_rows>0){
                            
                        
                            $x=1;

                            while($row16=mysqli_fetch_array($wyslij16)){
                                echo "<td>".$x++."</td><td>".$row16[0]."</td><td>".$row16[1]."</td><td>";
                                if($row16[2]==6){
                                    echo "wzorowe";
                                }else if($row16[2]==5){
                                    echo "bardzo dobre";
                                }else if($row16[2]==4){
                                    echo "dobre";
                                }else if($row16[2]==3){
                                    echo "poprawne";
                                }else if($row16[2]==2){
                                    echo "nieodpowiednie";
                                }else if($row16[2]==1){
                                    echo "naganne";
                                }else{
                                    echo $row16[2];
                                }

                                echo"</td></tr>";
                            }
                            
                            echo "</table><br>";
                        }else{
                            echo "<tr><td class='srodek' colspan='4'>Brak</td></tr></table><br>";
                        }

                        $zapytanie17="SELECT f.id_ucznia, concat(u.nazwisko_ucznia,' ',u.imie_ucznia) as uczen, k.nazwa_klasy as klasa, SUM(CASE WHEN typ_ob IN ('ob', 'zw', 'sp') THEN 1 ELSE 0 END) AS obecne, SUM(CASE WHEN typ_ob IN ('nb', 'u') THEN 1 ELSE 0 END) AS nieobecne, SUM(CASE WHEN typ_ob = 'u' THEN 1 ELSE 0 END) AS usprawiedliwione, SUM(CASE WHEN typ_ob = 'zw' THEN 1 ELSE 0 END) AS zwolnione, SUM(CASE WHEN typ_ob = 'sp' THEN 1 ELSE 0 END) AS spoznione, (SUM(CASE WHEN typ_ob IN ('ob', 'zw', 'sp') THEN 1 ELSE 0 END) / (SUM(CASE WHEN typ_ob IN ('ob', 'zw', 'sp') THEN 1 ELSE 0 END) + SUM(CASE WHEN typ_ob IN ('nb', 'u') THEN 1 ELSE 0 END))) * 100 AS frekwencja_procentowo FROM frekwencja f inner join uczniowie u on u.id_ucznia=f.id_ucznia inner join klasy k on k.id_klasy=u.id_klasy where f.semestr=1 and u.id_klasy= $id_klasy GROUP BY f.id_ucznia HAVING frekwencja_procentowo > 99.99;";
                        $wyslij17=mysqli_query($polaczenie,$zapytanie17);

                        echo "<table><tr><td colspan='4' class='srodek'><b>Uczniowie z frekwencją powyżej 99,99%</b></td></tr>";
                        echo "<tr><td><b>lp.</b></td><td><b>Nazwisko i imię ucznia</b></td><td><b>Frekwencja</b></td><td><b>Zachowanie</b></td></tr>";
                        if ($wyslij17->num_rows>0){
                            $x=1;
                            while($row17=mysqli_fetch_array($wyslij17)){
                                echo "<td>".$x++."</td><td>".$row17[1]."</td><td>100%</td><td>";
                                

                                echo"</td></tr>";
                            }
                            
                            echo "</table><br>";
                        }else{
                            echo "<tr><td class='srodek' colspan='4'>Brak</td></tr></table><br>"; 
                        }

                        $zapytanie18="SELECT count(*) from frekwencja f inner join uczniowie u on u.id_ucznia=f.id_ucznia where f.typ_ob in('ob','zw','sp') and semestr=1  and u.id_klasy=$id_klasy;";

                        $wyslij18=mysqli_query($polaczenie,$zapytanie18);
                        while($row18=mysqli_fetch_array($wyslij18)){
                            $obecnosc=$row18[0];
                        }
                        
                        $zapytanie19="SELECT count(*) from frekwencja f inner join uczniowie u on u.id_ucznia=f.id_ucznia where f.typ_ob in('nb','u') and semestr=1  and u.id_klasy=$id_klasy;";
                        $wyslij19=mysqli_query($polaczenie,$zapytanie19);
                        while($row19=mysqli_fetch_array($wyslij19)){
                            $nieobecnosc=$row19[0];
                        }

                        if($nieobecnosc+$obecnosc==0){
                            $frekwencja=0;
                        }else{
                            $frekwencja=round(($obecnosc/($nieobecnosc+$obecnosc)*100),2);
                        }
                        
                        echo "<table><tr><td class='srodek'><b>Frekwencja klasy</b></td><td>".$frekwencja."%</td></tr></table><br>";


                    }
                    if($okres=='roczna'){
                        
                        require "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                        echo "<p><b>Klasa:</b> ".$_POST['klasy']."</p>";
                        $zapytanie="SELECT id_klasy from klasy where skrot_klasy='".$_POST['klasy']."';";
                        $wyslij=mysqli_query($polaczenie,$zapytanie);  
                        while($row=mysqli_fetch_array($wyslij)){
                            $id_klasy=$row[0];
                        }
                        $zapytanie1="SELECT concat(n.nazwisko,' ',n.imie) as nauczyciel FROM klasy k 
                        inner join nauczyciele n on k.id_nauczyciela=n.id_nauczyciela where 
                        id_klasy=$id_klasy;";

                        $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                        while($row1=mysqli_fetch_array($wyslij1)){
                            $wychowawca=$row1[0];
                        }
                        echo "<p><b>Wychowawca:</b> ".$wychowawca."</p>";
                        echo "<h3>Podsumowanie klasyfikacji rocznej</h3><br>";

                        echo "<table><tr><td class='srodek'><b>Liczba uczniów</b></td><td>";
                        $zapytanie2="SELECT count(*) as ilu FROM `uczniowie` where id_klasy=$id_klasy;";
                        $wyslij2=mysqli_query($polaczenie,$zapytanie2);  
                        while($row2=mysqli_fetch_array($wyslij2)){
                            $ilu_uczniow=$row2[0];
                        }
                        echo $ilu_uczniow;
                        echo "</td></tr></table><br>";

                        echo "<table><tr><td colspan='2' class='srodek'><b>Liczba uczniów wg ocen</b></td></tr>";
                        $zapytanie3="SELECT count(DISTINCT o.id_ucznia) as ile FROM `oceny` o 
                        inner join uczniowie u on o.id_ucznia=u.id_ucznia 
                        where o.ocena=1 and o.id_kategorii=7 and u.id_klasy=$id_klasy;";
                        $wyslij3=mysqli_query($polaczenie,$zapytanie3);  
                        while($row3=mysqli_fetch_array($wyslij3)){
                            $ilu_uczniow1=$row3[0];
                        }

                        $zapytanie4="SELECT count(o.id_ucznia) as ile FROM `oceny` o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.ocena like 0.01 and o.id_kategorii=7 and u.id_klasy=$id_klasy;";
                        $wyslij4=mysqli_query($polaczenie,$zapytanie4);  
                        while($row4=mysqli_fetch_array($wyslij4)){
                            $ilu_z_nk=$row4[0];
                        }

                        $oblicz_ilu_bez1=$ilu_uczniow-$ilu_uczniow1-$ilu_z_nk;
                        echo "<tr><td>bez ocen niedostatecznych</td><td>".$oblicz_ilu_bez1."</td>";
                        echo "<tr><td>z ocenami niedostatecznymi</td><td>".$ilu_uczniow1."</td>";
                    
                        echo "<tr><td>nieklasyfikowanych</td><td>".$ilu_z_nk."</td></table><br>";

                        $zapytanie5="SELECT concat(u.nazwisko_ucznia, ' ',u.imie_ucznia) as uczen, p.nazwa_przedmiotu as przedmiot FROM `oceny` o inner join uczniowie u on o.id_ucznia=u.id_ucznia 
                        inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu where round(o.ocena,2)= 0.01 and o.id_kategorii=7 and u.id_klasy=$id_klasy;";
                        $wyslij5=mysqli_query($polaczenie,$zapytanie5);  

                        if ($wyslij5->num_rows>0){
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną nieklasyfikowany</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            $x=1;
                            while($row5=mysqli_fetch_array($wyslij5)){
                                echo "<td>".$x++."</td><td>".$row5[0]."</td><td>".$row5[1]."</td></tr>";
                            }
                            echo "</table><br>";
                        }else{
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną nieklasyfikowany</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            echo "<tr><td class='srodek' colspan='3'>Brak</td></tr></table><br>";
                        }
                        $zapytanie6="SELECT concat(u.nazwisko_ucznia, ' ',u.imie_ucznia) as uczen, p.nazwa_przedmiotu as przedmiot FROM `oceny` o 
                        inner join uczniowie u on o.id_ucznia=u.id_ucznia inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu where o.ocena= 1 and o.id_kategorii=7 and u.id_klasy=$id_klasy;";
                        $wyslij6=mysqli_query($polaczenie,$zapytanie6);  

                        if ($wyslij6->num_rows>0){
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną niedostateczny</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            $x=1;
                            while($row6=mysqli_fetch_array($wyslij6)){
                                echo "<td>".$x++."</td><td>".$row6[0]."</td><td>".$row6[1]."</td></tr>";
                            }
                            echo "</table><br>";
                        }else{
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną niedostateczny</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            echo "<tr><td class='srodek' colspan='3'>Brak</td></tr></table><br>";
                        }

                        $zapytanie7="SELECT concat(u.nazwisko_ucznia, ' ',u.imie_ucznia) as uczen, p.nazwa_przedmiotu as przedmiot FROM `oceny` o inner join uczniowie u on o.id_ucznia=u.id_ucznia 
                        inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu where o.ocena= 0.02 and o.id_kategorii=7 and u.id_klasy=$id_klasy;";
                        $wyslij7=mysqli_query($polaczenie,$zapytanie7);  

                        if ($wyslij7->num_rows>0){
                            echo "<table><tr><td colspan='3' class='srodek'><b>Uczniowie z oceną zwolniony</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>nazwisko i imię ucznia</b></td><td><b>przedmiot</b></td></tr>";
                            $x=1;
                            while($row7=mysqli_fetch_array($wyslij7)){
                                echo "<td>".$x++."</td><td>".$row7[0]."</td><td>".$row7[1]."</td></tr>";
                            }
                            echo "</table><br>";
                        }

                        $zapytanie8="SELECT round(avg(o.ocena),2) as srednia from oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia WHERE id_kategorii=7 and id_klasy=$id_klasy;";
                        $wyslij8=mysqli_query($polaczenie,$zapytanie8);
                        while($row8=mysqli_fetch_array($wyslij8)){
                            $srednia=$row8[0];
                        }
                        echo "<table><tr><td class='srodek'><b>Średnia klasy</b></td><td>".$srednia."</td></tr></table><br>";


                        $zapytanie9="SELECT concat(u.nazwisko_ucznia, ' ', u.imie_ucznia) as uczen, round(avg(o.ocena),2) as srednia, z.ocena as zachowanie from oceny o 
                        inner join uczniowie u on o.id_ucznia=u.id_ucznia left OUTER JOIN oceny_zachowanie z on o.id_ucznia=z.id_ucznia WHERE o.id_kategorii=7 and id_klasy=$id_klasy 
                        group by uczen having srednia>=4.5;";
                        $wyslij9=mysqli_query($polaczenie,$zapytanie9);
                        if ($wyslij9->num_rows>0){
                            echo "<table><tr><td colspan='4' class='srodek'><b>Uczniowie ze średnią co najmniej 4,50</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>Nazwisko i imię ucznia</b></td><td><b>Średnia</b></td><td><b>Zachowanie</b></td></tr>";

                            $x=1;

                            while($row9=mysqli_fetch_array($wyslij9)){
                                echo "<td>".$x++."</td><td>".$row9[0]."</td><td>".$row9[1]."</td><td>";
                                if($row9[2]==6){
                                    echo "wzorowe";
                                }else if($row9[2]==5){
                                    echo "bardzo dobre";
                                }else if($row9[2]==4){
                                    echo "dobre";
                                }else if($row9[2]==3){
                                    echo "poprawne";
                                }else if($row9[2]==2){
                                    echo "nieodpowiednie";
                                }else if($row9[2]==1){
                                    echo "naganne";
                                }else{
                                    echo $row9[2];
                                }
                                
                                
                                echo"</td></tr>";
                            }
                            echo "</table><br>";
                        }
                        $zapytanie10="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=7 and o.ocena=6 and u.id_klasy=$id_klasy;";
                        $wyslij10=mysqli_query($polaczenie,$zapytanie10);
                        while($row10=mysqli_fetch_array($wyslij10)){
                            $wz=$row10[0];
                        }
    
                        $zapytanie11="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=7 and o.ocena=5 and u.id_klasy=$id_klasy;";
                        $wyslij11=mysqli_query($polaczenie,$zapytanie11);
                        while($row11=mysqli_fetch_array($wyslij11)){
                            $bdb=$row11[0];
                        }
                        $zapytanie12="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=7 and o.ocena=4 and u.id_klasy=$id_klasy;";
                        $wyslij12=mysqli_query($polaczenie,$zapytanie12);
                        while($row12=mysqli_fetch_array($wyslij12)){
                            $db=$row12[0];
                        }
                        $zapytanie13="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=7 and o.ocena=3 and u.id_klasy=$id_klasy;";
                        $wyslij13=mysqli_query($polaczenie,$zapytanie13);
                        while($row13=mysqli_fetch_array($wyslij13)){
                            $pop=$row13[0];
                        }
                        $zapytanie14="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=7 and o.ocena=2 and u.id_klasy=$id_klasy;";
                        $wyslij14=mysqli_query($polaczenie,$zapytanie14);
                        while($row14=mysqli_fetch_array($wyslij14)){
                            $nieodp=$row14[0];
                        }
                        $zapytanie15="SELECT count(o.id_ucznia) as ilu from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=7 and o.ocena=1 and u.id_klasy=$id_klasy;";
                        $wyslij15=mysqli_query($polaczenie,$zapytanie15);
                        while($row15=mysqli_fetch_array($wyslij15)){
                            $ng=$row15[0];
                        }
                        echo "<table><tr><td class='srodek' colspan='2'><b>Liczby uczniów wg ocen zachowania</b></td></tr>";
                        echo "<tr><td><b>z oceną wzorową</b></td><td>$wz</td></tr>";
                        echo "<tr><td><b>z oceną bardzo dobrą</b></td><td>$bdb</td></tr>";
                        echo "<tr><td><b>z oceną dobrą </b></td><td>$db</td></tr>";
                        echo "<tr><td><b>z oceną poprawną</b></td><td>$pop</td></tr>";
                        echo "<tr><td><b>z oceną nieodpowiednią</b></td><td>$nieodp</td></tr>";
                        echo "<tr><td><b>z oceną naganną</b></td><td>$ng</td></tr></table><br>";

                        $zapytanie16="SELECT concat(u.nazwisko_ucznia, ' ', u.imie_ucznia) as uczen from oceny_zachowanie o inner join uczniowie u on o.id_ucznia=u.id_ucznia where o.id_kategorii=7 
                        and o.ocena=1 and u.id_klasy=$id_klasy;";
                        $wyslij16=mysqli_query($polaczenie,$zapytanie16);  

                        
                            echo "<table><tr><td colspan='4' class='srodek'><b>Uczniowie z naganną oceną z zachowania</b></td></tr>";
                            echo "<tr><td><b>lp.</b></td><td><b>Nazwisko i imię ucznia</b></td><td><b>Średnia</b></td><td><b>Zachowanie</b></td></tr>";
                        if ($wyslij16->num_rows>0){
                            
                        
                            $x=1;

                            while($row16=mysqli_fetch_array($wyslij16)){
                                echo "<td>".$x++."</td><td>".$row16[0]."</td><td>".$row16[1]."</td><td>";
                                if($row16[2]==6){
                                    echo "wzorowe";
                                }else if($row16[2]==5){
                                    echo "bardzo dobre";
                                }else if($row16[2]==4){
                                    echo "dobre";
                                }else if($row16[2]==3){
                                    echo "poprawne";
                                }else if($row16[2]==2){
                                    echo "nieodpowiednie";
                                }else if($row16[2]==1){
                                    echo "naganne";
                                }else{
                                    echo $row16[2];
                                }

                                echo"</td></tr>";
                            }
                            
                            echo "</table><br>";
                        }else{
                            echo "<tr><td class='srodek' colspan='4'>Brak</td></tr></table><br>";
                        }

                        $zapytanie17="SELECT f.id_ucznia, concat(u.nazwisko_ucznia,' ',u.imie_ucznia) as uczen, k.nazwa_klasy as klasa, SUM(CASE WHEN typ_ob IN ('ob', 'zw', 'sp') THEN 1 ELSE 0 END) AS obecne, SUM(CASE WHEN typ_ob IN ('nb', 'u') THEN 1 ELSE 0 END) AS nieobecne, SUM(CASE WHEN typ_ob = 'u' THEN 1 ELSE 0 END) AS usprawiedliwione, SUM(CASE WHEN typ_ob = 'zw' THEN 1 ELSE 0 END) AS zwolnione, SUM(CASE WHEN typ_ob = 'sp' THEN 1 ELSE 0 END) AS spoznione, (SUM(CASE WHEN typ_ob IN ('ob', 'zw', 'sp') THEN 1 ELSE 0 END) / (SUM(CASE WHEN typ_ob IN ('ob', 'zw', 'sp') THEN 1 ELSE 0 END) + SUM(CASE WHEN typ_ob IN ('nb', 'u') THEN 1 ELSE 0 END))) * 100 AS frekwencja_procentowo FROM frekwencja f inner join uczniowie u on u.id_ucznia=f.id_ucznia inner join klasy k on k.id_klasy=u.id_klasy where f.semestr=2 and u.id_klasy= $id_klasy GROUP BY f.id_ucznia HAVING frekwencja_procentowo > 99.99;";
                        $wyslij17=mysqli_query($polaczenie,$zapytanie17);

                        echo "<table><tr><td colspan='4' class='srodek'><b>Uczniowie z frekwencją powyżej 99,99%</b></td></tr>";
                        echo "<tr><td><b>lp.</b></td><td><b>Nazwisko i imię ucznia</b></td><td><b>Frekwencja</b></td><td><b>Zachowanie</b></td></tr>";
                        if ($wyslij17->num_rows>0){
                            $x=1;
                            while($row17=mysqli_fetch_array($wyslij17)){
                                echo "<td>".$x++."</td><td>".$row17[1]."</td><td>100%</td><td>";
                              

                                echo"</td></tr>";
                            }
                            
                            echo "</table><br>";
                        }else{
                            echo "<tr><td class='srodek' colspan='4'>Brak</td></tr></table><br>"; 
                        }

                        $zapytanie18="SELECT count(*) from frekwencja f inner join uczniowie u on u.id_ucznia=f.id_ucznia where f.typ_ob in('ob','zw','sp') and u.id_klasy=$id_klasy;";
                        $wyslij18=mysqli_query($polaczenie,$zapytanie18);
                        while($row18=mysqli_fetch_array($wyslij18)){
                            $obecnosc=$row18[0];
                        }
                        
                        $zapytanie19="SELECT count(*) from frekwencja f inner join uczniowie u on u.id_ucznia=f.id_ucznia where f.typ_ob in('nb','u') and u.id_klasy=$id_klasy;";
                        $wyslij19=mysqli_query($polaczenie,$zapytanie19);
                        while($row19=mysqli_fetch_array($wyslij19)){
                            $nieobecnosc=$row19[0];
                        }

                        if($nieobecnosc+$obecnosc==0){
                            $frekwencja=0;
                        }else{
                            $frekwencja=round(($obecnosc/($nieobecnosc+$obecnosc)*100),2);
                        }
                        
                        echo "<table><tr><td class='srodek'><b>Frekwencja klasy</b></td><td>".$frekwencja."%</td></tr></table><br>";


                    }
    
                    
                ?>
            
           
        </div>

        <div id="stopka">
            
        </div>
    </div>

</div>
</div>
</body>
</html>