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
    <title>Strona główna</title>
    <link rel="stylesheet" href="styl2.css">

</head>
<body>
    <div id="kontener">
                <div id="glowny1">
                    <p style='text-align: right'>
                        <?php
                            $login=$_SESSION['login'];

                            require "connect.php";

                            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                            $zapytanie="SELECT DISTINCT concat(nazwisko, ' ', imie) as nauczyciel FROM `nauczyciele` where login='$login';";
                            $wyslij=mysqli_query($polaczenie,$zapytanie);
                            while($row=mysqli_fetch_array($wyslij)){
                                echo "Zalogowany jako: <b>".$row[0]."</b>! &nbsp<br>";
                                $_SESSION['nauczyciel']=$row[0];
                            }
                        
                        ?>   
                    </p>
            <p id='baner'>DZIENNIK ELEKTRONICZNY</p>

        </div>
        <div id="menu">
               
        <?php
            echo '<a href="\dziennik_lekcyjny\moje_przedmioty.php">Interfejs lekcyjny</a>';
                
        ?>
        <div id="zawijaj">
                <a>Widok dziennika</a>
                    <ul>
                    <?php
                        if($_SESSION['admin'] ==0){
                        echo <<<END
                        <li><a href="\dziennik_lekcyjny\oceny_klasa.php">Oceny w klasach</a></li>
                        END;
                        }else{
                            echo <<<END
                                <li><a href="\dziennik_lekcyjny\widok_ocen_admin.php">Oceny w klasach</a></li>
                            END;
                        }
                        ?>
                        <li><a href="\dziennik_lekcyjny\podglad_samorzady.php">Samorządy klasowe</a></li>
                        <li><a href="\dziennik_lekcyjny\podglad_oceny_uczniow.php">Kartoteka ucznia</a></li>
                        <li><a href="\dziennik_lekcyjny\zastepstwa.php">Zastępstwa</a></li>
                        <li><a href="\dziennik_lekcyjny\plan.php">Plan lekcji</a></li>
                    </ul>
            </div>
            <?php
                if(isset($_SESSION['wych'])){
                    echo '<a href="\dziennik_lekcyjny\frekwencja.php">Widok wychowawcy</a>';
                }
            ?>      
            <?php
            if($_SESSION['admin'] ==1){
                echo <<<END
            <div id="zawijaj">
                <a>Panel admina</a>
                <ul>
                    <li><a href="\dziennik_lekcyjny\dodaj_nauczyciel.php" onclick="window.open('dodaj_nauczyciel.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=405').focus(); return false">Dodaj nauczyciela</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_klasa.php" onclick="window.open('dodaj_klasa.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=250').focus(); return false">Dodaj klase</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_przedmiot.php" onclick="window.open('dodaj_przedmiot.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=250').focus(); return false" >Dodaj przedmiot</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_uczen.php" onclick="window.open('dodaj_uczen.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=250').focus(); return false" >Dodaj ucznia</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_przydzial.php" onclick="window.open('dodaj_przydzial.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=325,height=230').focus(); return false" >Dodaj przydział</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_kategorie.php" onclick="window.open('dodaj_kategorie.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=325,height=270').focus(); return false" >Dodaj kategorie</a></li>
                    <li><a href="\dziennik_lekcyjny\semestry.php">Trwanie semestrów</a></li>
                    <li><a href="\dziennik_lekcyjny\widok_ocen_admin.php">Modyfikacja ocen uczniów</a></li>
                    <li><a href="/dziennik_lekcyjny/nauczane_klasy.php">Przydziały</a></li>
                    <li><a href="\dziennik_lekcyjny\zastepstwa.php">Zastępstwa</a></li>
                    <li><a href="\dziennik_lekcyjny\zaleglosci.php">Zaległości</a></li>
                </ul>
            </div>
            END;
            }
            ?>
            
            <?php
            if($_SESSION['admin'] ==1){
                echo <<<END
            <div id="zawijaj">
                <a>Wirtualne klasy</a>
                <ul>
                    <li><a href="\dziennik_lekcyjny\podglad_uczniowie_wirtualna.php">Klasy wirtualne i uczniowie</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_wirt_klasa.php" onclick="window.open('dodaj_wirt_klasa.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=550,height=450').focus(); return false">Dodaj wirtualną klase</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_dowirt.php" onclick="window.open('dodaj_dowirt.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=250').focus(); return false">Dodaj ucznia do wirtualnej klasy</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_przydzial.php" onclick="window.open('dodaj_przydzial.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=325,height=230').focus(); return false" >Dodaj przydział do klasy</a></li> 
                    <li><a href="/dziennik_lekcyjny/nauczane_klasy.php">Przydziały</a></li>
                    </ul>
            </div>
            END;
            }
            ?>
            <!--
            <div id="zawijaj">
                <a>Ocenianie</a>
                <ul>
                    
                    <li><a href="\dziennik_lekcyjny\dodaj_uwage.php" onclick="window.open('dodaj_uwage.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=400').focus(); return false">Dodaj uwagę</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_zachowanie.php" onclick="window.open('dodaj_zachowanie.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=400').focus(); return false">Ocena klasyf. z zach.</a></li>

                    <li><a href="\dziennik_lekcyjny\podglad_zachowanie.php">Podgląd uwag uczniów</a></li>
                    <li><a href="\dziennik_lekcyjny\podglad_zachowanie.php">Podgląd zachowania uczniów</a></li>
      
                </ul>
            </div>
        -->
            
            <div id="zawijaj">
                <a>Raporty</a>
                <ul>
                    <li><a href="\dziennik_lekcyjny\podglad_statystyki.php">Statystyki</a></li>
                    <li><a href="\dziennik_lekcyjny\zestawienie_klasyfikacyjne.php">Zestawienia klasyfikacyjne</a></li>
                </ul>
            </div>
            <a href="logout.php">Wyloguj</a>
        </div>
        

        <div id="glowny2">
            <?php
                $data= date('Y-m-d');
                $obecny_czas = time();
                $dzientyg = date('N', $obecny_czas);

            
                
                echo "<br><h2>Plan lekcji i realizacja programu nauczania</h2><table>";
                echo "<tr><td colspan='2' class='center'>Dzień:</td><td colspan='2' class='center'>";
                $d=mktime();
                
                $date=date("Y-m-d", $d);
                if(isset($_POST['data_za'])){
                    $dat=$_POST['data_za'];
                }else{
                    $dat=$date;
                }
                echo "<form action='' method='post'><input type='date' name='data_za' id='data_za' value='$dat'> <input type='submit' value='Wybierz'></form><br>";

                echo"</td></tr>";
                if(isset($_POST['data_za'])){
                    $data_wy=$_POST['data_za'];
    
                    $dzientyg = date('N', strtotime($data_wy));
                    
                    $sql="SELECT id_lekcji, nr_lekcji, dzien, k.skrot_klasy as klasa, concat(n.nazwisko, ' ',n.imie) as nauczyciel, p.nazwa_przedmiotu as przedmiot, sala, pl.id_przedmiotu, pl.id_klasy, k.nazwa_klasy as n_klasy FROM plan_lekcji pl inner join klasy k on k.id_klasy=pl.id_klasy inner join przedmioty p on p.id_przedmiotu=pl.id_przedmiotu inner join nauczyciele n on n.id_nauczyciela=pl.id_nauczyciela where '$data_wy' BETWEEN od and do and dzien=$dzientyg and n.login='$login' UNION 
                SELECT id as id_lekcji, nr_lekcji, CASE DAYOFWEEK(data) WHEN 1 THEN 7 ELSE DAYOFWEEK(data) - 1 END as dzien, k.skrot_klasy as klasa, concat(n.nazwisko, ' ',n.imie) as nauczyciel, p.nazwa_przedmiotu as przedmiot, sala, za.id_przedmiot, za.id_klasy, k.nazwa_klasy as n_klasy FROM zastepstwa za inner join klasy k on k.id_klasy=za.id_klasy inner join przedmioty p on p.id_przedmiotu=za.id_przedmiot inner join nauczyciele n on n.id_nauczyciela=za.id_nauczyciel where za.data='$data_wy' and CASE DAYOFWEEK(data) WHEN 1 THEN 7 ELSE DAYOFWEEK(data) - 1 END=$dzientyg and n.login='$login' and za.typ not in (8) order by nr_lekcji asc;";

                    $send=mysqli_query($polaczenie,$sql);
    
  
                    echo "<tr><th>Nr</th><th>Zajęcia edukacyjne</th><th>Status</th><th>Rozpocznij</th></tr>";
                    while($row=mysqli_fetch_array($send)){
                        /*if ($send->num_rows>0){*/
                            $sql2="SELECT za.nr_lekcji, kl.nazwa_klasy, pr.nazwa_przedmiotu, concat(na.nazwisko,' ',na.imie) as nauczyciel, za.sala, tz.nazwa, data FROM zastepstwa za inner join nauczyciele na on na.id_nauczyciela=za.id_nauczyciel inner join klasy kl on kl.id_klasy=za.id_klasy inner join przedmioty pr on pr.id_przedmiotu=za.id_przedmiot inner join typ_zastepstw tz on tz.id=za.typ where za.typ=8 and na.login='$login' and za.nr_lekcji=".$row['nr_lekcji']." and kl.skrot_klasy='".$row['klasa']."' and pr.nazwa_przedmiotu='".$row['przedmiot']."' and  za.nr_lekcji=".$row['nr_lekcji']." and data='$data_wy';";

                            $send2=mysqli_query($polaczenie,$sql2);
                            if ($send2->num_rows>0){
                                echo "<tr><td><s>".$row['nr_lekcji']."</s></td><td><s>".$row['n_klasy'].", ".$row['przedmiot']." </s>&nbsp<font style='background: #267F00; color: #ffffff;'> odwołane </font> &nbsp<s>s.".$row['sala']."</s></td>";
                            }else{
                                $sql3="SELECT za.nr_lekcji, kl.nazwa_klasy, pr.nazwa_przedmiotu, concat(na.nazwisko,' ',na.imie) as nauczyciel, za.sala, tz.nazwa, data FROM zastepstwa za inner join nauczyciele na on na.id_nauczyciela=za.id_nauczyciel inner join klasy kl on kl.id_klasy=za.id_klasy inner join przedmioty pr on pr.id_przedmiotu=za.id_przedmiot inner join typ_zastepstw tz on tz.id=za.typ where za.typ not in(8) and na.login='$login' and za.nr_lekcji=".$row['nr_lekcji']." and kl.skrot_klasy='".$row['klasa']."' and pr.nazwa_przedmiotu='".$row['przedmiot']."' and  za.nr_lekcji=".$row['nr_lekcji']." and data='$data_wy';";
                        
                                $send3=mysqli_query($polaczenie,$sql3);

                                if ($send3->num_rows>0){
                                    echo "<tr><td>".$row['nr_lekcji']."</td><td>".$row['n_klasy'].", ".$row['przedmiot']." &nbsp<font style='background: #267F00; color: #ffffff;'> zastępstwo </font> &nbsp s.".$row['sala']."</td>";
                                }else{
                                    $sql4="SELECT za.nr_lekcji, kl.nazwa_klasy, pr.nazwa_przedmiotu, concat(na.nazwisko,' ',na.imie) as nauczyciel, za.sala, tz.nazwa, data FROM zastepstwa za inner join nauczyciele na on na.id_nauczyciela=za.id_nauczyciel inner join klasy kl on kl.id_klasy=za.id_klasy inner join przedmioty pr on pr.id_przedmiotu=za.id_przedmiot inner join typ_zastepstw tz on tz.id=za.typ where za.typ in(7) and na.login='$login' and za.nr_lekcji=".$row['nr_lekcji']." and kl.skrot_klasy='".$row['klasa']."' and pr.nazwa_przedmiotu='".$row['przedmiot']."' and  za.nr_lekcji=".$row['nr_lekcji']." and data='$data_wy';";
                                    $send4=mysqli_query($polaczenie,$sql4);
                        
                                    if ($send4->num_rows>0){
                                        echo "<tr><td>".$row['nr_lekcji']."</td><td>".$row['n_klasy'].", ".$row['przedmiot']." &nbsp<font style='background: #267F00; color: #ffffff;'> przesunięcie </font> &nbsp s.".$row['sala']."</td>";
                                    }else{
                                        echo "<tr><td>".$row['nr_lekcji']."</td><td>".$row['n_klasy'].", ".$row['przedmiot']." s.".$row['sala']."</td>";
                                    }
                                }
                            }
                            $sql1="SELECT rp.id, rp.data, p.nazwa_przedmiotu, kl.skrot_klasy FROM realizacja_programu rp inner join klasy kl on rp.id_klasy=kl.id_klasy inner join przedmioty p on rp.id_przedmiot=p.id_przedmiotu where kl.skrot_klasy='".$row['klasa']."' and p.nazwa_przedmiotu='".$row['przedmiot']."' and rp.lekcja=".$row['nr_lekcji']." and data='$data_wy';";
                            $send1=mysqli_query($polaczenie,$sql1);
                            if ($send1->num_rows>0){
                        
                                echo "<td><img src='zdjecia/aktywne.png'></td>";
                            
                            }else{
                                echo "<td><img src='zdjecia/nieaktywne.png'></td>";
                            }
                        
                            $sql2="SELECT za.nr_lekcji, kl.nazwa_klasy, pr.nazwa_przedmiotu, concat(na.nazwisko,' ',na.imie) as nauczyciel, za.sala, tz.nazwa, data FROM zastepstwa za inner join nauczyciele na on na.id_nauczyciela=za.id_nauczyciel inner join klasy kl on kl.id_klasy=za.id_klasy inner join przedmioty pr on pr.id_przedmiotu=za.id_przedmiot inner join typ_zastepstw tz on tz.id=za.typ where za.typ=8 and na.login='$login' and za.nr_lekcji=".$row['nr_lekcji']." and kl.skrot_klasy='".$row['klasa']."' and pr.nazwa_przedmiotu='".$row['przedmiot']."' and  za.nr_lekcji=".$row['nr_lekcji']." and data='$data_wy';";
        
                            $send2=mysqli_query($polaczenie,$sql2);
                            if ($send2->num_rows>0){
                                echo"<td></td>";
                            }else{
                                echo "<td class='usuwanie'><form action='obecnosc.php' method='post'><input type='hidden' name='nr_lekcji' value='".$row['nr_lekcji']."'><input type='hidden' name='data_lekcji' value='".$data_wy."'><input type='hidden' name='klasa' value='".$row['klasa']."'><input type='hidden' name='id_klasy' value='".$row['id_klasy']."'><input type='hidden' name='nazwa_przedmiotu' value='".$row['przedmiot']."'><input type='hidden' name='id_przedmiot' value='".$row['id_przedmiotu']."'><input type='submit' name='usun' value='Wybierz'></form></td>";
                            }
                            echo"</tr>";
                        
                    }
                    if($send->num_rows<1){
                        echo"<tr><td colspan='4'>&nbsp</td></tr>";
                        echo "<tr><th colspan='4'>Brak zajęć w wybranym dniu</th></tr>";
                    }
                    echo "</table>";
                }else{

                   
                $sql="SELECT id_lekcji, nr_lekcji, dzien, k.skrot_klasy as klasa, concat(n.nazwisko, ' ',n.imie) as nauczyciel, p.nazwa_przedmiotu as przedmiot, sala, pl.id_przedmiotu, pl.id_klasy, k.nazwa_klasy as n_klasy FROM plan_lekcji pl inner join klasy k on k.id_klasy=pl.id_klasy inner join przedmioty p on p.id_przedmiotu=pl.id_przedmiotu inner join nauczyciele n on n.id_nauczyciela=pl.id_nauczyciela where '$date' BETWEEN od and do and dzien=$dzientyg and n.login='$login' UNION 
                SELECT id as id_lekcji, nr_lekcji, CASE DAYOFWEEK(data) WHEN 1 THEN 7 ELSE DAYOFWEEK(data) - 1 END as dzien, k.skrot_klasy as klasa, concat(n.nazwisko, ' ',n.imie) as nauczyciel, p.nazwa_przedmiotu as przedmiot, sala, za.id_przedmiot, za.id_klasy, k.nazwa_klasy as n_klasy FROM zastepstwa za inner join klasy k on k.id_klasy=za.id_klasy inner join przedmioty p on p.id_przedmiotu=za.id_przedmiot inner join nauczyciele n on n.id_nauczyciela=za.id_nauczyciel where za.data='$date' and CASE DAYOFWEEK(data) WHEN 1 THEN 7 ELSE DAYOFWEEK(data) - 1 END=$dzientyg and n.login='$login' and za.typ not in (8) order by nr_lekcji asc;";

                    
                $send=mysqli_query($polaczenie,$sql);



                echo "<tr><th>Nr</th><th>Zajęcia edukacyjne</th><th>Status</th><th>Rozpocznij</th></tr>";
                
                while($row=mysqli_fetch_array($send)){
                    
                    $sql2="SELECT za.nr_lekcji, kl.nazwa_klasy, pr.nazwa_przedmiotu, concat(na.nazwisko,' ',na.imie) as nauczyciel, za.sala, tz.nazwa, data FROM zastepstwa za inner join nauczyciele na on na.id_nauczyciela=za.id_nauczyciel inner join klasy kl on kl.id_klasy=za.id_klasy inner join przedmioty pr on pr.id_przedmiotu=za.id_przedmiot inner join typ_zastepstw tz on tz.id=za.typ where za.typ=8 and na.login='$login' and za.nr_lekcji=".$row['nr_lekcji']." and kl.skrot_klasy='".$row['klasa']."' and pr.nazwa_przedmiotu='".$row['przedmiot']."' and  za.nr_lekcji=".$row['nr_lekcji']." and data='$date';";
                    $send2=mysqli_query($polaczenie,$sql2);
                    if ($send2->num_rows>0){
                        echo "<tr><td><s>".$row['nr_lekcji']."</s></td><td><s>".$row['n_klasy'].", ".$row['przedmiot']." </s>&nbsp<font style='background: #267F00; color: #ffffff;'> odwołane </font> &nbsp<s>s.".$row['sala']."</s></td>";
                    }else{
                        $sql3="SELECT za.nr_lekcji, kl.nazwa_klasy, pr.nazwa_przedmiotu, concat(na.nazwisko,' ',na.imie) as nauczyciel, za.sala, tz.nazwa, data FROM zastepstwa za inner join nauczyciele na on na.id_nauczyciela=za.id_nauczyciel inner join klasy kl on kl.id_klasy=za.id_klasy inner join przedmioty pr on pr.id_przedmiotu=za.id_przedmiot inner join typ_zastepstw tz on tz.id=za.typ where za.typ not in(7,8) and na.login='$login' and za.nr_lekcji=".$row['nr_lekcji']." and kl.skrot_klasy='".$row['klasa']."' and pr.nazwa_przedmiotu='".$row['przedmiot']."' and  za.nr_lekcji=".$row['nr_lekcji']." and data='$date';";
                        $send3=mysqli_query($polaczenie,$sql3);

                        if ($send3->num_rows>0){
                            echo "<tr><td>".$row['nr_lekcji']."</td><td>".$row['n_klasy'].", ".$row['przedmiot']." &nbsp<font style='background: #267F00; color: #ffffff;'> zastępstwo </font> &nbsp s.".$row['sala']."</td>";
                        }else{                            
                                $sql4="SELECT za.nr_lekcji, kl.nazwa_klasy, pr.nazwa_przedmiotu, concat(na.nazwisko,' ',na.imie) as nauczyciel, za.sala, tz.nazwa, data FROM zastepstwa za inner join nauczyciele na on na.id_nauczyciela=za.id_nauczyciel inner join klasy kl on kl.id_klasy=za.id_klasy inner join przedmioty pr on pr.id_przedmiotu=za.id_przedmiot inner join typ_zastepstw tz on tz.id=za.typ where za.typ in(7) and na.login='$login' and za.nr_lekcji=".$row['nr_lekcji']." and kl.skrot_klasy='".$row['klasa']."' and pr.nazwa_przedmiotu='".$row['przedmiot']."' and  za.nr_lekcji=".$row['nr_lekcji']." and data='$date';";
                                $send4=mysqli_query($polaczenie,$sql4);
        
                                if ($send4->num_rows>0){
                                echo "<tr><td>".$row['nr_lekcji']."</td><td>".$row['n_klasy'].", ".$row['przedmiot']." &nbsp<font style='background: #267F00; color: #ffffff;'> przesunięcie </font> &nbsp s.".$row['sala']."</td>";
                                }else{
                                echo "<tr><td>".$row['nr_lekcji']."</td><td>".$row['n_klasy'].", ".$row['przedmiot']." s.".$row['sala']."</td>";
                                }
                            }
                    
                    }
                    $sql1="SELECT rp.id, rp.data, p.nazwa_przedmiotu, kl.skrot_klasy FROM realizacja_programu rp inner join klasy kl on rp.id_klasy=kl.id_klasy inner join przedmioty p on rp.id_przedmiot=p.id_przedmiotu where kl.skrot_klasy='".$row['klasa']."' and p.nazwa_przedmiotu='".$row['przedmiot']."' and rp.lekcja=".$row['nr_lekcji']." and data='$date';";
                    $send1=mysqli_query($polaczenie,$sql1);

                        if ($send1->num_rows>0){
                            echo "<td><img src='zdjecia/aktywne.png'></td>";
                        }else{
                            echo "<td><img src='zdjecia/nieaktywne.png'></td>";
                        }
                        
       
                        
                        if ($send2->num_rows>0){
                            echo"<td></td>";
                        }else{
                        echo "<td class='usuwanie'><form action='obecnosc.php' method='post'><input type='hidden' name='nr_lekcji' value='".$row['nr_lekcji']."'><input type='hidden' name='data_lekcji' value='".$date."'><input type='hidden' name='klasa' value='".$row['klasa']."'><input type='hidden' name='id_klasy' value='".$row['id_klasy']."'><input type='hidden' name='nazwa_przedmiotu' value='".$row['przedmiot']."'><input type='hidden' name='id_przedmiot' value='".$row['id_przedmiotu']."'><input type='submit' name='usun' value='Wybierz'></form></td>";
                        }
                    echo"</tr>";
                }
                if($send->num_rows<1){
                    echo"<tr><td colspan='4'>&nbsp</td></tr>";
                    echo "<tr><th colspan='4'>Brak zajęć w wybranym dniu</th></tr>";
                }
                echo "</table>";

            }
               /*echo "<br><h2>Zastępstwa</h2>";
                $d=mktime();
                
                $date=date("Y-m-d", $d);
                echo "<form action='' method='post'><input type='date' name='data_z' id='data_z' value='$date'> <input type='submit' value='Wybierz'></form><br>";

                if(isset($_POST['data_z'])){
                    $data_z=$_POST['data_z'];
                $zapytanie2="SELECT k.nazwa_klasy as klasa, p.nazwa_przedmiotu as przedmiot, data, nr_lekcji, z.id_klasy as id_klasy, z.id_przedmiot as 
                id_przedmiot, t.skrot as typ FROM zastepstwa z inner join klasy k on z.id_klasy=k.id_klasy inner join przedmioty p on p.id_przedmiotu=z.id_przedmiot 
                inner join nauczyciele n on n.id_nauczyciela=z.id_nauczyciel inner join typ_zastepstw t on t.id=z.typ where n.login='$login' and data='$data_z' order by z.nr_lekcji asc;";
                $wyslij2=mysqli_query($polaczenie,$zapytanie2);
                if ($wyslij2->num_rows>0){
                    
                echo "<table>
                <tr><th>lp.</th><th>przedmiot</th><th>klasa (grupa)</th><th>lekcja</th><th>typ</th><th>frekwencja</th></tr>
                ";
                $x=1;
                while($row2=mysqli_fetch_array($wyslij2)){
                    echo "<tr><td style='text-align: right;'>".$x++.".</td><td>".$row2[1]."</td><td>".$row2[0]."</td><td>".$row2['nr_lekcji']."</td><td>".$row2['typ']."</td>
                    
                    <td class='usuwanie'><form action='obecnosc.php' method='post'><input type='hidden' name='klasa' value='".$row2['klasa']."'><input type='hidden' name='id_klasy' value='".$row2['id_klasy']."'><input type='hidden' name='nazwa_przedmiotu' value='".$row2[1]."'><input type='hidden' name='id_przedmiot' value='".$row2['id_przedmiot']."'><input type='submit' name='usun' value='X'></form></td>
                    </tr>";
                }
                #<td class='usuwanie'><form action='widok_ocen.php' method='post'><input type='hidden' name='id_klasy' value='".$row2['id_klasy']."'><input type='hidden' name='id_przedmiot' value='".$row2['id_przedmiot']."'><input type='submit' name='usun' value='X'></form></td>
                echo "</table>";
            }else{
                    echo "Brak zastępstw";
                }
            
        }*/
            ?>
        </div>
        <div id="stopka">
            Stronę wykonał: Jakub Wierciński<br>
            &copy Wszelkie prawa zastrzeżone
        </div>
    </div>
</body>
</html>