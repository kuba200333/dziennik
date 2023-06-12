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
        <a href="\dziennik_lekcyjny\frekwencja.php">Powrót do podglądu frekwencji <br></a>
    </div>

    <div id="naglowek2">
        <h2>Edycja oceny</h2>
    </div>
        
    <div id="glowny">
        <?php
            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            
            if(isset($_POST['id_frekwencji'])){

                $_SESSION['id_frekwencji']=$_POST['id_frekwencji'];
                $id_frekwencji=$_SESSION['id_frekwencji'];
                }
                if(!isset($_POST['id_frekwencji'])){
    
                    $id_frekwencji=$_SESSION['id_frekwencji'];
                }
           

                echo "<table><form action='' method='post'>";
                $zapytanie12="SELECT concat(u.nazwisko_ucznia, ' ',u.imie_ucznia) FROM frekwencja f inner join uczniowie u on f.id_ucznia=u.id_ucznia where id_frekwencji=$id_frekwencji;";
                $wyslij12=mysqli_query($polaczenie,$zapytanie12);  
                while($row12=mysqli_fetch_array($wyslij12)){
                    echo "<tr><th>Uczeń:</th> <td>".$row12[0]."</td></tr>";
                }

                $zapytanie15="SELECT kf.nazwa_frekwencji as kategoria from frekwencja f inner join kategorie_frekwencji kf on kf.skrot_frekwencji=f.typ_ob where id_frekwencji=$id_frekwencji;";

            
                $wyslij15=mysqli_query($polaczenie,$zapytanie15);

                while($row15=mysqli_fetch_array($wyslij15)){
                    $stara_kategoria=$kategoria=$row15['kategoria'];
                }

                $zapytanie5="SELECT kf.nazwa_frekwencji as kategoria FROM `kategorie_frekwencji` kf order by kf.nazwa_frekwencji asc;";
            
                $wyslij5=mysqli_query($polaczenie,$zapytanie5);
                
                echo "<tr><th>kategoria:</th> <td ><select class='lewy' name='kategoria'required>";
                echo "<option class='lewy' value='$kategoria'>$kategoria</option>";
                echo "<option class='lewy' value=''></option>";
                while($row5=mysqli_fetch_array($wyslij5)){
                    echo "<option class='lewy'>".$row5['kategoria']."</option>";
                }
                echo "</select></td></tr>";       



                echo "<tr><td colspan='2'>
                <input type='submit' name='update' value='Zmień'>
                </form>";
                echo<<<END
                <form action='frekwencja.php' method='post'><input type='submit' value='Zamknij' name='zamknij'"></form>
                END;
                echo"</td></tr>";
                
                echo "</table>";
/*
         
                $sql='SELECT c.typ, c.data, c.zmiana, concat(n.nazwisko, " ",n.imie) as nauczyciel FROM changelog c inner join nauczyciele n on c.zmieniajacy=n.id_nauczyciela where c.id_dane='.$id_oceny.';';
 
                $wyslij=mysqli_query($polaczenie,$sql);
                if ($wyslij->num_rows>0){
                    echo "<br><h2>Historia modyfikacji</h2>";
                    echo "<table>";
                    echo"<tr><th>Data:</th><th>Użytkownik:</th><th>Typ</th><th>Zmiana</th></tr>";
                }
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<tr><td>".$row['data']."</td><td>".$row['nauczyciel']." [Nauczyciel] (login: ".$_SESSION['login'].")</td><td>".$row['typ']."</td><td>".$row['zmiana']."</td></tr>";
                }
                echo "</table>";
*/

                if(isset($_POST['update'])){
                    
    

                    $zapytanie1="SELECT skrot_frekwencji from kategorie_frekwencji where nazwa_frekwencji='".$_POST['kategoria']."';";


                    $wyslij1=mysqli_query($polaczenie,$zapytanie1);
                    while($row1=mysqli_fetch_array($wyslij1)){
                        $id_kategorii=$row1['skrot_frekwencji'];
                        $nowa_kategoria=$_POST['kategoria'];
                    }


                    echo $id_kategorii;
                    $zapytanie11="UPDATE frekwencja set typ_ob='$id_kategorii' where id_frekwencji=$id_frekwencji;";
                    #$zapytanko="INSERT INTO `changelog`(`id`, id_dane, `typ`, `zmiana`, `data`, `zmieniajacy`) VALUES (null, $id_oceny, 'Zmiana',' <b>Ocena:</b> <i>$stara_ocena => $nowa_ocena </i><br><b>Kategoria:</b> <i>$stara_kategoria => $nowa_kategoria</i><br><b>Data:</b> <i>$stara_data => $data</i><br><b>Komentarz:</b> <i>$stary_komentarz => $komentarz</i>','$data',$id_nauczyciela);";
                    echo $zapytanie11;
                    $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
                    #$wyslij11=mysqli_query($polaczenie,$zapytanko);  
                    header("Location: http://localhost/dziennik_lekcyjny/frekwencja.php");
                    exit;
                }
                ?>
                <?php
                    if(isset($_POST['usun'])){
                            
                        /*$zapytanie20="SELECT id_nauczyciela from nauczyciele where login='".$_SESSION['login']."';";
                        $wyslij20=mysqli_query($polaczenie,$zapytanie20);
                        while($row20=mysqli_fetch_array($wyslij20)){
                        $id_nauczyciela=$row20[0];
                    }*/
                        $zapytanie11="DELETE FROM frekwencja WHERE id_frekwencji=$id_frekwencji;";
                        $wyslij11=mysqli_query($polaczenie,$zapytanie11);  

                        /*$zapytanie11="DELETE FROM changelog WHERE id_dane=$id_oceny;";
                        $wyslij11=mysqli_query($polaczenie,$zapytanie11);  

                        $zapytanie11="INSERT INTO `changelog`(`id`, `typ`, `zmiana`, `data`, `zmieniajacy`) VALUES ($id_oceny,'usunięcie','Usunieto ocenę o id: $id_oceny','$data',$id_nauczyciela);";
                        $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
*/
                        header("Location: http://localhost/dziennik_lekcyjny/frekwencja.php");
                        exit;
                    }             
                ?>
    </div>
    
    <div id="stopka">
       
    </div>
</div>

</body>
</html>