<?php
    require("../Classes/index.php");
    session_start();

    if (!isset($_SESSION['Database'])) {
        $_SESSION['Database'] = [];
    }
    $uDatabase = &$_SESSION['Database'];

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
        <h1>Zaloguj się</h1>
        <div class="input-group">
            <label for="username">Nazwa użytkownika</label>
            <input type="text" name="username" id="username" placeholder="Wpisz nazwę użytkownika">
        </div>
        <div class="input-group">
            <label for="password">Hasło</label>
            <input type="password" name="password" id="password" placeholder="Wpisz hasło">
        </div>
        
        <button type="submit">Zaloguj się</button>
        <a href="../Main/index.php" class="creationLink">Stwórz użytkownika</a>
    </form>
</body>
</html>

<?php
    function locateUserByPermission($user)
    {
        $_SESSION['loggedID'] = $user->ID;

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
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $username = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;

        if(!($username && $password))
        {
            header('Location: index.php');
            exit;
        }
        
        foreach($uDatabase as $user)
        {

            if($user->getName() == $username && $user->getPassword() == $password)
            {
                locateUserByPermission($user);
                exit;
            }
        }

        header('Location: index.php');
        exit;
    }
?>