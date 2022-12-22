<<<<<<< HEAD
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="przypomnij.css">
    <title>Reset hasła</title>
</head>
<body>
    <div class="przypominanie">
    <?php
        if(!isset($_POST['send'])){
        echo "<h3>Wprowadź login, aby odzyskać hasło do konta</h3>";
        echo '<form action="" method="post">';
        echo 'Wprowadź login <br> <input type="text" name="login" required><br><br>';
        echo '<button type="submit" name="send">Wyślij</button><br><br>';
        echo "<a href='index.php'>Powrót do logowania</a><br><br>";
        echo '</form>';
        }
        
    ?>

    <?php



    if(isset($_POST['send'])){
        $login=$_POST['login'];
        
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

        $kod=rand(100000,999999);


    
        if($login=='admin'){
            $zapytanie="UPDATE `admin` SET kod_odzyskania=$kod WHERE login='$login';";
        }else{
            $zapytanie="UPDATE `nauczyciele` SET kod_odzyskania=$kod WHERE login='$login';";
        }
        
        $wyslij=mysqli_query($polaczenie,$zapytanie);
        if($login=='admin'){
            $zapytanie2="SELECT email FROM `admin` where kod_odzyskania=$kod;";
        }else{
            $zapytanie2="SELECT email FROM `nauczyciele` where kod_odzyskania=$kod;";
        }
        $wyslij2=mysqli_query($polaczenie,$zapytanie2);
        while($row2=mysqli_fetch_array($wyslij2)){
            $email=$row2['email'];
        }
        if($wyslij2->num_rows==0){
            $email="test@test.pl";
        }

        }

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';
        

        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $login=@$_POST['login'];
        $zapytanie3="SELECT login FROM nauczyciele where login='$login' union SELECT login FROM admin where login='$login';";

        $wyslij3=mysqli_query($polaczenie,$zapytanie3);
        
        if(isset($_POST['send'])){
            

            
        $mail= new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username= 'dziennik.odzyskaj.haslo@gmail.com'; //email
        $mail->Password= 'deggvithnnvdvyre'; // hasło
        $mail->SMTPSecure = 'ssl';
        $mail->Port= 465;

        
        $mail->CharSet = "UTF-8";
        $mail->setLanguage('pl', '/phpmailer/language');

        $mail->setFrom('kuba.wiercinski2003@gmail.com', 'Dziennik- reset hasła'); //email moj

    

        $mail->addAddress($email);

        $mail->isHTML(true);

        $informacja="Kod odzyskania do dziennika elektronicznego!!!";
        $mail->Subject = $informacja;
        $mail->Body= "Twój kod, który musisz podać w formularzu to: ".$kod;

        $mail->send();
        }
  
            if(isset($_POST['send'])){
            echo "<h3>Wprowadź kod i pozostałe dane, aby ustawić nowe hasło</h3>";
            echo '<form action="" method="post">';
            echo 'Wprowadź login <input type="text" name="login" required><br>';
            echo 'Wprowadź kod <input type="text" name="kod" required><br>';
            echo 'Wprowadź nowe hasło <input type="password" name="haslo" required><br>';
            echo '<button type="submit" name="nowe">Zmień</button><br>';
            echo "<a href='index.php'>Powrót do logowania</a><br><br>";
            echo '</form>';
            }

            if(isset($_POST['nowe'])){
            require "connect.php";
            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $login=$_POST['login'];
            $kod_email=$_POST['kod'];
            $nowe_haslo=$_POST['haslo'];

            $haslo_hash= password_hash($nowe_haslo, PASSWORD_DEFAULT);
            if($login=='admin'){
                $zapytanie="UPDATE `admin` SET haslo='$haslo_hash' WHERE kod_odzyskania=$kod_email and login='$login';";
            }else{
                $zapytanie="UPDATE `nauczyciele` SET haslo='$haslo_hash' WHERE kod_odzyskania=$kod_email and login='$login';";
            }

            $wyslij=mysqli_query($polaczenie,$zapytanie);
            header("Location: index.php");
             
            
            mysqli_close($polaczenie);
            }
            
        
    ?>
    </div>

</body>
=======
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="przypomnij.css">
    <title>Reset hasła</title>
