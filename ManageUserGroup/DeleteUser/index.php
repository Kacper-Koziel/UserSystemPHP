<?php
    $lastPage = $_SERVER['HTTP_REFERER'] ?? '../Main/index.php';
    require("../../Classes/index.php");
    session_start();
    
    $uDatabase = &$_SESSION['Database'];
    $groupID = $_SESSION['openedGroupID'];
    $user = &$uDatabase[$_SESSION['loggedID'] - 1];

    $group = null;

    foreach($user->getGroups() as $potGroup)
    {
        if($potGroup->ID == $groupID)
        {
            $group = $potGroup;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        background: url('../../Assets/panelBackground.jpg') no-repeat center center/cover;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    form {
        background: rgba(0, 0, 0, 0.6);
        padding: 40px;
        border-radius: 15px;
        text-align: center;
        color: white;
        width: 350px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }

    h1 {
        margin-bottom: 20px;
        font-size: 24px;
        font-weight: 700;
        text-align: center;
    }

    .input-group {
        margin-bottom: 15px;
        text-align: left;
    }

    label {
        display: block;
        font-weight: 500;
        margin-bottom: 5px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background: rgba(255, 255, 255, 0.1);
        color: white;
        outline: none;
        font-size: 16px;
    }

    input:focus {
        background: rgba(255, 255, 255, 0.2);
    }

    button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background: rgb(95, 2, 95);
        color: white;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.5s;
    }

    button:hover {
        background: rgb(146, 5, 146);
    }

    .creationLink {
        margin-top: 1rem;
        text-decoration: none;
        color: rgb(146, 5, 146);
        font-size: 12px;
    }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <form method="POST">
        <h1>Usuń Użytkownika z grupy</h1>
        <div class="input-group">
            <label for="name">Nazwa Użytkownika</label>
            <input type="text" name="name" id="name" placeholder="Wpisz nazwę użytkownika">
        </div>

        <button type="submit">Usuń</button>
        <a href="../../ManageUsersGroupMenu/index.php" class="creationLink">Powrót</a>
    </form>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $name = isset($_POST['name']) && !empty($_POST['name']) ? $_POST['name'] : null;

        if(!$name)
        {
            echo "<h1 style='color: white;'> Brak nazwy </h1>";
            // header('Location: index.php');
            // exit;
        }

        $deletedUser = null;

        foreach($uDatabase as $potUser)
        {
            if($potUser->getName() == $name)
            {
                $deletedUser = $potUser;
            }
        }

        if(!$deletedUser)
        {
            echo "<h1 style='color: white;'> Brak usera </h1>";
            // header('Location: index.php');
            // exit;
        }

        if(!$group->isMember($deletedUser->ID))
        {
            echo "<h1 style='color: white;'> NIe ta grupa </h1>";

            // header('Location: index.php');
            // exit;
        }

        $index = null;


        for ($i = 0; $i < count($deletedUser->getGroups()); $i++) { 
            if($deletedUser->getGroups()[$i]->name == $group->name)
            {
                $index = $i;
            } 
        }

        if(!$index)
        {
            echo "<h1 style='color: white;'> Nie ten user </h1>";

        }

        $deletedUser->deleteGroup($index);
        $group->deleteMember($deletedUser->ID, $uDatabase);

        if($group->isMember($user->ID))
        {
            header('Location: ../../ManageUsersGroupMenu/index.php');
            exit;
        }

        header('Location: ../../PanelLocationSystem/index.php');
        exit;
    }
?>