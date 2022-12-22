<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}

if ($_SESSION['admin'] !=1){
    header("Location: dziennik.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styl.css">
    <title>Dodaj ucznia</title>
</head>
<body>
    <div class="kontener">
    <form action="" method="post">
    <h4 class="inside">Wprowadź dane ucznia:</h4>
    <table>
    <tr><td colspan="2" class="kolumna3"></td></tr>
    <tr><td class="kolumna1">Nazwisko:</td><td class="kolumna2"><input name="nazwisko_ucznia" type="text" placeholder="Nazwisko" required></td></tr>    
    <tr><td class="kolumna1">Imię:</td><td class="kolumna2"><input name="imie_ucznia" type="text" placeholder="Imie" required></td></tr>

    <tr><td class="kolumna1">Klasa:</td>
    <?php
    require "connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

    $zapytanie = "SELECT * FROM klasy where wirt=0 order by skrot_klasy;";
    $wyslij = mysqli_query($polaczenie,$zapytanie);

    echo "<td class='kolumna2'>";
    echo'<select name="skrot_klasy">';
    echo "<option></option>";
    while($row = mysqli_fetch_array($wyslij)) {

        echo "<option value='".$row['skrot_klasy']."'>".$row['skrot_klasy']."</option>";

    }

    echo'</select></td></tr>';

    echo <<<END
    <tr class='inside'><td class="kolumna3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr></table>
    END;

    if(!empty($_POST['nazwisko_ucznia'])||!empty($_POST['skrot_klasy']))
    {  

    $skrot_klasy= $_POST['skrot_klasy'];

    $i=str_replace(" ","",$imie_ucznia= $_POST['imie_ucznia']);
    $n=str_replace(" ","",$nazwisko_ucznia= $_POST['nazwisko_ucznia']);

    $zapytanie2="SELECT id_klasy from klasy where skrot_klasy='".$skrot_klasy."';";
    $wyslij2=mysqli_query($polaczenie,$zapytanie2);

    while($row2=mysqli_fetch_array($wyslij2)){
        $id_klasy=$row2['id_klasy'];
    }

    $zapytanie3="INSERT INTO uczniowie(id_ucznia, imie_ucznia, nazwisko_ucznia, id_klasy, funkcja) VALUES ('','$i','$n','$id_klasy',4)";

    
    $wyslij2=mysqli_query($polaczenie,$zapytanie3);

        echo " <p id='add'>Dodano ucznia!</p>";
    }
   
    
    mysqli_close($polaczenie);
    ?>  
    
    
    </form>
    </div>
</body>
</html>