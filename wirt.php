<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Document</title>
</head>
<body>
<h2>Wybierz klasy:</h2>
	<form method="post" action="">
	<?php
		// łączymy się z bazą danych
		require "connect.php";

                
                $conn = @new mysqli($host, $db_user, $db_password, $db_name);
		// sprawdzamy, czy połączenie się udało
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		}
		// wykonujemy zapytanie do bazy danych
		$sql = "SELECT id_klasy, nazwa_klasy, skrot_klasy FROM klasy WHERE wirt=0 ORDER BY skrot_klasy ASC";
		$result = $conn->query($sql);
		// wyświetlamy wyniki zapytania jako pola wyboru checkocena
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
		        echo '<input type="checkocena" name="klasy[]" value="'.$row["id_klasy"].'">'.$row["nazwa_klasy"].' ('.$row["skrot_klasy"].')<br>';
		    }
		} else {
		    echo "Brak wyników";
		}
		// zamykamy połączenie z bazą danych
		$conn->close();
	?>
	<h2>Wprowadź dane dla wirtualnej klasy:</h2>
	Nazwa klasy: <input type="text" name="nazwa_klasy"><br>
	Skrót klasy: <input type="text" name="skrot_klasy"><br>
	<input type="submit" value="Wyślij">
	</form>
    <?php
    // łączymy się z bazą danych
    require "connect.php";

                    
    $conn = @new mysqli($host, $db_user, $db_password, $db_name);
    // sprawdzamy, czy połączenie się udało
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // zapisujemy dane z formularza
    $nazwa_klasy = $_POST["nazwa_klasy"];
    $skrot_klasy = $_POST["skrot_klasy"];

    // dodajemy wirtualną klasę do bazy danych
    $sql = "INSERT INTO klasy (id_klasy, nazwa_klasy, skrot_klasy, wirt) VALUES (null, '$nazwa_klasy', '$skrot_klasy', 1)";
    if ($conn->query($sql) === TRUE) {
        echo "Wirtualna klasa została dodana do bazy danych";
    } else {
        echo "Błąd dodawania wirtualnej klasy: " . $conn->error;
    }

    // pobieramy id ostatnio dodanej klasy wirtualnej
    $id_wirt = $conn->insert_id;

    // przetwarzamy zaznaczone klasy z formularza
    if(isset($_POST["klasy"])){
        // wykonujemy pętlę po zaznaczonych klasy
        foreach($_POST["klasy"] as $id_macierz){
            // dodajemy rekord do tabeli przyp_wirt
            $sql = "INSERT INTO przyp_wirt (id, id_macierz, id_wirt) VALUES (null, $id_macierz, $id_wirt)";
            if ($conn->query($sql) !== TRUE) {
                echo "Błąd dodawania przypisania wirtualnej klasy: " . $conn->error;
            }
        }
    }

    // zamykamy połączenie z bazą danych
    $conn->close();
    ?>
</body>
</html>