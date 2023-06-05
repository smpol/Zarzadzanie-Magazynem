<?php
function connect_database()
{
    $temp = pg_connect("host={tuw wpisz host} dbname=postgres user=postgres password={haslo} port=5432");
    return $temp;
}

function disconnect_database($connect)
{
    pg_close($connect);
}
