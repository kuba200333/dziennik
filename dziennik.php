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
            <p>DZIENNIK ELEKTRONICZNY</p>
            <?php
            $login=$_SESSION['login'];

            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie="SELECT DISTINCT concat(nazwisko, ' ', imie) as nauczyciel FROM `nauczyciele` where login='$login';";
            $wyslij=mysqli_query($polaczenie,$zapytanie);
            while($row=mysqli_fetch_array($wyslij)){
                echo "Witaj <b>".$row[0]."</b>! <br>";
            }
             echo '<a href="logout.php">[ Wyloguj sie! ] </a>';
             ?>
        </div>
        <div id="menu">
        <?php
                if($_SESSION['login'] !='admin'){
                    echo '<a href="\dziennik_lekcyjny\moje_przedmioty.php">Interfejs lekcyjny</a>';
                }
                ?>
            <?php
            if($_SESSION['login']=='admin'){
                echo <<<END
            <div id="zawijaj">
                <a>Dane szkolne</a>
                <ul>
                    <li><a href="\dziennik_lekcyjny\dodaj_nauczyciel.php" onclick="window.open('dodaj_nauczyciel.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=330,height=405').focus(); return false">Dodaj nauczyciela</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_klasa.php" onclick="window.open('dodaj_klasa.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=250').focus(); return false">Dodaj klase</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_przedmiot.php" onclick="window.open('dodaj_przedmiot.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=250').focus(); return false" >Dodaj przedmiot</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_uczen.php" onclick="window.open('dodaj_uczen.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=250').focus(); return false" >Dodaj ucznia</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_przydzial.php" onclick="window.open('dodaj_przydzial.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=325,height=230').focus(); return false" >Dodaj przydział</a></li>
                    <li><a href="\dziennik_lekcyjny\usun_przydzial.php" onclick="window.open('usun_przydzial.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=315,height=225').focus(); return false" >Usuń przydział</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_kategorie.php" onclick="window.open('dodaj_kategorie.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=325,height=270').focus(); return false" >Dodaj kategorie</a></li>
                    <li><a href="\dziennik_lekcyjny\semestry.php">Trwanie semestrów</a></li>
                </ul>
            </div>
            END;
            }
            ?>
            <?php
            if($_SESSION['login']=='admin'){
                echo <<<END
            <div id="zawijaj">
                <a>Wirtualne klasy</a>
                <ul>
                    <li><a href="\dziennik_lekcyjny\podglad_uczniowie_wirtualna.php">Klasy wirtualne i uczniowie</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_wirt_klasa.php" onclick="window.open('dodaj_wirt_klasa.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=250').focus(); return false">Dodaj wirtualną klase</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_dowirt.php" onclick="window.open('dodaj_dowirt.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=250').focus(); return false">Dodaj ucznia do wirtualnej klasy</a></li>
                </ul>
            </div>
            END;
            }
            ?>
            <div id="zawijaj">
                <a>Ocenianie</a>
                <ul>
                    <li><a href="\dziennik_lekcyjny\dodaj_oceny.php" onclick="window.open('dodaj_oceny.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=450').focus(); return false">Ocena z przedmiotu</a></li>
                    <li><a href="\dziennik_lekcyjny\dodaj_zachowanie.php" onclick="window.open('dodaj_zachowanie.php', 'nazwa', 'menubar=no,toolbar=no,location=no,directories=no,status=no,scrollbars=no,reszable=no,fullscreen=no,channelmode=no,width=350,height=400').focus(); return false">Ocena z zachowania</a></li>
                    <li><a href="\dziennik_lekcyjny\podglad_oceny_uczniow.php">Podgląd ocen uczniów</a></li>
                    <li><a href="\dziennik_lekcyjny\podglad_zachowanie.php">Podgląd zachowania uczniów</a></li>
                </ul>
            </div>
            <div id="zawijaj">
                <a>Raporty</a>
                <ul>
                    <li><a href="\dziennik_lekcyjny\podglad_wychowawcy.php">Klasy</a></li>
                    <li><a href="\dziennik_lekcyjny\podglad_uczniowie.php">Uczniowie</a></li>
                    <li><a href="\dziennik_lekcyjny\podglad_samorzady.php">Samorządy klasowe</a></li>
                    <li><a href="\dziennik_lekcyjny\podglad_nauczyciele.php">Nauczyciele</a></li>
                    <li><a href="\dziennik_lekcyjny\nauczane_klasy.php">Przydzialy</a></li>


                </ul>
            </div>
            
            <a href="\dziennik_lekcyjny\podglad_statystyki.php">Statystyki</a>
        </div>
        

        <div id="glowny2">

        </div>
        <div id="stopka">
            Stronę wykonał: Jakub Wierciński<br>
            &copy Wszelkie prawa zastrzeżone
        </div>
    </div>
</body>
</html>