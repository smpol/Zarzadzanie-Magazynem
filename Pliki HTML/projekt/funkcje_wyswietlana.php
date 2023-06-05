<?php
function wyswietl_menu()
{
    echo '
    <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link active" href="kokpit.php">Kokpit</a></li>
        <li class="nav-item"><a class="nav-link active" href="lista_produktow.php">Lista Produktów</a></li>
        <li class="nav-item"><a class="nav-link active" href="dodaj_produkt.php">Dodaj produkt</a></li>
        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="color: var(--bs-navbar-brand-color);">Hurtowe operacje</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="hurt_dodawanie.php">Przyjmij produkty</a>
            <a class="dropdown-item" href="hurt_wydawanie.php">Wydaj produkty</a>
            ';
            //echo'<a class="dropdown-item" href="dodaj_produkt.php">Historia</a>';
        echo'</div>
        </li>
        <li class="nav-item dropdown"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#" style="color: var(--bs-navbar-brand-color);">Inne</a>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="dokumenty.php">Dokumenty</a>
            <a class="dropdown-item" href="kategorie.php">Kategorie </a>
            <a class="dropdown-item" href="kontrahenci.php">Kontrahenci</a>
            <a class="dropdown-item" href="zarzadzanie.php">Zarzadzanie Kontem</a>
        </div>
        </li>
    </ul>';
}

function logowanie($bool)
{
    if ($bool) {
        echo '<a class="btn btn-primary" role="button" href="logout.php">Wyloguj się</a>';
    } else if (!$bool) {
        echo '<ul class="navbar-nav mx-auto"></ul>';
        echo '<a class="btn btn-primary" role="button" href="zaloguj.php">Zaloguj się</a>';
    }
}

function status_database($database)
{
    if (!$database) {
        echo '<div class="alert alert-danger" role="alert">Brak połączenia z bazą danych</div>';
    }
}
