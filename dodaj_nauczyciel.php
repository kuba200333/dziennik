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
    <title>Dodaj nauczyciela</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
        <div class="kontener">
            <form action="" method="post">

        <h4 class="inside">Dodaj nauczyciela</h4>
        <table>
            <tr><td class='3' colspan="2"></td></tr>
            <tr><td class='1'>Nazwisko nauczyciela:</td><td class='2'><input name="nazwisko" type="text"  required></td></tr>
            <tr><td class='1'>Imie nauczyciela:</td><td class='2'><input name="imie" type="text"  required></td></tr>
            <!--<tr><td class='1'>login:</td><td class='2'><input name="login" type="text"  required></td></tr>-->
            <tr><td class='1'>hasło:</td><td class='2'><input name="haslo" type="password"  required></td></tr>
            <tr><td class='1'>email:</td><td class='2'><input name="email" type="email"  required></td></tr>
            <tr><td class='1'>uprawnienia admina:</td><td class='2'><input type='checkocena' name='admin'></td></tr>
            <tr class='inside'><td class="3" colspan="2"><input value="Dodaj" type="submit" name='wysylacz'>&nbsp<input type='submit' value='Zamknij' name="zamknij" onclick="window.open('', '_self', ''); window.close();"></td></tr>
        </form>
        </table>
        <?php

            if(!empty($_POST['wysylacz'])){
              

                $haslo=$_POST['haslo'];
                $email=$_POST['email'];

                /*$l=str_replace(" ","",$login=$_POST['login']);*/
                $i=str_replace(" ","",$imie= @$_POST['imie']);
                $n=str_replace(" ","",$nazwisko= @$_POST['nazwisko']);
                $haslo_hash= password_hash($haslo, PASSWORD_DEFAULT);

                $admin=@$_POST['admin'];
                if($admin=='on'){
                    $admin=1;
                }else{
                    $admin=0;
                }

                require "connect.php";

                $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        

                $sql="INSERT INTO nauczyciele(id_nauczyciela, imie, nazwisko, login, haslo, email, admin) VALUES (null,'$i','$n',LOWER(concat(nazwisko,'_',imie)), '$haslo_hash','$email', $admin)";

                $result= mysqli_query($polaczenie,$sql);
    
                echo "<p id='add'>Dodano nauczyciela!</p>";
                mysqli_close($polaczenie);

            }
        ?>
    </div>
</body>
</html>