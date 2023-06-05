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
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if (isset($_POST['przyjmij']))
            {
                $tablica_id = $_POST['id'];
                $tablica_ilosc = $_POST['ilosc'];
                foreach ($tablica_id as $key => $value)
                {
                    $id = $value;
                    $ilosc = $tablica_ilosc[$key];
                    $connect = connect_database();
                    $select = "SELECT ilosc FROM produkty WHERE id = '$id'";
                    $result = pg_query($connect, $select);
                    $row = pg_fetch_assoc($result);
                    $ilosc_baza = $row['ilosc'];
                    $ilosc_baza = $ilosc_baza + $ilosc;
                    $update = "UPDATE produkty SET ilosc = '$ilosc_baza' WHERE id = '$id'";
                    $result = pg_query($connect, $update);
                    disconnect_database($connect);
                }         
                if ($result)
                {
                    echo '<div class="alert alert-success" role="alert">Produkty zostały przyjęte</div>';
                }
                else
                {
                    echo '<div class="alert alert-danger" role="alert">Produkty nie zostały przyjęte</div>';
                }

                    
            }
        }
        
        ?>
        <form method="POST" action="hurt_dodawanie.php">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Przyjmij produkty</h4>
                </div>
                <div class="card-body">
                    <h4>Wybierz produkty do przyjęcia:</h4>
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/pl.js"></script>
                    <select class="form-control" id="produkty">
                        <option></option>
                        <?php
                        require_once('bazadanych.php');
                        $connect = connect_database();
                        $select = "SELECT id, nazwa, ilosc FROM produkty WHERE ilosc > 0 ORDER BY nazwa";
                        $result = pg_query($connect, $select);
                        while ($row = pg_fetch_assoc($result)) {
                            echo '<option value="' . $row['id'] . '">' . $row['nazwa'] . ' (' . $row['ilosc'] . ')</option>';
                        }
                        ?>
                    </select>
                    <script>
                        $('#produkty').select2({
                            placeholder: "Wybierz produkty",
                            allowClear: true
                        })
                    </script>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered tablesorter">
                            <thead>
                                <tr>
                                    <th>Nazwa</th>
                                    <th>Ilość do dodania</th>
                                    <th>Usuń</th>
                                </tr>
                            </thead>
                            <tbody id="tabelka">
                                <script>
                                //add selected option to table from select2 and delete from select2
                                    $('#produkty').on('select2:select', function(e) {
                                        var data = e.params.data;
                                        var option = new Option(data.text, data.id, false, false);
                                        $(this).append(option).trigger('change');
                                        var id = data.id;
                                        var nazwa = data.text;
                                        var ilosc = data.element.dataset.ilosc;
                                        
                                        var row = '<tr id="row' + id + '"><td>' + nazwa + '</td><td><input type="hidden" name="id[]" value="' + id + '"><input type="number" class="form-control" name="ilosc[]" value="1" min="1" max="' + ilosc + '"></td><td><button type="button" name="remove" id="' + id + '" class="btn btn-danger btn_remove">X</button></td></tr>';
                                        $('#tabelka').append(row);
                                        $('#produkty option[value="' + id + '"]').remove();

                                    });
                                    //delete row from table and add to select2
                                    $(document).on('click', '.btn_remove', function() {
                                        var button_id = $(this).attr("id");
                                        var nazwa = $(this).closest("tr").find("td:eq(0)").text();
                                        var ilosc = $(this).closest("tr").find("td:eq(1)").find("input").val();
                                        var option = new Option(nazwa, button_id, false, false);
                                        $('#produkty').append(option).trigger('change');
                                        $('#row' + button_id + '').remove();
                                    });
                                    </script>
                            </tbody>
                        </table>


                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" name="przyjmij">Przyjmij</button>
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