</head>
<body>
    <div class="przypominanie">
    <?php
        if(!isset($_POST['send'])){
        echo "<h3>Wprowadź login, aby odzyskać hasło do konta</h3>";
        echo '<form action="" method="post">';
        echo 'Wprowadź login <br> <input type="text" name="login" required><br><br>';
        echo '<button type="submit" name="send">Wyślij</button><br><br>';
        echo "<a href='index.php'>Powrót do logowania</a><br><br>";
        echo '</form>';
        }
        
    ?>

    <?php



    if(isset($_POST['send'])){
        $login=$_POST['login'];
        
        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

        $kod=rand(100000,999999);


    
        if($login=='admin'){
            $zapytanie="UPDATE `admin` SET kod_odzyskania=$kod WHERE login='$login';";
        }else{
            $zapytanie="UPDATE `nauczyciele` SET kod_odzyskania=$kod WHERE login='$login';";
        }
        
        $wyslij=mysqli_query($polaczenie,$zapytanie);
        if($login=='admin'){
            $zapytanie2="SELECT email FROM `admin` where kod_odzyskania=$kod;";
        }else{
            $zapytanie2="SELECT email FROM `nauczyciele` where kod_odzyskania=$kod;";
        }
        $wyslij2=mysqli_query($polaczenie,$zapytanie2);
        while($row2=mysqli_fetch_array($wyslij2)){
            $email=$row2['email'];
        }
        if($wyslij2->num_rows==0){
            $email="test@test.pl";
        }

        }

        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\Exception;
        require 'phpmailer/src/Exception.php';
        require 'phpmailer/src/PHPMailer.php';
        require 'phpmailer/src/SMTP.php';
        

        require "connect.php";

        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $login=@$_POST['login'];
        $zapytanie3="SELECT login FROM nauczyciele where login='$login' union SELECT login FROM admin where login='$login';";

        $wyslij3=mysqli_query($polaczenie,$zapytanie3);
        
        if(isset($_POST['send'])){
            

            
        $mail= new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username= 'dziennik.odzyskaj.haslo@gmail.com'; //email
        $mail->Password= 'deggvithnnvdvyre'; // hasło
        $mail->SMTPSecure = 'ssl';
        $mail->Port= 465;

        
        $mail->CharSet = "UTF-8";
        $mail->setLanguage('pl', '/phpmailer/language');

        $mail->setFrom('kuba.wiercinski2003@gmail.com', 'Dziennik- reset hasła'); //email moj

    

        $mail->addAddress($email);

        $mail->isHTML(true);

        $informacja="Kod odzyskania do dziennika elektronicznego!!!";
        $mail->Subject = $informacja;
        $mail->Body= "Twój kod, który musisz podać w formularzu to: ".$kod;

        $mail->send();
        }
  
            if(isset($_POST['send'])){
            echo "<h3>Wprowadź kod i pozostałe dane, aby ustawić nowe hasło</h3>";
            echo '<form action="" method="post">';
            echo 'Wprowadź login <input type="text" name="login" required><br>';
            echo 'Wprowadź kod <input type="text" name="kod" required><br>';
            echo 'Wprowadź nowe hasło <input type="password" name="haslo" required><br>';
            echo '<button type="submit" name="nowe">Zmień</button><br>';
            echo "<a href='index.php'>Powrót do logowania</a><br><br>";
            echo '</form>';
            }

            if(isset($_POST['nowe'])){
            require "connect.php";
            $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
            $login=$_POST['login'];
            $kod_email=$_POST['kod'];
            $nowe_haslo=$_POST['haslo'];

            $haslo_hash= password_hash($nowe_haslo, PASSWORD_DEFAULT);
            if($login=='admin'){
                $zapytanie="UPDATE `admin` SET haslo='$haslo_hash' WHERE kod_odzyskania=$kod_email and login='$login';";
            }else{
                $zapytanie="UPDATE `nauczyciele` SET haslo='$haslo_hash' WHERE kod_odzyskania=$kod_email and login='$login';";
            }

            $wyslij=mysqli_query($polaczenie,$zapytanie);
            header("Location: index.php");
             
            
            mysqli_close($polaczenie);
            }
            
        
    ?>
    </div>

</body>
>>>>>>> a2b89c71cd09f84b2babb0669484c902f01892c4
</html>