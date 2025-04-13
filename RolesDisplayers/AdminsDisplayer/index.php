<?php
    $lastPage = $_SERVER['HTTP_REFERER'] ?? '../../Main/index.php';
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
        <h1>Lista administratorów</h1>
        <div class="user-list">
            <?php
                require("../../Classes/index.php");
                session_start();
                
                $uDatabase = $_SESSION['Database'];
                $count = 0;

                echo $uDatabase[0]->getName();
                foreach ($uDatabase as $user) {
                    if($user->getPermissionLevel() == 3)
                    {
                        echo "<div class='user-item'>
                            <p><strong>ID:</strong> " . $user->ID . "</p>
                            <p><strong>Imię:</strong> " . $user->getName() . "</p>
                            <p><strong>Hasło:</strong> " . $user->getPassword() . "</p>
                            <p><strong>Poziom uprawnień:</strong> " . $user->getPermissionLevel() . "</p>
                            </div>";
                            
                            $count++;
                    }
                }

                if($count == 0)
                {
                    echo "<div class='no-users'><p>Brak Administratorów</p></div>";
                }

            ?>
        </div>
        <a href="<?php echo $lastPage; ?>" class="back-button">Powrót</a>
    </div>
</body>
</html>
