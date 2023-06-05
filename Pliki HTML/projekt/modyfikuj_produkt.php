<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: zaloguj.php');
}
if (isset($_POST['szczegoly']) || isset($_POST['modyfikuj'])) {
} else {
    header("Location: lista_produktow.php");
}
//sprawdzenie czy sesja jest aktualna, czy ktos zalogowal sie na innym komputerze
if (isset($_SESSION['user_id'])) {
    require_once('bazadanych.php');
    $connect = connect_database();
    $query = "SELECT session_id FROM users WHERE id = '" . $_SESSION['user_id'] . "'";
    $result = pg_query($connect, $query);
    $row = pg_fetch_assoc($result);
    if ($_SESSION['session_id'] != $row['session_id']) {
        disconnect_database($connect);
        header('Location: logout.php?logout=1');
    }
}
?>
<!DOCTYPE html>
<html lang="pl">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Zarządzanie Magazynem</title>
    <link rel="icon" type="image/png" sizes="512x512" href="files/img/ikona.png">
    <link rel="icon" type="image/png" sizes="512x512" href="files/img/ikona.png">
    <link rel="icon" type="image/png" sizes="512x512" href="files/img/ikona.png">
    <link rel="icon" type="image/png" sizes="512x512" href="files/img/ikona.png">
    <link rel="icon" type="image/png" sizes="512x512" href="files/img/ikona.png">
    <link rel="stylesheet" href="files/bootstrap/css/bootstrap.min.css">
    <link rel="manifest" href="manifest.json">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/css/theme.bootstrap_4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="files/css/Ludens---Create-Edit-Form.css">
    <link rel="stylesheet" href="files/css/Navbar-Centered-Links-icons.css">
    <link rel="stylesheet" href="files/css/Projects-Grid-images.css">
    <link rel="stylesheet" href="files/css/Responsive-Form-Contact-Form-Clean.css">
    <link rel="stylesheet" href="files/css/Responsive-Form.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md py-3">
        <div class="container"><a class="navbar-brand d-flex align-items-center" href="index.php"><span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bezier">
                        <path fill-rule="evenodd" d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5v-1zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5v-1zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"></path>
                        <path d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5v-1zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z"></path>
                    </svg></span><span>Zarządzanie<br>Magazynem</span></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-3"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-3">
                <?php
                //Wyswietlanie menu zalogowanym osobom
                if (isset($_SESSION['user_id'])) {
                    include_once 'funkcje_wyswietlana.php';
                    wyswietl_menu();
                }
                ?>
                <?php
                //Wyswietlanie przycisku logowania lub wylogowania
                include_once 'funkcje_wyswietlana.php';
                logowanie(isset($_SESSION['username']))
                ?>
            </div>
        </div>
    </nav>
    <div class="container">
        <div style="margin-bottom: 11px;">
            <a class="btn btn-primary" role="button" href="lista_produktow.php" style="float: left; margin-right: 3px">Powrót do listy</a>
            <form method="POST" action="szeczgoly_produktu.php">
                <?php
                $id = $_POST['id'];
                echo '<input type="hidden" name="id" value="' . $id . '">';
                ?>
                <button name="szczegoly" class="btn btn-primary" type="submit">Powrót do szczegółów</button>
            </form>
        </div>
    </div>
    <div class="container">
        <form method="POST" action="lista_produktow.php">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Modyfikuj produkt</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col" style="margin: 13px;">
                            <fieldset>
                                <legend>Produkt:</legend>
                            </fieldset>

                            <?php
                            include_once 'bazadanych.php';
                            if (isset($_POST['id'])) {
                                $id = $_POST['id'];
                            }
                            $connection = connect_database();
                            $sql = "SELECT nazwa, marka, ilosc, cena, opis, kod_kreskowy, kategoria_id, kontrahenci_id, dokument_id, stan_krytyczny FROM produkty WHERE id = $id";
                            $result = pg_query($connection, $sql);
                            $row = pg_fetch_row($result);
                            echo "<p>ID:&nbsp;<input name='id' class='form-control' type='text' readonly='' value='$id'></p>";
                            echo "<p>Nazwa:&nbsp;<input name='nazwa_produktu' class='form-control' type='text' required='' value='$row[0]'></p>";
                            echo "<p>Marka:&nbsp;<input name='marka' class='form-control' type='text' required='' value='$row[1]'></p>";
                            echo "<p>Ilość:&nbsp;<input name='ilosc' class='form-control' type='number' min='0' required='' value='$row[2]'></p>";
                            echo "<p>Cena:&nbsp;<input name='cena' class='form-control' type='number' required='' value='$row[3]'></p>";
                            echo "<p>Stan krytyczny:&nbsp;<input class='form-control' name='stan_krytyczny' type='text' min='0' value='" . $row[9] . "'></p>";
                            echo "<p class='d-flex'>Numer kodu <br>kreskowego:&nbsp;<input id='kod' name='kod_kreskowy' class='form-control d-flex' type='text' readonly='' value='$row[5]'></p>";
                            ?>
                        </div>
                        <div class="col" style="margin: 13px;">
                            <fieldset>
                                <legend>Kategoria:</legend>
                            </fieldset>
                            <p>Wybierz kategorie:<select name="kategoria" class="form-select" required="">
                                    <?php
                                    $kategorie_sql = "SELECT id, nazwa FROM kategorie";
                                    $kategorie_result = pg_query($connection, $kategorie_sql);
                                    $used = 0;
                                    while ($kategorie_row = pg_fetch_row($kategorie_result)) {
                                        if ($kategorie_row[0] == $row[6]) {
                                            echo "<option value='$kategorie_row[0]' selected=''>$kategorie_row[1]</option>";
                                            $used = 1;
                                        } else {
                                            echo "<option value='$kategorie_row[0]'>$kategorie_row[1]</option>";
                                        }
                                    }
                                    if ($used == 0) {
                                        echo "<option value='null' selected=''>Brak kategorii</option>";
                                    } else {
                                        echo "<option value='null'>Brak kategorii</option>";
                                    }
                                    ?>
                                    <!-- <option value="12" selected="">This is item 1</option> -->
                                </select></p><a class="btn btn-primary" role="button" href="kategorie.php">Dodaj Kategorię</a>
                        </div>
                        <div class="col" style="margin: 13px;">
                            <fieldset>
                                <legend>Kontrahent</legend>
                            </fieldset>
                            <p>Wybierz Kontrahenta:<select name="kontrahent" class="form-select">
                                    <?php
                                    $kontrahenci_sql = "SELECT id, nazwa FROM kontrahenci";
                                    $kontrahenci_result = pg_query($connection, $kontrahenci_sql);
                                    $used = 0;
                                    while ($kontrahenci_row = pg_fetch_row($kontrahenci_result)) {
                                        if ($kontrahenci_row[0] == $row[7]) {
                                            echo "<option value='$kontrahenci_row[0]' selected=''>$kontrahenci_row[1]</option>";
                                            $used = 1;
                                        } else {
                                            echo "<option value='$kontrahenci_row[0]'>$kontrahenci_row[1]</option>";
                                        }
                                    }
                                    if ($used == 0) {
                                        echo "<option value='null' selected=''>Brak kontrahenta</option>";
                                    } else {
                                        echo "<option value='null'>Brak kontrahenta</option>";
                                    }

                                    ?>
                                    <!-- <option value="12" selected="">This is item 1</option> -->
                                </select></p><a class="btn btn-primary" role="button" href="kontrahenci.php">Dodaj Kontrahenta</a>
                        </div>
                        <div class="col" style="margin: 13px;">
                            <fieldset>
                                <legend>Dokument</legend>
                            </fieldset>
                            <p>Wybierz dokument do produktu:<select name="dokument" class="form-select">
                                    <?php
                                    $dokumenty_sql = "SELECT id, nazwa FROM dokumenty";
                                    $dokumenty_result = pg_query($connection, $dokumenty_sql);
                                    $used = 0;
                                    while ($dokumenty_row = pg_fetch_row($dokumenty_result)) {
                                        if ($dokumenty_row[0] == $row[8]) {
                                            echo "<option value='$dokumenty_row[0]' selected=''>$dokumenty_row[1]</option>";
                                            $used = 1;
                                        } else {
                                            echo "<option value='$dokumenty_row[0]'>$dokumenty_row[1]</option>";
                                        }
                                    }
                                    if ($used == 0) {
                                        echo "<option value='null' selected=''>Brak dokumentu</option>";
                                    } else {
                                        echo "<option value='null'>Brak dokumentu</option>";
                                    }
                                    ?>
                                    <!-- <option value="12" selected="">Brak</option> -->
                                </select></p><a class="btn btn-primary" role="button" href="dokumenty.php">Dodaj Dokument</a>
                        </div>
                        <!-- <div class="col" style="margin: 13px;">
                            <fieldset>
                                <legend>Zdjęcie Produktu:</legend>
                            </fieldset><img>
                            <h4>Dostępne operacje:</h4>
                            <div class="form-check"><input class="form-check-input" type="radio" id="formCheck-1" name="operacja"><label class="form-check-label">Dodaj/Zmień Zdjęcie</label></div>
                            <div><input class="form-control" type="file"></div>
                            <div class="form-check"><input class="form-check-input" type="radio" id="formCheck-2" name="operacja"><label class="form-check-label">Usuń Zdjęcie</label></div>
                        </div> -->
                    </div>
                    <div class="row">
                        <?php
                        echo "<p class='d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex align-items-center align-items-sm-center align-items-md-center align-items-lg-center align-items-xl-center'>
                            Opis produktu:&nbsp;
                            <textarea name='opis' class='form-control d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex align-items-center align-items-sm-center align-items-md-center align-items-lg-center align-items-xl-center'>$row[4]</textarea>&nbsp;</p>";
                        ?>
                    </div>
                    <div class="row">
                        <div><a class="btn btn-primary" data-bs-toggle="collapse" aria-expanded="true" aria-controls="collapse-1" href="#collapse-1" role="button">Skaner Kodów Kreskowych/QR</a>
                            <div class="collapse" id="collapse-1">
                                <div class="col" style="margin: 13px;" width="600px" height="600px" id="qr-reader"></div>
                                <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
                                <script>
                                    function onScanSuccess(decodedText, decodedResult) {

                                        alert("Zeskanowano kod: " + decodedText);
                                        document.getElementById("kod").value = decodedText;
                                    }
                                    var html5QrcodeScanner = new Html5QrcodeScanner(
                                        "qr-reader", {
                                            fps: 10,
                                            qrbox: 500
                                        });
                                    html5QrcodeScanner.render(onScanSuccess);
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary float-end" type="submit" name="modyfikuj">Modyfikuj</button>
                    <!-- <input name="modyfikuj" class="btn btn-primary float-end" type="submit"> -->
                    <div class="btn-group btn-group-sm float-end" role="group"></div>
                </div>
            </div>
        </form>
    </div>
    <footer class="text-center bg-dark">
        <div class="container text-white py-4 py-lg-5">
            <p class="text-muted mb-0">Copyright © 2023 Michał Przysiężny</p>
        </div>
    </footer>
    <script src="files/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/jquery.tablesorter.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-filter.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.2/js/widgets/widget-storage.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

</body>

</html>