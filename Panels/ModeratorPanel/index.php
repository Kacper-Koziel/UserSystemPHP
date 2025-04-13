<?php
    require("../../Classes/index.php");
    session_start();

    $uDatabase = &$_SESSION['Database'];
    $user = $uDatabase[$_SESSION['loggedID'] - 1];

    if($user->getPermissionLevel() != 2)
    {
        header('Location: ../../Main/index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../AdminPanel/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
</head>
<body>
    <div class="panel">
        <div class="row">
            <div class="title">
                <?php echo "<h1> Witaj, " . $user->getName() . "! </h1>";
                echo "<h3> Uprawienia: " . $user->getRole()->value . " </h3>"; ?>
            </div>

            <div class="statistics">
                <h1>Statystyki systemu: </h1>
                <div class="badges">

                    <a href="../../Displayer/index.php">
                        <div class="badge">
                            <h3>Ilość wszystkich użytkowników:</h3>
                            <h3 class="amount"><?= $_SESSION['usersCount'] ?></h3>
                        </div>
                    </a>

                    <a href="../../RolesDisplayers/ModeratorsDisplayer/index.php">
                        <div class="badge">
                            <h3>Ilość wszystkich moderatorów:</h3>
                            <h3 class="amount"><?= $_SESSION['modCount'] ?></h3>
                        </div>
                    </a>
                    
                    <a href="../../RolesDisplayers/AdminsDisplayer/index.php">
                        <div class="badge">
                            <h3>Ilość wszystkich administratorów:</h3>
                            <h3 class="amount"><?= $_SESSION['adminsCount'] ?></h3>
                        </div>
                    </a>

                    <a href="../../RolesDisplayers/UsersDisplayer/index.php">
                        <div class="badge">
                            <h3>Ilość zwykłych użytkowników:</h3>
                            <h3 class="amount"><?= $_SESSION['usersCount'] - ($_SESSION['modCount'] + $_SESSION['adminsCount']) ?></h3>
                        </div>
                    </a>
                    
                </div>
                
                
            </div>
        </div>
        <div class="row">
            <div class="container">
                <a href="../../Displayer/index.php" class="messages">Zobacz wszystkich użytkowników</a>
                <a href="../../Messages/index.php">Wiadomości</a>
                <a href="../../BlockedUsers/index.php">Zablokowani użytkownicy</a>
                <a href="../../DisplayContacts/index.php">Kontakty</a>
                <a href="../../GroupsDisplayer/index.php">Grupy</a>
                <a href="../../Login/index.php">Wyloguj</a>
            </div>
        </div>
    </div>
</body>
</html>
