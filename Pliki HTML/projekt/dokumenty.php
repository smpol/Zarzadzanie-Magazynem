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
        <h1 style="text-align: center;" class="mb-xl-4 mt-xl-4">Dokumenty</h1>
    </div>
    <div class="container">
        <?php
        include_once 'bazadanych.php';
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $connect = connect_database();

            if (isset($_POST['usun'])) {
                $zapytanie = "SELECT zrodlo from dokumenty where id=" . $_POST['id'];
                $wynik = pg_query($connect, $zapytanie);
                $wiersz = pg_fetch_array($wynik);
                $plik = $wiersz['zrodlo'];
                unlink($plik);


                $id = $_POST['id'];
                $sql = "DELETE FROM dokumenty WHERE id = $id";
                $result = pg_query($connect, $sql);
                if ($result) {
                    echo "<div class='alert alert-success' role='alert'>Pomyślnie usunięto dokument</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Nie udało się usunąć dokumentu</div>";
                }
            }


            if (isset($_POST['upload'])) {

                $upload_dest = 'uploads/';
                $file_name = $_FILES['plik']['name'];
                $file_tmp = $_FILES['plik']['tmp_name'];
                $file_type = $_FILES['plik']['type'];
                $file_size = $_FILES['plik']['size'];
                $file_error = $_FILES['plik']['error'];
                $exploded = explode('.', $file_name);
                $last_element = end($exploded);
                $file_extension = strtolower($last_element);
                $allowed_extensions = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'ods', 'odt', 'odp', 'ppt', 'pptx', 'zip', 'rar', '7z');
                $error = 0;
                // catch errors
                if (empty($file_name)) {
                    echo "<div class='alert alert-danger' role='alert'>Nie wybrano pliku</div>";
                    $error = 1;
                } else if (in_array($file_extension, $allowed_extensions) === false) {
                    echo "<div class='alert alert-danger' role='alert'>Nieprawidłowy format pliku<br \>";
                    echo "Dozwolone formaty: ";
                    foreach ($allowed_extensions as $value) {
                        echo $value . ", ";
                    }
                    echo "</div>";
                    $error = 1;
                }
                //check POST Content-Length
                else if ($_SERVER['CONTENT_LENGTH'] > 20971520) {
                    echo "<div class='alert alert-danger' role='alert'>Plik jest za duży</div>";
                    $error = 1;
                } else if ($file_size > 20971520) {
                    echo "<div class='alert alert-danger' role='alert'>Plik jest za duży</div>";
                    $error = 1;
                } else if ($file_error !== 0) {
                    echo "<div class='alert alert-danger' role='alert'>Wystąpił błąd podczas przesyłania pliku</div>";
                    $error = 1;
                } else if ($error == 0) {
                    //make unique name for file
                    $file_name = uniqid('', true) . '.' . $file_extension;
                    $plik = $upload_dest . $file_name;
                    if (move_uploaded_file($file_tmp, $plik)) {
                        echo "<div class='alert alert-success' role='alert'>Plik został przesłany</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Wystąpił błąd podczas przesyłania pliku</div>";
                    }

                    $nazwa = htmlspecialchars($_POST['nazwa']);
                    $orygninalna_nazwa = htmlspecialchars($_FILES['plik']['name']);
                    $query = "INSERT INTO dokumenty (nazwa, zrodlo, oryginalna_nazwa) VALUES ('$nazwa', '$plik', '$orygninalna_nazwa')";
                    $result = pg_query($connect, $query);
                }
            }
            disconnect_database($connect);
        }
        ?>
        <div class="text-center"><a class="btn btn-primary" data-bs-toggle="collapse" aria-expanded="false" aria-controls="collapse-1" href="#collapse-1" role="button" style="margin-bottom: 16px;">Dodaj Dokument</a>
            <div class="collapse" id="collapse-1" style="padding-bottom: 29px;">
                <form method="POST" enctype="multipart/form-data">
                    <div class="card">
                        <div class="card-header" style="padding-bottom: 0px;padding-top: 12px;">
                            <p class="text-start">Dodawanie Dokumentu</p>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="MAX_FILE_SIZE" value="20971520">
                            <p class="text-start">Nazwa pliku</p><input name="nazwa" class="form-control" type="text" style="margin-bottom: 11px;" required="">
                            <p class="text-start">Wgraj Plik</p>
                            <input name="plik" class="form-control" type="file" required="" style="margin-bottom: 11px;">

                            <script>
                                //check file size
                                $('input[type="file"]').change(function(e) {
                                    var fileName = e.target.files[0].name;
                                    var fileSize = e.target.files[0].size;
                                    if (fileSize > 20971520) {
                                        alert("Plik jest za duży. Maksymalny rozmiar pliku to 20MB");
                                        $('input[type="file"]').val('');
                                    }
                                });
                            </script>
                            <input class="btn btn-success" type="submit" name="upload">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="table-responsive ps-md-2">
            <table class="table table-striped" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nazwa Dokumentu</th>
                        <th>Akcje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include_once  'bazadanych.php';
                    $connect = connect_database();
                    $query = "SELECT id, nazwa, zrodlo, oryginalna_nazwa FROM dokumenty";
                    $result = pg_query($connect, $query);

                    $count = pg_num_rows($result);
                    echo "<input type='hidden' id='count' value='$count'>";
                    if ($count == 0) {
                        echo "<tr><td colspan='5' style='text-align: center;'>Brak dokumentów</td></tr>";
                    } else {

                        while ($row = pg_fetch_row($result)) {
                            echo "<tr>";
                            echo "<td style='width: 31.062px;text-align: center;'>$row[0]</td>";
                            echo "<td>$row[1]</td>";
                            echo "<td class='ms-md-0' style='position: relative;'><a class='btn btn-primary' role='button' style='border-style: none;' href='" . $row[2] . "' download='" . $row[3] . "'>Pobierz</a>";
                            echo "<form method='POST' style='float:left;'>";
                            echo "<input type='hidden' name='id' value='$row[0]'>";
                            echo "<button class='btn btn-primary' name='usun' type='submit' style='background: var(--bs-red);border-style: none;margin: 1px;'>Usuń</button></td>";
                            echo "</form>";
                            echo "</tr>";
                        }
                    }
                    disconnect_database($connect);
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
                                "targets": [2],
                                "visible": true,
                                "searchable": false,
                                "orderable": false
                            }, {
                                "targets": 0,
                                "type": "num",
                                "orderable": false,
                                "serchable": true

                            }],
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.13.4/i18n/pl.json"
                            },
                            "dom": 'Bfrtip',
                            "buttons": [

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