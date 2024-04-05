<?php
function logout(): void
{
    unset($_SESSION['user']);
    unset($_SESSION['errors']);
    unset($_SESSION['messages']);
    unset($_SESSION['old']);

    header('Location: index.php');
    exit();
}

@include_once(__DIR__ . '/src/Helpers/Auth.php');


function login($customer): bool
{
    // Here you can set the user data in the session
    $_SESSION['user'] = $customer;
    
    // Return true to indicate successful login
    return true;
}
