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
    <title>Obecność</title>
    <style>
        table{
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
        }
        td{
            border: 1px solid black;
            border-collapse: collapse;
        }
        tr{
            border: 1px solid black;
            border-collapse: collapse;
        }
        th{
            border: 1px solid black;
            border-collapse: collapse;
        }
        td.wyglad input{
            appearance: none;
            width: 10px;
            height: 10px;
            border: 1px solid black;
        }
        td.wyglad input:checked{
            background-color: black;
        }
        .kolumna1{
            width: 30%;
            background-color: rgba(255, 253, 251, 0.909);
        }
        .kolumna2{
            width: 70%;
            background-color: rgb(236, 236, 236);
        }
        .kolumna3{
            width: 100%;
            background-color: rgb(236, 236, 236);
        }
    </style>
</head>

<body>
    <form action="" method="post">
        
        <?php

        echo"
        <table>
        <tr><td class='kolumna3' colspan='2'></td></tr>
        <tr><td class='kolumna1'>klasa:</td> <td class='kolumna2'>".$_POST['klasa']."</td></tr>";
        echo "<tr><td class='kolumna1'>Wybierz datę: </td><td class='kolumna2'><input type='date' name='data' required></td></tr>
        <tr><td class='kolumna1'>Wybierz lekcje:  </td><td class='kolumna2'><input type='number' name='lekcja' min=1 max=8 required></td></tr>
        <tr><td class='kolumna3' colspan='2'></td></tr>
        </table><br>";

        echo "<table>
        <tr><th rowspan='2'>uczen</th><th>ob</th><th>nb</th><th>u</th><th>zw</th><th>sp</th></tr>
        <tr><td class='wyglad'><input type='radio' name='all' onclick='allob()'></td><td class='wyglad'><input type='radio' name='all' onclick='allnb()'></td><td class='wyglad'><input type='radio' name='all' onclick='allu()'></td><td class='wyglad'><input type='radio' name='all'  onclick='allzw()'></td>
        <td class='wyglad'><input type='radio' name='all' onclick='allsp()'></td></tr>";
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $id_klasy=$_POST['id_klasy'];
        $id_przedmiot=$_POST['id_przedmiot'];
        $zapytanie="SELECT id_ucznia, concat(nazwisko_ucznia, ' ', imie_ucznia) as uczen, id_klasy FROM `uczniowie` where id_klasy=$id_klasy order by uczen asc;";
        $wyslij=mysqli_query($polaczenie,$zapytanie);
        echo "<tr style='background-color: silver;' class='suma'>
        <td style='text-align:right;'>Suma:</td> <td class='obSum'>0</td><td class='nbSum'>0</td><td class='uSum'>0</td>
        <td class='zwSum'>0</td><td class='spSum'>0</td></tr>
        ";
        while($row=mysqli_fetch_array($wyslij)){
            echo '<tr id="'.$row[0].'"><td style="text-align:left;">'.$row[1].'<input type="hidden" name="uczen['.$row[0].']"  value="'.$row[0].'"><input type="hidden" name="id_przedmiot" value="'.$id_przedmiot.'"></td>
            <td class="wyglad" ><input type="radio" name="frekwencja['.$row[0].']" id="obecnosc" value="ob"></td><td class="wyglad" ><input type="radio" name="frekwencja['.$row[0].']" id="niebecnosc" value="nb"></td>
            <td class="wyglad" ><input type="radio" name="frekwencja['.$row[0].']" id="usprawiedliwione" value="u"></td>
            <td class="wyglad" ><input type="radio" name="frekwencja['.$row[0].']" id="zwolniony" value="zw"></td><td class="wyglad"><input type="radio" name="frekwencja['.$row[0].']" id="spoznienie" value="sp"></td></tr>';
        }
        echo "<tr style='background-color: silver;' class='suma'>
        <td style='text-align:right;'>Suma:</td> <td class='obSum'>0</td><td class='nbSum'>0</td><td class='uSum'>0</td>
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
    <a href="\dziennik_lekcyjny\moje_przedmioty.php">Powrót do nauczanych przedmiotów <br></a>
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
</body>
</html>