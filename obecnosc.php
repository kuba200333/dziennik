<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodawanie seryjnie frekwencji</title>
    <link rel="stylesheet" href="styl10.css">
</head>

<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\moje_przedmioty.php">Powrót do nauczanych przedmiotów <br></a>
    </div>

    <div id="naglowek2">
        <h2>Dodawanie seryjnie frekwencji</h2>
    </div>
        
    <div id='glowny'>
    <form action="" method="post">
        
        <?php
        $d=mktime();
        $date=date("Y-m-d", $d);    
        echo"
        <table>

        <tr><td> Klasa:</td> <td>".$_POST['klasa']."</td></tr>";
        echo "<tr><td>przedmiot:</td> <td>".$_POST['nazwa_przedmiotu']."</td></tr>";
        echo "<tr><td >Wybierz datę: </td><td><input type='date' name='data' value='$date' required></td></tr>
        <tr><td>Wybierz lekcje:  </td><td><input type='number' name='lekcja' min=1 max=8 required></td></tr>

        </table><br>";

        echo "<table>
        <tr><th rowspan='3'>lp.</th><th rowspan='3'>uczen</th><th>ob</th><th>nb</th><th>u</th><th>zw</th><th>sp</th></tr>
        <tr><td class='wyglad'><input type='radio' name='all' onclick='allob()'></td><td class='wyglad'><input type='radio' name='all' onclick='allnb()'></td><td class='wyglad'><input type='radio' name='all' onclick='allu()'></td><td class='wyglad'><input type='radio' name='all'  onclick='allzw()'></td>
        <td class='wyglad'><input type='radio' name='all' onclick='allsp()'></td></tr>";
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $id_klasy=$_POST['id_klasy'];
        $id_przedmiot=$_POST['id_przedmiot'];
        $zapytanie="SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as duczen from uczniowie where id_klasy=$id_klasy UNION SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen from wirtualne_klasy where id_klasy=$id_klasy order by duczen asc;";

        $wyslij=mysqli_query($polaczenie,$zapytanie);
        echo "<tr style='background-color: silver;' class='suma'>
         <td class='obSum'>0</td><td class='nbSum'>0</td><td class='uSum'>0</td>
        <td class='zwSum'>0</td><td class='spSum'>0</td></tr>
        ";
        $x=1;
        while($row=mysqli_fetch_array($wyslij)){
            echo '<tr id="'.$row[0].'"><td>'.$x++.'.</td><td style="text-align:left;">'.$row['duczen'].'<input type="hidden" name="uczen['.$row[0].']"  value="'.$row[0].'"><input type="hidden" name="id_przedmiot" value="'.$id_przedmiot.'"></td>
            <td class="wyglad" ><input type="radio" name="frekwencja['.$row[0].']" id="obecnosc" value="ob"></td><td class="wyglad" ><input type="radio" name="frekwencja['.$row[0].']" id="niebecnosc" value="nb"></td>
            <td class="wyglad" ><input type="radio" name="frekwencja['.$row[0].']" id="usprawiedliwione" value="u"></td>
            <td class="wyglad" ><input type="radio" name="frekwencja['.$row[0].']" id="zwolniony" value="zw"></td><td class="wyglad"><input type="radio" name="frekwencja['.$row[0].']" id="spoznienie" value="sp"></td></tr>';
        }
        echo "<tr style='background-color: silver;' class='suma'>
        <td colspan='2' style='text-align:right;'>Suma:</td> <td class='obSum'>0</td><td class='nbSum'>0</td><td class='uSum'>0</td>
        <td class='zwSum'>0</td><td class='spSum'>0</td></tr>
        ";
        echo "</table>";
        echo '<input type="submit" name="submit"></td></form>';

    
        if(isset($_POST['submit'])){

            $tab=$_POST['frekwencja'];
            print_r($tab);
            $data=$_POST['data'];
            $lekcja=$_POST['lekcja'];
            $id_przedmiot=$_POST['id_przedmiot'];
            $login=$_SESSION['login'];

            $zapytanie20="SELECT id from semestry where '$data' between od and do;";
            $wyslij20=mysqli_query($polaczenie,$zapytanie20);
            while($row20=mysqli_fetch_array($wyslij20)){
                $semestr=$row20[0];
            }

            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $zapytanie="SELECT id_nauczyciela from nauczyciele where login='$login';";
            $wyslij=mysqli_query($polaczenie,$zapytanie);
            while($row=mysqli_fetch_array($wyslij)){
                $id_nauczyciela=$row[0];
            }
            
            foreach($tab as $key=> $value){
                mysqli_query($polaczenie, "INSERT INTO frekwencja(id_frekwencji, id_ucznia, typ_ob, data, id_przedmiot, id_nauczyciel, nr_lekcji, semestr) VALUES (null,$key,'$value','$data', $id_przedmiot, $id_nauczyciela, $lekcja, $semestr);");
                //echo"INSERT INTO frekwencja(id_frekwencji, id_ucznia, typ_ob, data, id_przedmiot, id_nauczyciel, nr_lekcj) VALUES (null,$key,'$value','$data', $id_przedmiot, $id_nauczyciela, $lekcja);";
                
            }
            header("Location: http://localhost/dziennik_lekcyjny/moje_przedmioty.php");
        }
    ?>

    <script>
        var ob = 0;
        var nb = 0;
        var u = 0;
        var zw = 0;
        var sp = 0;
        setInterval("licz()", 100);
        function licz() {
            ob = $('input[id="obecnosc"]:checked').length;
            nb = $('input[id="niebecnosc"]:checked').length;
            u = $('input[id="usprawiedliwione"]:checked').length;
            zw = $('input[id="zwolniony"]:checked').length;
            sp = $('input[id="spoznienie"]:checked').length;

            let tablica = document.querySelectorAll(".obSum, .nbSum, .uSum, .zwSum, .spSum");
                                for (n in tablica){
                                    if (tablica[n].className == "obSum") {
                                        tablica[n].innerHTML = ob;
                                    } if (tablica[n].className == "nbSum") {
                                        tablica[n].innerHTML = nb;
                                    } if (tablica[n].className == "uSum") {
                                        tablica[n].innerHTML = u;;
                                    }if (tablica[n].className == "zwSum") {
                                        tablica[n].innerHTML = zw;
                                    }if (tablica[n].className == "spSum") {
                                        tablica[n].innerHTML = sp;
                                }
                                
                    }

        }
        function allob(){
            var btns = document.querySelectorAll('input[type="radio"][id="obecnosc"]')
            for(var i=0;i<btns.length;i++){
            if(btns[i].value=="ob")
            btns[i].checked=true;
            }
        }
        function allnb(){
            var btns = document.querySelectorAll('input[type="radio"][id="niebecnosc"]')
            for(var i=0;i<btns.length;i++){
            if(btns[i].value=="nb")
            btns[i].checked=true;
            }
        }
        function allu(){
            var btns = document.querySelectorAll('input[type="radio"][id="usprawiedliwione"]')
            for(var i=0;i<btns.length;i++){
            if(btns[i].value=="u")
            btns[i].checked=true;
            }
        }
        function allzw(){
            var btns = document.querySelectorAll('input[type="radio"][id="zwolniony"]')
            for(var i=0;i<btns.length;i++){
            if(btns[i].value=="zw")
            btns[i].checked=true;
            }
        }
        function allsp(){
            var btns = document.querySelectorAll('input[type="radio"][id="spoznienie"]')
            for(var i=0;i<btns.length;i++){
            if(btns[i].value=="sp")
            btns[i].checked=true;
            }
        }
    </script>
     </div>
    <div id="stopka">
       
    </div>
</div>
</body>
</html>