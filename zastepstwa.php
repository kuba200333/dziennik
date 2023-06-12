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
    <title>Klasy</title>
    <link rel="stylesheet" href="styl13.css">
</head>
<body>

    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Zastępstwa</h2>
        </div>
        
        <div id="glowny1">
            <br>
            
            
            <?php
            
                require "connect.php";

                
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                if ($_SESSION['admin'] ==1){
                $zapytanie1="SELECT skrot_klasy FROM klasy order by skrot_klasy asc;";
                $wyslij1=mysqli_query($polaczenie,$zapytanie1);  
                echo "<form action='' method='post'>";
                
                echo "<table>";
                echo "<tr><th colspan='2'><h4>Dodaj zastępstwo</h4></th></tr>";
                $d=mktime();
                
                $date=date("Y-m-d", $d);
                echo "<tr><th>data:</th><td><input type='date' name='data' required></td></tr>";

                $zapytanie21="SELECT concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as nauczyciel FROM nauczyciele order by nauczyciel asc;";
                $wyslij21=mysqli_query($polaczenie,$zapytanie21);
                
                echo "<tr><th class='1'>nauczyciel nieobecny:</th><td class='2'><select name='nauczyciel_nb' required onchange='this.form.submit()'>";
                
                while($row21=mysqli_fetch_array($wyslij21)){
                    echo "<option>".$row21[0]."</option>";
                    
                    
                }
                echo "</select></td></tr>";  
            
                if(isset($_POST['data'])){
                    @$datka=$_SESSION['data']=$_POST['data'];
                    $dzien_tygodnia = date("N", strtotime($datka));
                }else{
                    @$datka=$_SESSION['data'];
                    $dzien_tygodnia = date("N", strtotime($datka));
                }

                if(isset($_POST['nauczyciel_nb'])){
                    echo "<form action='' method='post'>";
                
                

                
    /*
                $zapytanie="SELECT nazwa_przedmiotu FROM przedmioty where nazwa_przedmiotu != 'zachowanie' order by nazwa_przedmiotu asc;";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
        
                echo "<tr><th class=''>przedmiot:</th><td class=''><select name='przedmiot' required>";
                echo "<option value=''</option>";
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<option>".$row[0]."</option>";
                }
                echo "</select></td></tr>";
          
echo "<tr><th class=''>klasa:</th><td class=''><select name='klasy' required>";
                echo "<option value=''</option>";
                while($row1=mysqli_fetch_array($wyslij1)){
                    echo "<option>".$row1['skrot_klasy']."</option>";
                }
                echo "</select></td></tr>";
*/

                
                if(isset($_POST['nauczyciel_nb'])){
                    $nauczyciel_nb=$_SESSION['nauczyciel_nb']=$_POST['nauczyciel_nb'];
                }
                
                $sql="SELECT id_lekcji, nr_lekcji, kl.nazwa_klasy, pr.nazwa_przedmiotu, concat(na.nazwisko,' ', na.imie) as nauczyciel, sala FROM plan_lekcji pl inner join klasy kl on kl.id_klasy=pl.id_klasy inner join przedmioty pr on pr.id_przedmiotu=pl.id_przedmiotu inner join nauczyciele na on na.id_nauczyciela=pl.id_nauczyciela where dzien=$dzien_tygodnia and '$datka' between od and do and concat(na.nazwisko,' ', na.imie)='$nauczyciel_nb' order by nr_lekcji asc;";
   
                $send=mysqli_query($polaczenie, $sql);
                echo "<tr><th class=''>wybierz lekcję:</th><td class=''><select name='zajecia' required>";
                echo "<option value=''</option>";
                while($row=mysqli_fetch_array($send)){
                    echo "<option value='".$row['id_lekcji']."'>l. ".$row['nr_lekcji'].", ".$row['nazwa_klasy'].", ".$row['nazwa_przedmiotu']."</option>";
                }
                echo "</select></td></tr>";
                echo "<tr><th>lekcja:</th><td><input type='number' name='lekcja' required></td></tr>";  
                $zapytanie="SELECT nazwa_przedmiotu FROM przedmioty where nazwa_przedmiotu != 'zachowanie' order by nazwa_przedmiotu asc;";
                $wyslij=mysqli_query($polaczenie,$zapytanie);
        
                echo "<tr><th class=''>przedmiot:</th><td class=''><select name='przedmiot' required>";
                echo "<option value=''</option>";
                while($row=mysqli_fetch_array($wyslij)){
                    echo "<option>".$row[0]."</option>";
                }
                echo "</select></td></tr>";

                $zapytanie22="SELECT nazwa FROM typ_zastepstw;";
                $wyslij22=mysqli_query($polaczenie,$zapytanie22);
        
                echo "<tr><th class='1'>typ zastępstwa:</th><td class='2'><select name='typ_zastepstw' required>";
                echo "<option value=''</option>";
                while($row22=mysqli_fetch_array($wyslij22)){
                    echo "<option>".$row22[0]."</option>";
                }
                echo "</select></td></tr>";

                $zapytanie2="SELECT concat(nauczyciele.nazwisko, ' ', nauczyciele.imie) as nauczyciel FROM nauczyciele order by nauczyciel asc;";
                $wyslij2=mysqli_query($polaczenie,$zapytanie2);
        
                echo "<tr><th class='1'>nauczyciel zastępujący:</th><td class='2'><select name='nauczyciel' required >";
                echo "<option value=''</option>";
                while($row2=mysqli_fetch_array($wyslij2)){
                    echo "<option>".$row2[0]."</option>";
                }
                echo "</select></td></tr>";


 



                echo "<tr><th>sala:</th><td><input type='text' name='sala'></td></tr>";  
                echo "<tr><td><input type='submit' name='submit' value='Dodaj'><td><a href='http://localhost/dziennik_lekcyjny/zastepstwa.php'>Wybierz innego nauczyciela</a></td></tr>";
                echo"</table></form>";
            }
            }
 
                if(isset($_POST['submit'])){
                    @$skrot_klasy=$_POST['klasy'];
            
                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie13="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
                $wyslij13=mysqli_query($polaczenie,$zapytanie13);  
            
            
                while($row13=mysqli_fetch_array($wyslij13)){
                    $id_klasy=$row13['id_klasy'];
                }

                $przedmiot=@$_POST['przedmiot'];

                            
                $zapytanie3="SELECT id_przedmiotu from przedmioty where nazwa_przedmiotu='".$przedmiot."';";
                $wyslij3=mysqli_query($polaczenie,$zapytanie3);  
            
            
                while($row3=mysqli_fetch_array($wyslij3)){
                    $zid_przedmiotu=$row3['id_przedmiotu'];
                }


                $nauczyciel=@$_POST['nauczyciel'];
                $zapytanie30="SELECT id_nauczyciela from nauczyciele where concat(nauczyciele.nazwisko, ' ', nauczyciele.imie)='".$nauczyciel."';";
                $wyslij30=mysqli_query($polaczenie,$zapytanie30);  
            
            
                while($row30=mysqli_fetch_array($wyslij30)){
                    $id_nauczyciela=$row30['id_nauczyciela'];
                }
                $nauczyciel_nb=@$_POST['nauczyciel_nb'];
                $zapytanie30="SELECT id_nauczyciela from nauczyciele where concat(nauczyciele.nazwisko, ' ', nauczyciele.imie)='".$nauczyciel_nb."';";
                $wyslij30=mysqli_query($polaczenie,$zapytanie30);  
            
            
                while($row30=mysqli_fetch_array($wyslij30)){
                    $id_nauczyciela_nb=$row30['id_nauczyciela'];
                }

                
                $nr_lekcji=$_POST['lekcja'];

                $typ=$_POST['typ_zastepstw'];
                $zapytanie30="SELECT id FROM typ_zastepstw where nazwa='$typ';";
                $wyslij30=mysqli_query($polaczenie,$zapytanie30);  
            
            
                while($row30=mysqli_fetch_array($wyslij30)){
                    $typ=$row30['id'];
                }
                $sala=$_POST['sala'];

                $zajecia=$_POST['zajecia'];
                $sql="SELECT * from plan_lekcji where id_lekcji=$zajecia";
      
                $send=mysqli_query($polaczenie,$sql); 

                while($row=mysqli_fetch_array($send)){
                    
                    $id_przedmiotu=$row['id_przedmiotu'];
                    $id_klasy=$row['id_klasy'];
                }
                $zapytanie300="INSERT INTO zastepstwa VALUES (null,$id_nauczyciela_nb,$id_nauczyciela,$zid_przedmiotu,$id_klasy,'$datka',$nr_lekcji,$typ, '$sala');";
                $wyslij300=mysqli_query($polaczenie,$zapytanie300);
              
                if($typ<7){
                    $zapytanie301="INSERT INTO zastepstwa VALUES (null,$id_nauczyciela_nb,$id_nauczyciela_nb,$id_przedmiotu,$id_klasy,'$datka',$nr_lekcji,8,'');";
                    $wyslij301=mysqli_query($polaczenie,$zapytanie301);
                    
                }
                  


                }
                echo "</table>";
                echo"</div><div id='glowny2'>";

                $dzisiaj = strtotime("today");
                $dzien_tygodnia = date("N", $dzisiaj);
                $tydzien_poczatek = strtotime("-" . ($dzien_tygodnia - 1) . " days", $dzisiaj);
                $data_poczatku_tygodnia = date("Y-m-d", $tydzien_poczatek);

                $tydzien_koniec = strtotime("+" . (7 - $dzien_tygodnia) . " days", $dzisiaj);
                $data_konca_tygodnia = date("Y-m-d", $tydzien_koniec);

                $sql="SELECT concat(na.nazwisko, ' ', na.imie) as nauczyciel_nb , k.nazwa_klasy as klasa, p.nazwa_przedmiotu as przedmiot, data, nr_lekcji, 
                t.skrot as typ, concat(n.nazwisko, ' ', n.imie) as nauczyciel FROM zastepstwa z inner join klasy k on z.id_klasy=k.id_klasy inner join 
                przedmioty p on p.id_przedmiotu=z.id_przedmiot inner join nauczyciele n on n.id_nauczyciela=z.id_nauczyciel inner join typ_zastepstw t on 
                t.id=z.typ inner join nauczyciele na on z.id_naucz_nb=na.id_nauczyciela where data BETWEEN '$data_poczatku_tygodnia' and '$data_konca_tygodnia' 
                order by data asc, nauczyciel_nb asc, nr_lekcji asc;";

                $send=mysqli_query($polaczenie,$sql);
                if ($send->num_rows>0){

                echo "<br><br><table>";
                echo "<tr><td colspan='7'><h4>Zastępstwa w aktualnym tygodniu</h4></td></tr>";
                echo"<tr><th>nieobecny</th><th>data</th><th>nr lekcji</th><th>klasa</th><th>przedmiot</th><th>typ zast.</th><th>zastępujący</th></tr>";
                while($row=mysqli_fetch_array($send)){
                    echo"<tr><td>".$row['nauczyciel_nb']."</td><td>".$row['data']."</td><td>".$row['nr_lekcji']."</td><td>".$row['klasa']."</td><td>".$row['przedmiot']."</td><td>".$row['typ']."</td><td>".$row['nauczyciel']."</td></tr>";
                }
            }
                echo "</table>";
                mysqli_close($polaczenie);
    


            ?>
            
        </div>
        <div id="stopka">
            
        </div>
    </div>


    

</body>
</html>