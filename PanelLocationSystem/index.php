<?php
    require("../Classes/index.php");
    session_start();

    $uDatabase = $_SESSION['Database'];
    $user = $uDatabase[$_SESSION['loggedID'] - 1];

    switch($user->getPermissionLevel())
    {
        case 1: 
            header("Location: ../Panels/UserPanel/index.php");
            exit;
        
        case 2: 
            header("Location: ../Panels/ModeratorPanel/index.php");
            exit;
        
        case 3:
            header("Location: ../Panels/AdminPanel/index.php");
            exit;
        
        default:
            throw new Exception();
    }

?>