<?php
session_start();
//sprawdzenie czy użytkownik jest zalogowany
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

        <h1 style="text-align: center;" class="mb-xl-4 mt-xl-4">Kokpit</h1>
        <?php
        if (isset($_GET['success'])) {
            echo "<div class='alert alert-success' role='alert'><span>Witaj ";
            echo $_SESSION['username'];
            echo "!&nbsp;Na górze znajdują się operacje dostępne teraz po zalogowaniu się</span></div>";
        }
        ?>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Status magazynu</h4>
                    </div>
                    <div class="card-bottom">
                        <?php
                        require_once "bazadanych.php";
                        $connect = connect_database();
                        $sql = "SELECT count(*) FROM produkty WHERE stan_krytyczny >= ilosc AND stan_krytyczny IS NOT NULL";
                        $result = pg_query($connect, $sql);
                        $data = pg_fetch_all($result);
                        if ($data[0]['count'] == 0) {
                            echo "<div class='alert alert-success' role='alert'><span>Wszystkie produkty są w stanie dobrym</span></div>";
                        } else {
                            echo "<div class='alert alert-danger' role='alert'><span>Uwaga! W magazynie znajdują się produkty w stanie krytycznym</span>";
                            echo "<br>Liczba produktów w stanie krytycznym: " . $data[0]['count'] . "";
                            echo "<br><br>Lista produktów w stanie krytycznym:<br>";
                            $sql = "SELECT nazwa, ilosc, stan_krytyczny FROM produkty WHERE stan_krytyczny >= ilosc AND stan_krytyczny IS NOT NULL";
                            $result = pg_query($connect, $sql);
                            $data = pg_fetch_all($result);
                            echo "<div class='table-responsive'>";
                            echo "<table class='table table-striped table-hover table-bordered text-center'>";
                            echo "<thead class='thead-dark'>";
                            echo "<tr>";
                            echo "<th>Nazwa</th>";
                            echo "<th>Ilość</th>";
                            echo "<th>Stan krytyczny</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            foreach ($data as $row) {
                                echo "<tr>";
                                echo "<td>" . $row['nazwa'] . "</td>";
                                echo "<td>" . $row['ilosc'] . "</td>";
                                echo "<td>" . $row['stan_krytyczny'] . "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                    <div class="card-footer float-end">
                        <a href="lista_produktow.php" class="btn btn-primary btn-sm" type="button">Przejdź do listy produktów</a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center">Statystyki</h4>
                    </div>
                    <div class="card-body">
                        <div class="col">
                            <p class="text-center">Ilość produktów w magazynie według kategorii</p>
                            <div style="width: 90%; margin: 0 auto;">

                            <canvas id="doughnut-chart" style="margin: 5px;"></canvas></div>
                        </div>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
                        <?php
                        require_once "bazadanych.php";
                        $connect = connect_database();
                        $sql = "SELECT count(kategoria_id) as ilosc, kategorie.nazwa FROM produkty INNER JOIN kategorie ON produkty.kategoria_id=kategorie.id GROUP BY kategorie.nazwa";
                        $result = pg_query($connect, $sql);
                        $data = pg_fetch_all($result);
                        $sql_null = "SELECT count(*) FROM produkty WHERE kategoria_id IS NULL";
                        $result_null = pg_query($connect, $sql_null);
                        $data_null = pg_fetch_all($result_null);
                        $count_null = $data_null[0]['count'];
                        ?>
                        <script>
                            const ctx = document.getElementById('doughnut-chart');
                            new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    labels: [<?php
                                                foreach ($data as $row) {
                                                    echo '"' . $row['nazwa'] . '",';
                                                }
                                                if ($count_null > 0)
                                                    echo '"Brak kategorii",';
                                                ?>],
                                    datasets: [{
                                        data: [<?php foreach ($data as $row) {
                                                    echo '"' . $row['ilosc'] . '",';
                                                }
                                                if ($count_null > 0)
                                                    echo '"' . $count_null . '",'; ?>],
                                        borderWidth: 1,
                                        backgroundColor: [
                                            <?php
                                            foreach ($data as $row) {
                                                echo '"' . sprintf('#%06X', mt_rand(0, 0xFFFFFF)) . '",';
                                            }
                                            if ($count_null > 0)
                                                echo '"' . sprintf('#%06X', mt_rand(0, 0xFFFFFF)) . '",';
                                            ?>
                                        ],
                                    }]
                                },
                                options: {
                                    // scales: {
                                    //     y: {
                                    //         beginAtZero: true
                                    //     }
                                    // }
                                    // resposive: true,
                                }
                            });
                        </script>
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
        <script src="files/js/Ludens---Create-Edit-Form-Ludens---1-Index-Table-with-Search--Sort-Filters-v20-1.js"></script>
        <script src="files/js/Ludens---Create-Edit-Form-Ludens---1-Index-Table-with-Search--Sort-Filters-v20.js"></script>
        <script src="files/js/Ludens---Create-Edit-Form-Ludens---Sleek-Image-Input-with-Preview.js"></script>
        <script src="files/js/Ludens---Create-Edit-Form-theme.js"></script>
</body>

</html>