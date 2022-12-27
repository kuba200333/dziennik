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
    <title>Statystyki</title>
    <link rel="stylesheet" href="styl4.css">
</head>
<bodyss>
    <div id="kontener">
        <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>

        </div>
        <div id="naglowek2">

            <h2>Statystyki</h2>
        </div>
        
        <div id='wybierz'>
            <form action="" method="post">
            <?php
                
                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $zapytanie11="SELECT skrot_klasy FROM klasy where wirt=0 order by skrot_klasy;";
                $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
            
                echo "Wybierz klasę: <select name='klasy' onchange='this.form.submit()'>";
                echo "<option value=''</option>";
                while($row11=mysqli_fetch_array($wyslij11)){
                    echo "<option>".$row11['skrot_klasy']."</option>";
                }
                echo "</select>";
                mysqli_close($polaczenie);
                echo "</form>";
                
                if(!empty($_POST['klasy'])){
                    echo "<p class='srodek'><b>Klasa: </b>".$_POST['klasy']."</p>";
                }
            ?>
            <br>
            
        </div>
        <div id="glowny1">
            <h2>Zestawienie semestralne</h2>
        <?php
                if(!empty($_POST['klasy'])){
         
                    require "connect.php";
                    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

                    $skrot_klasy=$_POST['klasy'];
    
        
                    $zapytanie13="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
                    $wyslij13=mysqli_query($polaczenie,$zapytanie13);  
                
                
                    while($row13=mysqli_fetch_array($wyslij13)){
                        $id_klasy=$row13['id_klasy'];
                    }
                
                    $zapytanie="SELECT concat(u.nazwisko_ucznia, ' ', u.imie_ucznia) as dane_ucznia, z.ocena as zachowanie, round(avg(o.ocena),2) as średnia from oceny o 
                    left OUTER JOIN oceny_zachowanie z on o.id_ucznia=z.id_ucznia 
                    left OUTER JOIN uczniowie u on o.id_ucznia=u.id_ucznia 
                    left OUTER JOIN klasy k on u.id_klasy=k.id_klasy where o.id_kategorii=8 and k.id_klasy= $id_klasy and o.nie_licz=0 group by o.id_ucznia order by dane_ucznia asc;";

                    $wyslij=mysqli_query($polaczenie,$zapytanie);  
                
                if ($wyslij->num_rows>0){
                    echo "<table id='tabela1'>";
                    echo "<tr><th>lp.</th><th>Nazwisko i imie</th><th>Średnia ocen</td><th>Zachowanie</th></tr>";
                    $id=1;
                    while($row=mysqli_fetch_array($wyslij)){
                        
                        echo "<tr><td>".$id++."</td><td>".$row[0]."</td><td id='ocenka'>".$row[2]."</td><td id='zachowanie'>";
                        
                        if($row['zachowanie']==0){
                            echo "";
                            }
                            else if($row['zachowanie']==6){
                                echo "wzorowe";
                            }
                            else if($row['zachowanie']==5){
                                echo "bardzo dobre";
                            }
                            else if($row['zachowanie']==4){
                                echo "dobre";
                            }
                            else if($row['zachowanie']==3){
                                echo "poprawne";
                            }
                            else if($row['zachowanie']==2){
                                echo "nieodpowiednie";
                            }
                            else if($row['zachowanie']==1){
                                echo "naganne";
                            }

                        echo "</td></tr>";
                    }
                    echo "</table>";
                }
                else{
                    echo "Brak ocen sródrocznych lub ocen śródrocznych z zachowania";
                }
                    mysqli_close($polaczenie);
                }
                ?>

        </div>

        <div id="glowny2">
            <p><h2>Zestawienie roczne</h2></p>
            <?php
                if(!empty($_POST['klasy'])){
                    require "connect.php";
                    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

                    $skrot_klasy=$_POST['klasy'];
    
        
                    $zapytanie13="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
                    $wyslij13=mysqli_query($polaczenie,$zapytanie13);  
                
                
                    while($row13=mysqli_fetch_array($wyslij13)){
                        $id_klasy=$row13['id_klasy'];
                    }
                

                    $zapytanie="SELECT concat(u.nazwisko_ucznia, ' ', u.imie_ucznia) as dane_ucznia, z.ocena as zachowanie, round(avg(o.ocena),2) as średnia from oceny o 
                    left OUTER JOIN oceny_zachowanie2 z on o.id_ucznia=z.id_ucznia left OUTER JOIN uczniowie u on o.id_ucznia=u.id_ucznia left OUTER JOIN klasy k on u.id_klasy=k.id_klasy 
                    where o.id_kategorii=7 and k.id_klasy= $id_klasy and o.nie_licz=0 group by o.id_ucznia order by dane_ucznia asc;";

                    $wyslij=mysqli_query($polaczenie,$zapytanie);  
                
                    if ($wyslij->num_rows>0){
                        echo "<table id='tabela2'>";
                        echo "<tr><th>lp.</th><th>Nazwisko i imie</th><th>Średnia ocen</td><th>Zachowanie</th></tr>";
                        $id=1;
                        while($row=mysqli_fetch_array($wyslij)){
                            echo "<tr><td>".$id++."</td><td>".$row[0]."</td>";
                                echo"<td id='ocenka2'>".$row[2]."</td>";
                            echo"<td>";
                            
                            if($row['zachowanie']==0){
                                echo "";
                                }
                                else if($row['zachowanie']==6){
                                    echo "wzorowe";
                                }
                                else if($row['zachowanie']==5){
                                    echo "bardzo dobre";
                                }
                                else if($row['zachowanie']==4){
                                    echo "dobre";
                                }
                                else if($row['zachowanie']==3){
                                    echo "poprawne";
                                }
                                else if($row['zachowanie']==2){
                                    echo "nieodpowiednie";
                                }
                                else if($row['zachowanie']==1){
                                    echo "naganne";
                                }
    
                            echo "</td></tr>";
                        }
                        echo "</table>";
                    }
                else{
                    echo "Brak ocen rocznych lub ocen rocznych z zachowania";
                }
                    mysqli_close($polaczenie);
                }
                ?>
        </div>

        <div id="stopka">
            
        </div>
    </div>

</div>
</div>
<script>
    var tabela1= document.getElementById('tabela1'); 
    var komorki1= tabela1.querySelectorAll('#ocenka, #zachowanie');

    
    for(var i=0; i<komorki1.length; i++){
        if(komorki1[i].innerHTML>=4.75){
            komorki1[i].style.backgroundImage='linear-gradient(90deg, rgb(202, 202, 202) 50%, rgb(181, 50, 50) 50%)';
            komorki1[i].style.fontWeight='bold';
        }else if(komorki1[i].innerHTML>=4.5 && komorki1[i].innerHTML<4.75){
            komorki1[i].style.backgroundColor='rgb(255,215,0)';
            komorki1[i].style.fontWeight='bold';
        }
    }
    var tabela2= document.getElementById('tabela2'); 
    var komorki2= tabela2.querySelectorAll('#ocenka2');
    
    for(var i=0; i<komorki2.length; i++){
        if(komorki2[i].innerHTML>=4.75){
            komorki2[i].style.backgroundImage='linear-gradient(90deg, rgb(202, 202, 202) 50%, rgb(181, 50, 50) 50%)';
            komorki2[i].style.fontWeight='bold';
        }else if(komorki2[i].innerHTML>=4.5 && komorki2[i].innerHTML<4.75){
            komorki2[i].style.backgroundColor='rgb(255,215,0)';
            komorki2[i].style.fontWeight='bold';
        }
    }
</script>
</body>
</html>