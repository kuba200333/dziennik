<?php
session_start();


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>Logowanie do dziennika</title>
</head>
<body>
    <div class="logowanie">
    <h1>Logowanie do dziennika elektronicznego</h1>

    <form action="logowanie_dziennik.php" method="post">
        Login: <br>
        <input type="text" name="login"> <br>
        Hasło: <br> 
        <input type="password" name="haslo"> <br><br>
        <input type="submit" value="Zaloguj się"><br>
        <a href="przypomnij.php">Przypomnij hasło</a><br><br>

        <?php
        if (isset($_SESSION['blad'])){
        echo $_SESSION['blad'];
        
    }
    ?>

    </form>
    </div>
    
</body>
</html>