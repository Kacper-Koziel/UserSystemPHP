<?php
    $lastPage = $_SERVER['HTTP_REFERER'] ?? '../Main/index.php';
    require("../../Classes/index.php");
    session_start();
    
    $uDatabase = &$_SESSION['Database'];
    $user = &$uDatabase[$_SESSION['loggedID'] - 1];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <form method="POST">
        <h1>Usuń grupę</h1>
        <div class="input-group">
            <label for="name">Nazwa grupy</label>
            <input type="text" name="name" id="name" placeholder="Wpisz nazwę grupy">
        </div>
        
        <button type="submit">Usuń</button>
        <a href="../../GroupsDisplayer/index.php" class="creationLink">Powrót</a>
    </form>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $name = isset($_POST['name']) && !empty($_POST['name']) ? $_POST['name'] : null;

        if(!$name)
        {
            header('Location: index.php');
            exit;
        }

        $index = null;

        for($i = 0; $i < count($user->getGroups()); $i++)
        {
            if($user->getGroups()[$i]->name == $name)
            {
                $index = $i;
            }
        }

        if($index === null)
        {
            echo "<h1 style='color: white;'> Brak indexu </h1>";
            header('Location: index.php');
            exit;
        }

        $user->deleteGroup($index);
        header('Location: ../../GroupsDisplayer/index.php');
        exit;
    }
?>