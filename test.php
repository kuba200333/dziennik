   
<?php   
    session_start();
    if (!isset($_SESSION['zalogowany'])){
        header("Location: index.php");
    }
   $login=$_SESSION['login'];
   require "connect.php";

   $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
   $zapytanie="SELECT admin from nauczyciele where login='$login';";
   $wyslij=mysqli_query($polaczenie,$zapytanie);
   while($row=mysqli_fetch_array($wyslij)){
       $czy_admin=$row[0];
   }
   if($czy_admin==1){
       $_SESSION['admin']=1;
   }
   echo $_SESSION['admin'];
?>