<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: zaloguj.php');
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
        <h1 style="text-align: center;" class="mb-xl-4 mt-xl-4">Lista Produktów</h1>
        <?php
        include_once 'bazadanych.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $connection = connect_database();
            if (isset($_POST['usun'])) {
                $id = htmlspecialchars($_POST['id']);
                $sql = "DELETE FROM produkty WHERE id = $id";
                $query = pg_query($connection, $sql);
                if ($query) {
                    // echo "<div class='alert alert-success' role='alert'>Produkt został usunięty</div>";
                    echo "<div class='alert alert-success' role='alert'>Produkt o id: $id został usunięty</div>";
                } else {
                    //echo "<div class='alert alert-danger' role='alert'>Produkt nie został usunięty</div>";
                    echo "<div class='alert alert-danger' role='alert'>Produkt o id: $id nie został usunięty</div>";
                }
            }
            if (isset($_POST['dodaj'])) {
                $nazwa_produktu = htmlspecialchars($_POST['nazwa_produktu']);
                $marka = htmlspecialchars($_POST['marka']);
                $ilosc = htmlspecialchars($_POST['ilosc']);
                $cena = htmlspecialchars($_POST['cena']);
                if ($_POST['opis'] == "") {
                    $opis = NULL;
                } else {
                    $opis = htmlspecialchars($_POST['opis']);
                }
                if ($_POST['kod_kreskowy'] == "") {
                    $kod_kreskowy = NULL;
                } else {
                    $kod_kreskowy = htmlspecialchars($_POST['kod_kreskowy']);
                }
                if ($_POST['kategoria'] == "null") {
                    $kategoria = NULL;
                } else {
                    $kategoria = htmlspecialchars($_POST['kategoria']);
                }
                if ($_POST['kontrahent'] == "null") {
                    $kontrahent = NULL;
                } else {
                    $kontrahent = htmlspecialchars($_POST['kontrahent']);
                }
                if ($_POST['dokument'] == "null") {
                    $dokument = NULL;
                } else {
                    $dokument = htmlspecialchars($_POST['dokument']);
                }
                if ($_POST['stan_krytyczny'] == "") {
                    $stan_krytyczny = NULL;
                } else {
                    $stan_krytyczny = htmlspecialchars($_POST['stan_krytyczny']);
                }
                //dodac zdjecia

                //timestamptz
                //$date = date('Y-m-d H:i:s');
                $query = "INSERT INTO
                produkty (nazwa, opis, marka, ilosc, cena, stan_krytyczny, kategoria_id, kontrahenci_id, dokument_id, kod_kreskowy, data_dodania)
                VALUES
                ('$nazwa_produktu', 
                '$opis', 
                '$marka', 
                '$ilosc', 
                '$cena',
                '$stan_krytyczny',";
                if ($kategoria == NULL) {
                    $query = $query . "NULL,";
                } else {
                    $query = $query . "'$kategoria',";
                }
                if ($kontrahent == NULL) {
                    $query = $query . "NULL,";
                } else {
                    $query = $query . "'$kontrahent',";
                }
                if ($dokument == NULL) {
                    $query = $query . "NULL,";
                } else {
                    $query = $query . "'$dokument',";
                }

                if ($kod_kreskowy == NULL) {
                    //$query = $query."NULL)";
                    $query = $query . "NULL,";
                } else {
                    //$query = $query."'$kod_kreskowy')";
                    $query = $query . "'$kod_kreskowy',";
                }
                $query = $query . "CURRENT_TIMESTAMP)";
                $result = pg_query($connection, $query);
                if ($result) {
                    echo "<div class='alert alert-success' role='alert'>Produkt został dodany</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Produkt nie został dodany</div>";
                }
            }
            disconnect_database($connection);
        }
        if (isset($_POST['modyfikuj'])) {
            $connection = connect_database();
            $query = "UPDATE produkty SET ";
            $query = $query . "nazwa = '" . htmlspecialchars($_POST['nazwa_produktu']) . "', ";
            $query = $query . "marka = '" . htmlspecialchars($_POST['marka']) . "', ";
            $query = $query . "ilosc = '" . htmlspecialchars($_POST['ilosc']) . "', ";
            $query = $query . "cena = '" . htmlspecialchars($_POST['cena']) . "', ";
            if ($_POST['opis'] == "") {
                $query = $query . "opis = NULL, ";
            } else {
                $query = $query . "opis = '" . htmlspecialchars($_POST['opis']) . "', ";
            }
            if ($_POST['kod_kreskowy'] == "") {
                $query = $query . "kod_kreskowy = NULL, ";
            } else {
                $query = $query . "kod_kreskowy = '" . htmlspecialchars($_POST['kod_kreskowy']) . "', ";
            }
            if ($_POST['kategoria'] == "null") {
                $query = $query . "kategoria_id = NULL, ";
            } else {
                $query = $query . "kategoria_id = '" . htmlspecialchars($_POST['kategoria']) . "', ";
            }
            if ($_POST['kontrahent'] == "null") {
                $query = $query . "kontrahenci_id = NULL, ";
            } else {
                $query = $query . "kontrahenci_id = '" . htmlspecialchars($_POST['kontrahent']) . "', ";
            }
            if ($_POST['stan_krytyczny'] == "") {
                $query = $query . "stan_krytyczny = NULL, ";
            } else {
                $query = $query . "stan_krytyczny = '" . htmlspecialchars($_POST['stan_krytyczny']) . "', ";
            }
            if ($_POST['dokument'] == "null") {
                $query = $query . "dokument_id = NULL ";
            } else {
                $query = $query . "dokument_id = '" . htmlspecialchars($_POST['dokument']) . "' ";
            }
            
            //dodac zdjecia
            $query = $query . "WHERE id = '" . htmlspecialchars($_POST['id']) . "'";
            
            $result = pg_query($connection, $query);
            if ($result) {
                echo "<div class='alert alert-success' role='alert'>Produkt został zmodyfikowany</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Produkt nie został zmodyfikowany<br>";
                // echo $query;
                echo "</div>";
            }
        }
        ?>
    </div>
    <div class="container">
        <div class="table-responsive ps-md-2">
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nazwa Produktu</th>
                        <th>Marka</th>
                        <th>Ilość</th>
                        <th>Cena (zł)</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once 'bazadanych.php';
                    $connection = connect_database();
                    $sql = "SELECT id, nazwa, marka, ilosc, cena FROM produkty";
                    $result = pg_query($connection, $sql);
                    $count = pg_num_rows($result);
                    echo "<input type='hidden' id='count' value='$count'>";
                    if ($count == 0) {
                        echo "<tr><td colspan='6' style='text-align: center;'>Brak produktów</td></tr>";
                    } else {

                        while ($row = pg_fetch_row($result)) {
                            echo "<tr>";
                            echo "<td style='width: 110.062px;text-align: center;'>$row[0]</td>";
                            echo "<td>$row[1]</td>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[3]</td>";
                            echo "<td>$row[4]</td>";
                            echo "<td class='ms-md-0' style='position: relative;'>";
                            echo "<form method='POST' action='szeczgoly_produktu.php' style='float: left'>";
                            echo "<input type='hidden' name='id' value='$row[0]'>";
                            echo "<button class='btn btn-primary' type='subbmit' name='szczegoly' style='background: var(--bs-blue);border-style: none;margin: 1px;'>Szczegóły</button>";
                            echo "</form>";
                            echo "<form method='POST' action='modyfikuj_produkt.php' style='float: left'>";
                            echo "<input type='hidden' name='id' value='$row[0]'>";
                            echo "<button class='btn btn-primary' type='subbmit' name='modyfikuj' style='background: var(--bs-warning);border-style: none;margin: 1px;'>Modyfikuj</button>";
                            echo "</form>";
                            echo "<form method='POST' style='float: left'>";
                            echo "<input type='hidden' name='id' value='$row[0]'>";
                            echo "<button class='btn btn-primary' type='subbmit' name='usun' style='background: var(--bs-red);border-style: none;margin: 1px;'>Usuń</button></td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <link href="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/datatables.min.css" rel="stylesheet" />
            <script src="https://cdn.datatables.net/plug-ins/1.13.4/i18n/pl.json"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <script src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.4/b-2.3.6/b-html5-2.3.6/b-print-2.3.6/r-2.4.1/sc-2.1.1/datatables.min.js"></script>
            <script>
                var count = document.getElementById("count").value;
                if (count > 0) {
                    $(document).ready(function() {
                        $('#myTable').DataTable({
                            "order": [
                                [1, "asc"]
                            ],
                            "columnDefs": [{
                                    "targets": 5,
                                    "visible": true,
                                    "searchable": false,
                                    "orderable": false
                                },
                                {
                                    "targets": 0,
                                    "type": "num",
                                    "orderable": false,
                                    "serchable": true

                                }, {

                                    "targets": [0, 3],
                                    "type": "num",
                                }, {

                                    "targets": 4,
                                    "type": "html-num",
                                }
                            ],
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
                }
            </script>
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