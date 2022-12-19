
<?php
session_start();
if (!isset($_SESSION['zalogowany'])){
    header("Location: index.php");
}

if ($_SESSION['login']!='admin'){
    header("Location: dziennik.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj przedmiot</title>
    <link rel="stylesheet" href="styl.css">
   
</head>

<body>
    <div class="kontener">
        <h4 class="inside">Dodaj kategorie</h4>
        <table>
        <form action="" method="post">
            <tr><td class='kolumna3' colspan="2"></td></tr>
            <tr><td class='kolumna1'>Nazwa kategorii:</td><td class='kolumna2'><input name="nazwa kategorii" type="text" placeholder="Nazwa kategorii" required>  </td></tr>
            <tr><td class='kolumna1'>Skrót kategorii:</td><td class='kolumna2'><input name="skrot_kategorii" type="text" placeholder="Skrót kategorii" required>  </td></tr>
            <tr><td class='kolumna1'>Waga:</td><td class='kolumna2'><input name="waga" type="number" min=0 max=10 placeholder="Waga" required>  </td></tr>
            <tr><td class='kolumna1'>Kolor:</td><td class='kolumna2'>
                <select name="kolor">
                    <option value="" selected dissabled hidden></option>
                    <option class="khaki">khaki</option>
                    <option class="lightskyblue">lightskyblue</option>
                    <option class="lightsteelblue">lightsteelblue</option>
                    <option class="aliceblue">aliceblue</option>
                    <option class="azure">azure</option>
                    <option class="beige">beige</option>
                    <option class="blanchedalmond">blanchedalmond</option>   
                    <option class="cornsilk">cornsilk</option>
                    <option class="darkgray">darkgray</option>
                    <option class="darkkhaki">darkkhaki</option>
                    <option class="darkseagreen">darkseagreen</option>
                    <option class="gainsboro">gainsboro</option>
                    <option class="goldenrod">goldenrod</option>
                    <option class="lavender">lavender</option>
                    <option class="lightsalmon">lightsalmon</option>
                    <option class="limegreen">limegreen</option>
                    <option class="mediumaquamarine">mediumaquamarine</option>
                    <option class="silver">silver</option>
                    <option class="tan">tan</option>
                    <option class="blue">blue</option>
                    <option class="mediumslateblue">mediumslateblue</option>
                    <option class="mediumorchid">mediumorchid</option>
                    <option class="lightpink">lightpink</option>
                    <option class="deeppink">deeppink</option>
                    <option class="crimson">crimson</option>
                    <option class="red">red</option>
                    <option class="darkorange">darkorange</option>
                    <option class="gold">gold</option>
                    <option class="greenyellow">greenyellow</option>
                    <option class="lawngreen">lawngreen</option>
                </select>
            </td></tr>
            <tr class='inside'><td class="kolumna3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr>
        </table>
        <?php
        if(!empty($_POST['wysylacz'])){
            $nazwa_kategorii= $_POST['nazwa_kategorii'];
            $skrot_kategorii= $_POST['skrot_kategorii'];
            $kolor= $_POST['kolor'];
            $waga= $_POST['waga'];

            require "connect.php";

            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
    
            $zapytanie="INSERT INTO kategorie_ocen(nazwa_kategorii, skrót_kategorii, waga, kolor) VALUES ('$nazwa_kategorii', '$skrot_kategorii', $waga, '$kolor')";



            $wyslij=mysqli_query($polaczenie,$zapytanie);  
            echo "<p id='add'>Dodano kategorie!</p>";
            echo $zapytanie;
        }

        ?>
</body>
</html>