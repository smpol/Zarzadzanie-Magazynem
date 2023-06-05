<?php
require_once('bazadanych.php');
session_start();
$connect = connect_database();
if(isset($_POST['username']) && isset($_POST['password']))
{
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $query = "SELECT id, username, user_password FROM users WHERE username = '$username'";
    $result = pg_query($connect, $query);
    $row = pg_fetch_assoc($result);
    if (password_verify($password, $row['user_password']))
    {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        //generate unique uid md5(uniqid(rand(), true))
        $_SESSION['session_id'] = md5(uniqid(rand(), true));
        $query="UPDATE users SET session_id = '".$_SESSION['session_id']."' WHERE id = '".$_SESSION['user_id']."'";
        $result = pg_query($connect, $query);
        header("Location: kokpit.php?success=1");
    }
    else
    {
        header('Location: zaloguj.php?error=1');
    }
}
else {
    header('Location: zaloguj.php?error=1');
}
