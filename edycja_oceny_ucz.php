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
    <title>Edycja oceny</title>
    <link rel="stylesheet" href="styl12.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\widok_ocen.php">Powrót do widoku ocen <br></a>
    </div>

    <div id="naglowek2">
        <h2>Edycja oceny</h2>
    </div>
        
    <div id="glowny">
        <?php
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            
            if(isset($_POST['id_oceny'])){

                $_SESSION['id_oceny']=$_POST['id_oceny'];
                $id_oceny=$_SESSION['id_oceny'];
                }
                if(!isset($_POST['id_oceny'])){
    
                    $id_oceny=$_SESSION['id_oceny'];
                }
           

                echo "<table><form action='' method='post'>";
                $zapytanie12="SELECT concat(u.nazwisko_ucznia, ' ',u.imie_ucznia) FROM oceny o inner join uczniowie u on o.id_ucznia=u.id_ucznia where id_oceny=$id_oceny;";
                $wyslij12=mysqli_query($polaczenie,$zapytanie12);  
                while($row12=mysqli_fetch_array($wyslij12)){
                    echo "<tr><td>Uczeń:</td> <td colspan='2'>".$row12[0]."</td></tr>";
                }
                $zapytanie12="SELECT nazwa_przedmiotu FROM oceny o inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu where id_oceny=$id_oceny;";
                
                $wyslij12=mysqli_query($polaczenie,$zapytanie12);  
                while($row12=mysqli_fetch_array($wyslij12)){
                    echo "<tr><td >Przedmiot:</td> <td  colspan='2'>".$row12[0]."</td></tr>";
                }

                $zapytanie1="SELECT * FROM oceny where id_oceny=$id_oceny;";
                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  


                while($row1=mysqli_fetch_array($wyslij1)){
                    if($row1['ocena']==1.5){
                        $ocena="1+";
                    }else if ($row1['ocena']==1.75){
                        $ocena="2-";
                    }else if ($row1['ocena']==2.5){
                        $ocena= "2+";
                    }else if ($row1['ocena']==2.75){
                        $ocena= "3-";
                    }else if ($row1['ocena']==3.5){
                        $ocena= "3+";
                    }else if ($row1['ocena']==3.75){
                        $ocena= "4-";
                    }else if ($row1['ocena']==4.5){
                        $ocena= "4+";
                    }else if ($row1['ocena']==4.75){
                        $ocena= "5-";
                    }else if ($row1['ocena']==5.5){
                        $ocena= "5+";
                    }else if ($row1['ocena']==5.75){
                        $ocena= "6-";
                    }else if ($row1['ocena']==0.5){
                        $ocena= "+";
                    }else if ($row1['ocena']==0.25){
                        $ocena= "-";
                    }else if ($row1['ocena']==0.01){
                        $ocena= "nk";
                    }else if ($row1['ocena']==0.02){
                        $ocena= "zw";
                    }else if ($row1['ocena']==1.00){
                        $ocena= "1";
                    }else if ($row1['ocena']==2.00){
                        $ocena= "2";
                    }else if ($row1['ocena']==3.00){
                        $ocena= "3";
                    }else if ($row1['ocena']==4.00){
                        $ocena= "4";
                    }else if ($row1['ocena']==5.00){
                        $ocena= "5";
                    }else if ($row1['ocena']==6.00){
                        $ocena= "6";
                    }else if ($row1['ocena']==0.03){
                        $ocena= "np";
                    }else if ($row1['ocena']==0.04){
                        $ocena= "zw";
                    }else{
                        $ocena= $row1['ocena'];
                    }
                    }
                    $stara_ocena=$ocena;
                echo <<<END
                <tr><td >Ocena:</td> <td colspan='2' ><input list='oceny' name='ocena' value=$ocena>
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
                    <option selected>5</option>
                    <option>5+</option>
                    <option>6-</option>
                    <option>6</option>
                    <option>nk</option>
                    <option>zw</option>
                    <option>+</option>
                    <option>-</option>
                </datalist></td></tr>
                END;

                $zapytanie15="SELECT k.nazwa_kategorii as kategoria from oceny o inner join kategorie_ocen k on o.id_kategorii=k.id_kategorii where id_oceny=$id_oceny;";

            
                $wyslij15=mysqli_query($polaczenie,$zapytanie15);

                while($row15=mysqli_fetch_array($wyslij15)){
                    $kategoria=$row15['kategoria'];
                }

                $zapytanie5="SELECT nazwa_kategorii FROM `kategorie_ocen` where id_kategorii not in (9,10) order by nazwa_kategorii asc;";
            
                $wyslij5=mysqli_query($polaczenie,$zapytanie5);
                
                echo "<tr><td >kategoria:</td> <td colspan='2' ><select class='lewy' name='kategoria'required>";
                echo "<option class='lewy' value='$kategoria'>$kategoria</option>";
                echo "<option class='lewy' value=''></option>";
                while($row5=mysqli_fetch_array($wyslij5)){
                    echo "<option class='lewy'>".$row5['nazwa_kategorii']."</option>";
                }
                echo "</select></td></tr>";       


                $zapytanie1="SELECT data from oceny where id_oceny=$id_oceny;";

                $wyslij1=mysqli_query($polaczenie,$zapytanie1);
                while($row1=mysqli_fetch_array($wyslij1)){
                    $data=$row1['data'];
                }

                echo "<tr><td >Data:</td> <td colspan='2'> <input type='date' name='data' value='$data'></td></tr>";
     
                $zapytanie1="SELECT komentarz from oceny where id_oceny=$id_oceny;";
                $wyslij1=mysqli_query($polaczenie,$zapytanie1);
                while($row1=mysqli_fetch_array($wyslij1)){
                    $komentarz=$row1['komentarz'];
                }

                echo "<tr><td>Komentarz:</td> <td > <input type='text' class='lewy' name='komentarz' value='$komentarz'></td></tr>";
                echo "<tr><td colspan='2'>
                <input type='submit' name='update' value='Zmień'>
                <input type='submit' name='usun' value='Usuń'></form>";
                echo<<<END
                <form action='widok_ocen_admin.php' method='post'><input type='submit' value='Zamknij' name='zamknij'"></form>
                END;
                echo"</td></tr>";
                
                echo "</table>";

                
                
                $sql='SELECT c.typ, c.data, c.zmiana, concat(n.nazwisko, " ",n.imie) as nauczyciel FROM changelog c inner join nauczyciele n on c.zmieniajacy=n.id_nauczyciela where c.id_dane='.$id_oceny.';';
 
                $wyslij=mysqli_query($polaczenie,$sql);
                if ($wyslij->num_rows>0){
                echo "<br><h2>Historia modyfikacji</h2>";   
                echo "<table>";
                echo"<tr><td>Data:</td><td>Użytkownik:</td><td>Typ</td><td>Zmiana</td></tr>";
                }
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<tr><td>".$row['data']."</td><td>".$row['nauczyciel']." [Nauczyciel] (login: ".$_SESSION['login'].")</td><td>".$row['typ']."</td><td>".$row['zmiana']."</td></tr>";
                }
                echo "</table>";

                if(isset($_POST['update'])){
                    $nowa_ocena=$ocena=$_POST['ocena'];
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
                    }else if($ocena=="np"){
                        $ocena=0.03;
                    }else if($ocena=="nu"){
                        $ocena=0.04;
                    }
            
            

                    $zapytanie1="SELECT id_kategorii from kategorie_ocen where nazwa_kategorii='".$_POST['kategoria']."';";


                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);
                    while($row1=mysqli_fetch_array($wyslij1)){
                        $id_kategorii=$row1['id_kategorii'];
                    }

                    $zapytanie1="SELECT waga from kategorie_ocen where nazwa_kategorii='".$_POST['kategoria']."';";


                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);
                    while($row1=mysqli_fetch_array($wyslij1)){
                        $waga=$row1['waga'];
                    }

                    $data=$_POST['data'];

                    $zapytanie20="SELECT id from semestry where '$data' between od and do;";
                    $wyslij20=mysqli_query($polaczenie,$zapytanie20);
                    while($row20=mysqli_fetch_array($wyslij20)){
                        $semestr=$row20[0];
                    }


                    $komentarz=$_POST['komentarz'];


                    if($ocena<1){
                        $nie_licz=1;
                    }else{
                        $nie_licz=0;
                    }

                    $zapytanie20="SELECT id_nauczyciela from nauczyciele where login='".$_SESSION['login']."';";
                    $wyslij20=mysqli_query($polaczenie,$zapytanie20);
                    while($row20=mysqli_fetch_array($wyslij20)){
                        $id_nauczyciela=$row20[0];
                    }

                    
                    $zapytanie11="UPDATE oceny SET id_nauczyciela=$id_nauczyciela, id_kategorii=$id_kategorii,semestr=$semestr,ocena=$ocena,waga=$waga,data='$data',komentarz='$komentarz',nie_licz=$nie_licz WHERE id_oceny=$id_oceny;";
                    $zapytanko="INSERT INTO `changelog`(`id`, id_dane, `typ`, `zmiana`, `data`, `zmieniajacy`) VALUES (null, $id_oceny, 'Zmiana',' $stara_ocena => $nowa_ocena','$data',$id_nauczyciela);";
                    echo $zapytanie11;
                    $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
                    $wyslij11=mysqli_query($polaczenie,$zapytanko);  
                    header("Location: http://localhost/dziennik_lekcyjny/widok_ocen_admin.php");
                    exit;
                }
                ?>
                <?php
                    if(isset($_POST['usun'])){
                        $zapytanie20="SELECT id_nauczyciela from nauczyciele where login='".$_SESSION['login']."';";
                        $wyslij20=mysqli_query($polaczenie,$zapytanie20);
                        while($row20=mysqli_fetch_array($wyslij20)){
                        $id_nauczyciela=$row20[0];
                    }
                        $zapytanie11="DELETE FROM oceny WHERE id_oceny=$id_oceny;";
                        echo $zapytanie11;
                        $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
                        $zapytanie11="INSERT INTO `changelog`(`id`, `typ`, `zmiana`, `data`, `zmieniajacy`) VALUES (null,'usunięcie','Usunieto ocenę o id: $id_oceny','$data',$id_nauczyciela);";
                        $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
                        header("Location: http://localhost/dziennik_lekcyjny/widok_ocen_admin.php");
                        exit;
                    }             
                ?>
    </div>
    
    <div id="stopka">
       
    </div>
</div>

</body>
</html>