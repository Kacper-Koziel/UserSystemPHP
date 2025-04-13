<?php
    $lastPage = $_SERVER['HTTP_REFERER'] ?? '../Main/index.php';
    require("../Classes/index.php");
    session_start();
    
    $uDatabase = &$_SESSION['Database'];
    $user = $uDatabase[$_SESSION['loggedID'] - 1];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista użytkowników</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Zablokowani użytkownicy</h1>
        <div class="user-list">
            <?php

                $counter = 0;

                foreach ($uDatabase as $other) {

                    if($user->isBLocked($other->ID))
                    {
                        echo "<div class='user-item'>
                        <p><strong>Imię:</strong> " . $other->getName() . "</p>
                        </div>";
                        $counter++;
                    }

                }

                if($counter == 0)
                {
                    echo "<div class='no-users'><p>Brak zablokowanych użytkowników</p></div>";
                }
            ?>
        </div>
        <a href="../BlockUser/index.php">Zablokuj użytkownika</a>
        <a href="../UnlockUser/index.php">Odblokuj użytkownika</a>
        <a href="../PanelLocationSystem/index.php" class="back-button">Powrót</a>
    </div>
</body>
</html>
