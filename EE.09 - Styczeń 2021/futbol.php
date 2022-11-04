<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rozgrywki futbolowe</title>
    <link rel="stylesheet" href="styl.css">
</head>
<?php
    $conn = mysqli_connect("localhost", "admin", "root", "egzamin") or die();

    $sql = "SELECT * FROM rozgrywka";

    $wynik = mysqli_query($conn, $sql);

    // echo mysqli_num_rows($wynik);
?>  
<body>
    <div id="baner">
        <h2>Światowe rozgrywki piłkarskie</h2>
    </div>
    <div id="mecze">
        <?php
            while($wiersz = mysqli_fetch_assoc($wynik)) {
                echo "<div class='mecz'>";
                    $zespol1 = $wiersz["zespol1"];
                    $zespol2 = $wiersz["zespol2"];
                    $wynikMeczu = $wiersz["wynik"];
                    $dataMeczu = $wiersz["data_rozgrywki"];
                    
                    echo "<h3>$zespol1 - $zespol2</h3>";
                    echo "<h4>$wynikMeczu</h4>";
                    echo "<p>w dniu: $dataMeczu</p>";
                echo "</div>";
            }
        ?>
    </div>
    <div id="main">
        <h2>Reprezentacja Polski</h2>
    </div>
    <div id="lewy">
        <p>Podaj pozycję zawodników (1-bramkarze, 2-obrońcy, 3-pomocnicy, 4-napastnicy)</p>
        <form action="futbol.php" method="POST">
            <input type="number" name="nr_pozycji">
            <input type="submit" name="submit" value="Sprawdź">
        </form>
        <ul>
            <?php
                if(isset($_POST["submit"])) {
                    $pozycja = $_POST["nr_pozycji"];

                    $sql = "SELECT * 
                            FROM zawodnik 
                            WHERE pozycja_id = $pozycja";
                    
                    $wynik = mysqli_query($conn, $sql);

                    while($wiersz = mysqli_fetch_assoc($wynik)) {
                        $imie = $wiersz['imie'];
                        $nazwisko = $wiersz['nazwisko'];
                        echo "<li><p>$imie $nazwisko</p></li>";
                    }

                }
            ?>
        </ul>
    </div>
    <div id="prawy">
        <form action="futbol.php" method="POST">
            Imię: <input type="text" name="imie"><br>
            Nazwisko:<input type="text" name="nazwisko"><br>
            Numer pozycji:<input type="number" name="nowy_nr_pozycji"><br>
            <input type="submit" name="dodaj" value="Dodaj">
        </form>
        <?php
            if(isset($_POST["dodaj"])) {
                $imie = $_POST["imie"];
                $nazwisko = $_POST["nazwisko"];
                $pozycja = $_POST["nowy_nr_pozycji"];

                $sql = "INSERT INTO zawodnik (imie, nazwisko, pozycja_id) VALUES ('$imie', '$nazwisko', $pozycja)";

                $wynik = mysqli_query($conn, $sql);
                // $zapytanie = mysqli_prepare(
                //     $conn, 
                //     $sql
                // );

                // mysqli_stmt_bind_param(
                //     $zapytanie, 
                //     "ssd", 
                //     $imie, 
                //     $nazwisko, 
                //     $pozycja
                // );

                // mysqli_stmt_execute($zapytanie) or die();
            }

        ?>
        <p>Autor: 00000000000</p>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>