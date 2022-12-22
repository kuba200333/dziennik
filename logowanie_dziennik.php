<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
    session_start();

	
	if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
	{
		header('Location: index.php');
		exit();
	}

    require "connect.php";

    $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);


        $login=$_POST['login'];
        $haslo=$_POST['haslo'];

        $login=htmlentities($login,ENT_QUOTES, "UTF-8");
        $haslo=htmlentities($haslo,ENT_QUOTES, "UTF-8");


        if ($rezultat=@$polaczenie->query(
            sprintf("SELECT * FROM `admin` WHERE login='%s' UNION SELECT * FROM `nauczyciele` WHERE login='%s';",
            mysqli_real_escape_string($polaczenie,$login),
            mysqli_real_escape_string($polaczenie,$haslo)))){
            $ilu_userow=$rezultat->num_rows;
            if($ilu_userow>0){
                $wiersz=$rezultat->fetch_assoc();
                if(password_verify($haslo,$wiersz['haslo'])){
                    $_SESSION['zalogowany']=true;
                    $_SESSION['login']= $wiersz['login'];
                    unset($_SESSION['blad']);
                    $rezultat->close();
                    header("Location: dziennik.php");
                    } 
                    else{
                        $_SESSION['blad']= '1Nieprawidłowy login lub hasło';
                        header("Location: index.php");
                        }
            }else{
                $_SESSION['blad']= '2Nieprawidłowy login lub hasło';
                header("Location: index.php");
                }
        }
        $l=$_SESSION['login'];
        require "connect.php";
    
        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
        $zapytanie="SELECT admin from nauczyciele where login='$l';";
        $wyslij=mysqli_query($polaczenie,$zapytanie);
        while($row=mysqli_fetch_array($wyslij)){
            $czy_admin=$row[0];
        }
        if($czy_admin==1){
            $_SESSION['admin']=1;
        }else{
            $_SESSION['admin']=0; 
        }

        $polaczenie->close();



?>
</body>
</html>