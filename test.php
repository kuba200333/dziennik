<?php

                        $skrot_klasy='4TIG_inf';
                        $login='admin';
                        require "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                        $zapytanie="SELECT u.id_ucznia as id, u.nazwisko_ucznia as nazwisko, u.imie_ucznia as imie, k.skrot_klasy as klasa FROM wirtualne_klasy u inner join klasy k on u.id_klasy=k.id_klasy where k.skrot_klasy='$skrot_klasy' order by nazwisko;";
                        $wyslij=mysqli_query($polaczenie,$zapytanie);

                                
                            echo "<ol><table><tr><th>Nazwisko</th><th>Imie</th>";
                            if($login=='admin'){
                            echo "<th>Usuń</th>";
                            }
                            echo"</tr>";
                            echo "";
                            while($row=mysqli_fetch_array($wyslij)){
                                echo"<tr><td><li> </li></td><td>$row[1]</td><td>$row[2]</td>";
                                if($login=='admin'){
                                echo "<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_ucznia' value='".$row['id']."'><input type='submit' name='usun' value='X'></form></td>";
                                }
                                echo"</tr>";
                                
                            }
                            echo "</table></ol>";

                        mysqli_close($polaczenie);
                    

                ?>
                <body>
        <div id="glowny">
        <br>
            <table>
                
                <?php
                    
                        $skrot_klasy='4TIG_inf';
                        $login='admin';
                        require "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                        $zapytanie="SELECT u.id_ucznia as id, u.nazwisko_ucznia as nazwisko, u.imie_ucznia as imie, k.skrot_klasy as klasa FROM wirtualne_klasy u inner join klasy k on u.id_klasy=k.id_klasy where k.skrot_klasy='$skrot_klasy' order by nazwisko;";
                        $wyslij=mysqli_query($polaczenie,$zapytanie);

                                
                        echo "<tr><th>Nazwisko</th><th>Imie</th>";
                        if($login=='admin'){
                        echo "<th>Usuń</th>";
                        }
                        echo"</tr>";
                        echo "<ol>";
                        while($row=mysqli_fetch_array($wyslij)){
                            echo"<tr><td><li> </li></td><td>$row[1]</td><td>$row[2]</td>";
                            if($login=='admin'){
                            echo "<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_ucznia' value='".$row['id']."'><input type='submit' name='usun' value='X'></form></td>";
                            }
                            echo"</tr>";
                            
                        }
                        echo "</ol>";


                        mysqli_close($polaczenie);
                    

                ?>
            </table>

</body>
                <?php
                /*
                    if(!empty($_POST['klasy'])){
                        $skrot_klasy=$_POST['klasy'];
                        $login=$_SESSION['login'];
                        require "connect.php";

                        $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);
                        $zapytanie="SELECT u.id_ucznia as id, u.nazwisko_ucznia as nazwisko, u.imie_ucznia as imie, k.skrot_klasy as klasa FROM wirtualne_klasy u inner join klasy k on u.id_klasy=k.id_klasy where k.skrot_klasy='$skrot_klasy' order by nazwisko;";
                        $wyslij=mysqli_query($polaczenie,$zapytanie);
                            if ($wyslij->num_rows>0){
                                
                            echo "<tr><th>Nazwisko</th><th>Imie</th>";
                            if($login=='admin'){
                            echo "<th>Usuń</th>";
                            }
                            echo"</tr>";
                            echo "<ol>";
                            while($row=mysqli_fetch_array($wyslij)){
                                echo"<tr><td><li> </li></td><td>$row[1]</td><td>$row[2]</td>";
                                if($login=='admin'){
                                echo "<td class='usuwanie'><form action='' method='post'><input type='hidden' name='id_ucznia' value='".$row['id']."'><input type='submit' name='usun' value='X'></form></td>";
                                }
                                echo"</tr>";
                                
                            }
                            echo "</ol>";
                        }else{
                                echo"Brak uczniów w tym oddziale";
                            }
                        mysqli_close($polaczenie);
                    }
                    */
                ?>