<?php
    require("../Classes/index.php");
    session_start();
    
    $uDatabase = &$_SESSION['Database'];
    $user = $uDatabase[$_SESSION['loggedID'] - 1];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <form method="POST">
        <h1>Odblokuj użytkownika</h1>
        <div class="input-group">
            <label for="username">Nazwa użytkownika</label>
            <input type="text" name="username" id="username" placeholder="Wpisz nazwę użytkownika">
        </div>

        <button type="submit">Odblokuj</button>
        <a href="../BlockedUsers/index.php" class="creationLink">Powrót</a>
    </form>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : null;

        $target = null;
        foreach($uDatabase as $potTarget)
        {
            if($potTarget->getName() == $username)
            {
                $target = $potTarget;
                break;
            }
        }

        if($target == null)
        {
            header('Location: index.php');
            exit;
        }

        if(!$user->isBlocked($target->ID))
        {
            header('Location: index.php');
            exit;
        }
        
        for($i = 0; $i < count($user->getBlockedUsers()); $i++)
        {
            if($user->getBlockedUsers()[$i] == $target->ID)
            {
                $user->unlockUser($i);
                break;
            }
        }

        header('Location: ../BlockedUsers/index.php');
    }
?>