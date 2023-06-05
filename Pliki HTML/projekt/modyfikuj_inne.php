<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: zaloguj.php');
}
if (isset($_POST['szczegoly']) || isset($_POST['modyfikuj'])) {
} else {
    header("Location: lista_produktow.php");
};
//sprawdzenie czy sesja jest aktualna, czy ktos zalogowal sie na innym komputerze
if (isset($_SESSION['user_id'])) {
    require_once('bazadanych.php');
    $connect = connect_database();
    status_database($connect); //sprawdzenie czy udalo sie polaczyc z baza danych
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
        <div class="btn-group" role="group" style="margin-bottom: 11px;">
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                if (isset($_POST['modyfikuj'])) {
                    if ($_POST['typ'] == 'kontrahenci') {
                        echo "<a class='btn btn-primary' role='button' href='kontrahenci.php'>Powrót do listy</a>";
                    } else if ($_POST['typ'] == 'kategorie') {
                        echo "<a class='btn btn-primary' role='button' href='kategorie.php'>Powrót do listy</a>";
                    }
                }
            }
            ?>
        </div>
    </div>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Modyfikuj</h5>
            </div>
            <div class="card-body">
                <div>
                    <?php
                    echo "<div class='row'>";
                    echo "<div class='col'>";
                    if (isset($_POST['modyfikuj'])) {
                        if ($_POST['typ'] == 'kontrahenci') {
                            echo "<form action='kontrahenci.php' method='post'>";
                            echo "<legend>Kontrahent:</legend>";
                            echo "<p>ID:&nbsp;<input class='form-control' type='text' disabled='' value='" . $_POST['id'] . "'></p>";
                            echo "<p>Nazwa Kontrahenta:&nbsp;<input name='nazwa' class='form-control' type='text' required='' value='" . $_POST['nazwa'] . "'></p>";
                            echo "<p>Adres email:&nbsp;<input name='email' class='form-control' type='email' value='" . $_POST['email'] . "'></p>";
                            echo "<p>Numer telefonu:&nbsp;<input class='form-control' name='phone' type='tel' value='" . $_POST['telefon'] . "'></p>";
                            echo "<input type='hidden' name='id' value='" . $_POST['id'] . "'>";
                            echo "<button name='przycisk_modyfikacja' value='tak' class='btn btn-primary' type='subbmit' style='margin-bottom: 11px;'>Modyfikuj</button>";
                        } else if ($_POST['typ'] == 'kategorie') {
                            echo "<form method='POST' action='kategorie.php'>";
                            echo "<legend>Kategoria:</legend>";
                            echo "<p>ID:&nbsp;<input class='form-control' type='text' disabled='' value='" . $_POST['id'] . "'></p>";
                            echo "<p>Nazwa Kategorii:&nbsp;<input class='form-control' name='kategoria' type='text' required='' value='" . $_POST['nazwa'] . "'></p>";
                            echo "<p>Stawka VAT:&nbsp;<input class='form-control' type='text' name='vat' value='" . $_POST['vat'] . "'></p>";
                            echo "<input type='hidden' name='id' value='" . $_POST['id'] . "'>";
                            echo "<button name='przycisk_modyfikacja' class='btn btn-primary' type='subbmit' style='margin-bottom: 11px;'>Modyfikuj</button>";
                        }
                        echo "</form>";
                        echo "</div>";
                        echo "</div>";
                    } else {
                        echo "<p>Brak danych do wyświetlenia</p>";
                    }

                    ?>
                </div>
            </div>
        </div>

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