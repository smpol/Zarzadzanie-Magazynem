<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: zaloguj.php');
}
if (isset($_POST['szczegoly'])) {
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
    <div class="container"><a class="btn btn-primary" role="button" href="lista_produktow.php" style="margin-bottom: 11px;">Powrót do listy</a></div>
    <div class="container">
        <form>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Szczegóły produktu</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col" style="margin: 13px;">
                            <fieldset>
                                <legend>Produkt:</legend>
                            </fieldset>
                            <?php
                            include_once 'bazadanych.php';
                            if (isset($_POST['szczegoly'])) {
                                $connect = connect_database();
                                $sql = "SELECT 
                            produkty.id, produkty.nazwa, marka, ilosc, cena, opis, kod_kreskowy, kategoria_id, kontrahenci_id, dokument_id, stan_krytyczny FROM produkty
                            WHERE produkty.id = " . $_POST['id'] . ";";

                                $result = pg_query($connect, $sql);
                                $row = pg_fetch_row($result);
                                echo "<p>ID:&nbsp;<input class='form-control' type='text' readonly='' value='" . $row[0] . "'></p>";
                                echo "<p>Nazwa:&nbsp;<input class='form-control' type='text' readonly='' value='" . $row[1] . "'></p>";
                                echo "<p>Marka:&nbsp;<input name='marka' class='form-control' type='text' readonly='' value='" . $row[2] . "'></p>";
                                echo "<p>Ilość:&nbsp;<input class='form-control' type='text' min='0' readonly='' value='" . $row[3] . "'></p>";
                                echo "<p>Cena:&nbsp;<input class='form-control' type='text' min='0' readonly='' value='" . $row[4] . "'></p>";
                                echo "<p>Stan krytyczny:&nbsp;<input class='form-control' type='text' min='0' readonly='' value='" . $row[10] . "'></p>";
                                //echo "<p class='d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex align-items-center align-items-sm-center align-items-md-center align-items-lg-center align-items-xl-center'>Opis:&nbsp;<textarea class='form-control d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex align-items-center align-items-sm-center align-items-md-center align-items-lg-center align-items-xl-center' readonly=''>" . $row[5] . "</textarea>&nbsp;</p>";
                                echo "<p>Kod kreskowy:&nbsp;<input class='form-control' type='text' readonly='' value='" . $row[6] . "'></p>";
                            }
                            ?>
                        </div>
                        <div class="col" style="margin: 13px;">
                            <fieldset>
                                <legend>Kategoria:</legend>
                            </fieldset>
                            <?php
                            if (isset($_POST['szczegoly'])) {
                                if ($row[7] == NULL) {
                                    echo "Brak kategorii";
                                } else {
                                    $kategoria_select = "SELECT nazwa, vat FROM kategorie WHERE kategorie.id = " . $row[7] . ";";
                                    $kategoria_result = pg_query($connect, $kategoria_select);
                                    $kategoria_row = pg_fetch_row($kategoria_result);
                                    echo "<p>ID:&nbsp;<input class='form-control' type='text' readonly='' value='" . $row[7] . "'></p>";
                                    echo "<p>Nazwa kategorii:&nbsp;<input class='form-control' type='text' readonly='' value='" . $kategoria_row[0] . "'></p>";
                                    echo "<p>Stawka VAT:&nbsp;<input class='form-control' type='text' readonly='' value='" . $kategoria_row[1] . "%'></p>";
                                }
                            }

                            ?>
                        </div>
                        <div class="col" style="margin: 13px;">
                            <!-- <fieldset>
                                <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/datatables.min.css" rel="stylesheet" />
                                <script src="https://cdn.datatables.net/plug-ins/1.13.4/i18n/pl.json"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
                                <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/datatables.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        $('#myTable').DataTable({
                                            "order": [
                                                [1, "asc"]
                                            ],
                                            "columnDefs": [{
                                                "targets": [0],
                                                "visible": true,
                                                "searchable": false,
                                                "orderable": false
                                            }],
                                            "language": {
                                                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/pl.json"
                                            },
                                            "dom": 'Bfrtip',
                                            "buttons": [{
                                                    extend: 'excelHtml5',
                                                    exportOptions: {
                                                        columns: [0, 1, 2, 3, 4]
                                                    }
                                                },
                                                {
                                                    extend: 'pdfHtml5',
                                                    exportOptions: {
                                                        columns: [0, 1, 2, 3, 4]
                                                    }
                                                },
                                                {
                                                    extend: 'print',
                                                    exportOptions: {
                                                        columns: [0, 1, 2, 3, 4]
                                                    }
                                                },
                                            ]
                                        });
                                    });
                                </script> -->
                                
                            <!-- </fieldset> -->
                            <legend>Kontrahent</legend>
                            <?php
                            if (isset($_POST['szczegoly'])) {
                                if ($row[8] == NULL) {
                                    echo "Brak kontrahenta";
                                } else {
                                    $kontrahent_select = "SELECT nazwa, email, phone FROM kontrahenci WHERE kontrahenci.id = " . $row[8] . ";";
                                    $kontrahent_result = pg_query($connect, $kontrahent_select);
                                    $kontrahent_row = pg_fetch_row($kontrahent_result);
                                    echo "<p>ID:&nbsp;<input class='form-control' type='text' readonly='' value='" . $row[8] . "'></p>";
                                    echo "<p>Nazwa:&nbsp;<input class='form-control' type='text' readonly='' value='" . $kontrahent_row[0] . "'></p>";
                                    echo "<p><a href='mailto:" . $kontrahent_row[1] . "'>Adres email</a>:&nbsp;<input class='form-control' type='text' readonly='' value='" . $kontrahent_row[1] . "'></p>";
                                    echo "<p><a href='tel:" . $kontrahent_row[2] . "'>Numer telefonu</a>:&nbsp;<input class='form-control' type='text' readonly='' value='" . $kontrahent_row[2] . "'></p>";
                                }
                            }

                            ?>
                        </div>
                        <div class="col" style="margin: 13px;">
                            <fieldset>
                                <legend>Dokument</legend>
                            </fieldset>
                            <?php
                            if (isset($_POST['szczegoly'])) {
                                if ($row[9] == NULL) {
                                    echo "Brak dokumentu";
                                } else {
                                    $dokument_select = "SELECT nazwa, zrodlo FROM dokumenty WHERE dokumenty.id = " . $row[9] . ";";
                                    $dokument_result = pg_query($connect, $dokument_select);
                                    $dokument_row = pg_fetch_row($dokument_result);
                                    echo "<p>Nazwa dokumentu:&nbsp;<input class='form-control' type='text' readonly='' value='" . $dokument_row[0] . "'></p>";
                                    echo "<a href='" . $dokument_row[1] . "' class='btn btn-primary' type='button'>Pobierz Dokument</a>";
                                }
                                disconnect_database($connect);
                            }

                            ?>
                            <!-- <p>Nazwa dokumentu:<input class="form-control" type="text" readonly=""></p>
                            <button class="btn btn-primary" type="button">Pobierz Dokument</button> -->
                        </div>
                        <!-- <div class="col" style="margin: 13px;">
                            <fieldset>
                                <legend>Zdjęcie Produktu:</legend>
                            </fieldset><img>
                        </div>
                        <div class="row">
                            <?php
                            echo "<p class='d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex align-items-center align-items-sm-center align-items-md-center align-items-lg-center align-items-xl-center'>Opis produktu:&nbsp;<textarea class='form-control d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex align-items-center align-items-sm-center align-items-md-center align-items-lg-center align-items-xl-center' readonly=''>" . $row[5] . "</textarea>&nbsp;</p>";
                            ?>
                        </div> -->
                    </div>
                    <div class="row">
                    <div class="row">
                        <?php
                        $connect = connect_database();
                        $query = "SELECT opis FROM produkty WHERE id = '" . $_POST['id'] . "'";
                        $result = pg_query($connect, $query);
                        $row = pg_fetch_row($result);

                        echo "<p class='d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex align-items-center align-items-sm-center align-items-md-center align-items-lg-center align-items-xl-center'>
                            Opis produktu:&nbsp;
                            <textarea readonly='' name='opis' class='form-control d-flex d-sm-flex d-md-flex d-lg-flex d-xl-flex align-items-center align-items-sm-center align-items-md-center align-items-lg-center align-items-xl-center'>$row[0]</textarea>&nbsp;</p>";
                        ?>
                    </div>
                </div>
        </form>
        <div class="card-footer">
            <div class="btn-group btn-group-sm float-end" role="group">
                <form action='modyfikuj_produkt.php' method='post'>
                    <?php
                    $id = $_POST['id'];
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                    ?>
                    <button class="btn btn-warning" name="modyfikuj" type="submit" style="margin-right: 3px;">Modyfikuj</button>
                </form>
                <form action="lista_produktow.php" method='post'>
                    <?php
                    $id = $_POST['id'];
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                    ?>
                    <button class="btn btn-danger" type="submit" name='usun'>Usuń</button>
                </form>

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