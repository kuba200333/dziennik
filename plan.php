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
    <title>Widok ocen</title>
    <link rel="stylesheet" href="styl15.css">
</head>
<body>
<div id="kontener">
    <div id="naglowek1">
        <a href="\dziennik_lekcyjny\dziennik.php">Powrót do strony głównej <br></a>
    </div>

    <div id="naglowek2">
        <h2>Widok ocen</h2>
    </div>
    <div id='wybierz'>
    <form action="" method='post'>
            <?php
                require "connect.php";
                
                    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                    echo'
                    <label for="week_range">Wybierz przedział dat:</label>
                    <select id="week_range" name="week_range">';
                      
                        $start_date = new DateTime('2022-08-29');
                        $end_date = new DateTime('2023-06-23');
                        $interval = DateInterval::createFromDateString('1 week');
                        $period = new DatePeriod($start_date, $interval, $end_date);
                        foreach ($period as $week_start) {
                          $week_end = clone $week_start;
                          $week_end->modify('+4 days');
                          printf('<option value="%s|%s">%s - %s</option>', $week_start->format('Y-m-d'), $week_end->format('Y-m-d'), $week_start->format('Y-m-d'), $week_end->format('Y-m-d'));
                        }
                     
                    echo'</select>';
                    $zapytanie11="SELECT skrot_klasy FROM klasy where wirt=0 order by skrot_klasy asc;";
                    $wyslij11=mysqli_query($polaczenie,$zapytanie11);  
                
                    echo "Klasa: <select name='klasy' onchange='this.form.submit()'>";
                    echo "<option value=''</option>";
                    while($row11=mysqli_fetch_array($wyslij11)){
                        echo "<option>".$row11['skrot_klasy']."</option>";
                    }
                    echo "</select>";
                    
                    mysqli_close($polaczenie);
                

            ?>
                <br>
            <?php
                if(!empty($_POST['klasy'])){

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                $_SESSION['klasy']=$_POST['klasy'];
                
                $skrot_klasy=$_POST['klasy'];
            
                
                $zapytanie13="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
                $wyslij13=mysqli_query($polaczenie,$zapytanie13);  
            
            
                while($row13=mysqli_fetch_array($wyslij13)){
                    $id_klasy=$row13['id_klasy'];
                }
            
            
                #$zapytanie10="SELECT DISTINCT p.nazwa_przedmiotu as przedmiot from nauczanie n inner join przedmioty p on n.id_przedmiot=p.id_przedmiotu inner join klasy k on n.id_klasy=k.id_klasy where k.skrot_klasy='$skrot_klasy' order by przedmiot asc;";
                $zapytanie10="SELECT DISTINCT p.nazwa_przedmiotu FROM oceny o inner join uczniowie u on u.id_ucznia=o.id_ucznia inner join klasy k on k.id_klasy=u.id_klasy inner join przedmioty p on o.id_przedmiotu=p.id_przedmiotu where k.skrot_klasy='$skrot_klasy';";
                $wyslij10=mysqli_query($polaczenie,$zapytanie10);  
            
                
            
                mysqli_close($polaczenie);
                
                }
              
            ?>
        
            </form>
    </div>
    <div id="glowny">
        <?php
            if(isset($_POST['klasy'])){
                $conn = @new mysqli($host, $db_user, $db_password, $db_name);
                $klasa=$_SESSION['klasy'];
                echo "Klasa: ".$klasa;
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                list($start_date, $end_date) = explode('|', $_POST['week_range']);

                // zapytanie SQL
                $sql = "SELECT DISTINCT pl.id_lekcji, pl.nr_lekcji, pl.dzien, pl.od, pl.do, k.skrot_klasy, p.nazwa_przedmiotu, CONCAT(n.nazwisko, ' ', n.imie) as nauczyciel, pl.sala, 'plan_lekcji' AS table_name, 0 as typ, k.nazwa_klasy
                FROM plan_lekcji pl 
                INNER JOIN klasy k ON k.id_klasy = pl.id_klasy 
                INNER JOIN przedmioty p ON p.id_przedmiotu = pl.id_przedmiotu 
                INNER JOIN nauczyciele n ON n.id_nauczyciela = pl.id_nauczyciela 
                LEFT JOIN przyp_wirt pw ON pw.id_macierz = k.id_klasy OR pw.id_wirt = k.id_klasy 
                WHERE (k.id_klasy = $id_klasy OR pw.id_macierz = $id_klasy) 
                AND ('$start_date' between pl.od and pl.do) and ('$end_date' between pl.od and pl.do)
                

                UNION 
                
                SELECT z.id as id_lekcji, nr_lekcji, 
                CASE DAYOFWEEK(data) 
                    WHEN 1 THEN 7 
                    WHEN 2 THEN 1 
                    WHEN 3 THEN 2 
                    WHEN 4 THEN 3 
                    WHEN 5 THEN 4 
                    WHEN 6 THEN 5 
                    WHEN 7 THEN 6 
                END as dzien, 
                data as od, 
                data as do, 
                k.skrot_klasy, 
                p.nazwa_przedmiotu, 
                CONCAT(n.nazwisko, ' ', n.imie) as nauczyciel, 
                z.sala,
                'zastepstwa' AS table_name, typ, k.nazwa_klasy
                FROM zastepstwa z 
                INNER JOIN klasy k ON k.id_klasy=z.id_klasy 
                INNER JOIN przedmioty p ON p.id_przedmiotu = z.id_przedmiot 
                INNER JOIN nauczyciele n ON n.id_nauczyciela = z.id_nauczyciel 
                LEFT JOIN przyp_wirt pw ON pw.id_macierz = k.id_klasy OR pw.id_wirt = k.id_klasy 
                WHERE (k.id_klasy = $id_klasy OR pw.id_macierz = $id_klasy) 
                
                AND data between '$start_date' and '$end_date'
                 ";
                
                $result = $conn->query($sql);

                // tworzenie tabeli HTML
                echo "<table>";
                echo "<tr><th>Nr lekcji</th><th>Poniedziałek</th><th>Wtorek</th><th>Środa</th><th>Czwartek</th><th>Piątek</th></tr>";
                for ($i = 1; $i <= 8; $i++) {
                  echo "<tr><td>$i</td>";
                  for ($j = 1; $j <= 5; $j++) {
                    echo "<td>";
                    $results = array();

                    while ($row = $result->fetch_assoc()) {
                    if ($row["nr_lekcji"] == $i && $row["dzien"] == $j) {
                        if($row["table_name"] =="zastepstwa" && $row["typ"] <7){
                            $results[] = "&nbsp<font style='background: #267F00; color: #ffffff;'> zastępstwo </font> &nbsp<br><b>".$row["nazwa_przedmiotu"] . "</b><br>" . $row["nauczyciel"]."&nbsp(".$row['nazwa_klasy']. ")<br>s. " . $row["sala"] . "<br>";
                        }else if($row["table_name"] =="zastepstwa" && $row["typ"] ==7){
                            $results[] = "&nbsp<font style='background: #267F00; color: #ffffff;'> przesunięcie </font> &nbsp<br><b>".$row["nazwa_przedmiotu"] . "</b><br>" . $row["nauczyciel"]."&nbsp(".$row['nazwa_klasy']. ")<br>s. " . $row["sala"] . "<br>";
                        }else if($row["table_name"] =="zastepstwa" && $row["typ"] ==8){
                            $results[] = "&nbsp<font style='background: #267F00; color: #ffffff; text-decoration: line-through;'> odwołane </font> &nbsp<br><b><font style='text-decoration: line-through;'>".$row["nazwa_przedmiotu"] . "</b></font><br><font style='text-decoration: line-through;'>" . $row["nauczyciel"]."&nbsp(".$row['nazwa_klasy']. ")</font><br>";
                        }else{
                            $results[] = "<b>".$row["nazwa_przedmiotu"] . "</b><br>" . $row["nauczyciel"]."&nbsp(".$row['nazwa_klasy']. ")<br>s. " . $row["sala"] . "<br>";
                        }
                        
                    }
                    }

                    echo implode("<hr>", $results);

                    $result->data_seek(0);
                    echo "</td>";
                  }
                  echo "</tr>";
                }
                echo "</table>";
         
                
                $conn->close();
            }
        ?>
    </div>
    
    <div id="stopka">
       
    </div>
</div>

</body>
</html>