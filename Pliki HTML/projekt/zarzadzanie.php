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
    <meta name="robots" content="noindex, nofollow" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="utf-8">
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
        <h1 style="text-align: center;" class="mb-xl-4 mt-xl-4">Zarządzanie kontem</h1>
        <?php
        require_once 'bazadanych.php';
        $connect = connect_database();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['zmianahasla'])) {
                $starehaslo = htmlspecialchars($_POST['stare_haslo']);
                $nowehaslo1 = htmlspecialchars($_POST['nowe_haslo1']);
                $nowehaslo2 = htmlspecialchars($_POST['nowe_haslo2']);
                $id = htmlspecialchars($_POST['id']);
                $sql = "SELECT user_password FROM users WHERE id = '$id'";
                $result = pg_query($connect, $sql);
                $row = pg_fetch_row($result);
                if (strcmp($nowehaslo1, $nowehaslo2) != 0) {
                    echo "<div class='alert alert-danger' role='alert'>Podane hasła nie są identyczne!</div>";
                } else if (password_verify($starehaslo, $row[0])) {
                    $temphaslo = password_hash($nowehaslo1, PASSWORD_DEFAULT);
                    $sql = "UPDATE users SET user_password = '$temphaslo' WHERE id = '$id'";
                    $result = pg_query($connect, $sql);
                    if ($result) {
                        echo "<div class='alert alert-success' role='alert'>Hasło zostało zmienione!</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Wystąpił błąd podczas zmiany hasła!</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Podane stare hasło jest nieprawidłowe!</div>";
                }
            }
            if (isset($_POST['dodaj'])) {
                $login = htmlspecialchars($_POST['login']);
                $haslo = htmlspecialchars($_POST['haslo']);
                $temphaslo = password_hash($haslo, PASSWORD_DEFAULT);
                $sql = "INSERT INTO users (username, user_password) VALUES ('$login', '$temphaslo')";
                $result = pg_query($connect, $sql);
                if ($result) {
                    echo "<div class='alert alert-success' role='alert'>Użytkownik został dodany!</div>";
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Wystąpił błąd podczas dodawania użytkownika!</div>";
                }
            }
            if (isset($_POST['usun'])) {
                $haslo = htmlspecialchars($_POST['haslo']);
                $id = htmlspecialchars($_POST['uzytkownik']);
                $sql = "SELECT user_password FROM users WHERE id = '$id'";
                $result = pg_query($connect, $sql);
                $row = pg_fetch_row($result);

                $sqladmin = "SELECT user_password FROM users WHERE id = '1'";
                $resultadmin = pg_query($connect, $sqladmin);
                $rowadmin = pg_fetch_row($resultadmin);
                if (password_verify($haslo, $rowadmin[0])) {
                    $sql = "DELETE FROM users WHERE id = '$id'";
                    $result = pg_query($connect, $sql);
                    if ($result) {
                        echo "<div class='alert alert-success' role='alert'>Użytkownik został usunięty!</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Wystąpił błąd podczas usuwania użytkownika!</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Podane hasło jest nieprawidłowe!</div>";
                }
            }
        }
        ?>
    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Zmiana hasła</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <p class="text-start">Wprowadź stare hasło:</p><input name="stare_haslo" class="border rounded form-control" type="password" required="" style="margin-bottom: 0px;" autocapitalize="current-password">
                            <p>Wprowadź nowe hasło:</p><input name="nowe_haslo1" class="border rounded form-control" type="password" required="" style="margin-bottom: 0px;" autocomplete="new-password">
                            <p>Wprowadź nowe hasło jeszcze raz:</p><input name="nowe_haslo2" class="border rounded form-control" type="password" required="" style="margin-bottom: 11px;" autocomplete="new-password">
                            <input type="hidden" name="id" value="<?php echo $_SESSION['user_id'] ?>">
                            <p><input class="btn btn-primary" type="submit" name="zmianahasla" value="Zmień Hasło"></p>
                        </form>
                    </div>
                </div>
                <?php
                if ($_SESSION['user_id'] == 1) {
                    echo "<div class='row' id='admin_panel'>
                    <div class='col'>
                        <div class='card'>
                            <div class='card-header'>
                                <h5 class='mb-0'>Dodaj użytkownika</h5>
                            </div>
                            <div class='card-body'>
                                <form method='POST'>
                                    <p class='text-start'>Wprowadź login:</p><input name='login' class='border rounded form-control' type='text'>
                                    <p>Wprowadź hasło dla użytkownika:</p><input name='haslo' class='border rounded form-control' type='password' required='' style='margin-bottom: 11px;' autocomplete='new-password'>
                                    <p><input class='btn btn-primary' name='dodaj' type='submit' value='Dodaj użytkownika'></p>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class='col'>
                        <div class='card'>
                            <div class='card-header'>
                                <h5 class='mb-0'>Usuń Użytkownika</h5>
                            </div>
                            <div class='card-body'>
                                <form method='POST'>
                                    <p class='text-start'>Wybierz użytkownika</p>
                                    <select name='uzytkownik' class='form-select'>";
                    include_once 'bazadanych.php';
                    $connect = connect_database();
                    $sql = "SELECT id, username FROM users";
                    $result = pg_query($connect, $sql);
                    while ($row = pg_fetch_row($result)) {
                        if ($row[0] != 1) {
                            echo "<option value='$row[0]'>$row[1]</option>";
                        }
                    }
                    echo "</select>
                                    <p>Wprowadź swoje hasło</p><input name='haslo' class='border rounded form-control' type='password' required='' style='margin-bottom: 11px;' autocomplete='current-password'>
                                    <p><input name='usun' class='btn btn-primary' type='submit' value='Usuń użytkownika'></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>";
                }

                ?>


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