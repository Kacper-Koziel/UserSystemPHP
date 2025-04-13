<?php
    $lastPage = $_SERVER['HTTP_REFERER'] ?? '../Main/index.php';
    require("../Classes/index.php");
    session_start();
    
    $uDatabase = &$_SESSION['Database'];
    $user = $uDatabase[$_SESSION['loggedID'] - 1];

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $submVal = isset($_POST['submit']) && !empty($_POST['submit']) ? $_POST['submit'] : null;

        if(!$submVal)
        {
            header('Location: index.php');
            exit;
        }

        $_SESSION['openedGroupID'] = $user->getGroup($submVal - 1)->ID;
        header('Location: ../GroupsPanel/index.php');
        exit;
        
    }

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakty</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: url('../Assets/panelBackground.jpg') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .container {
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            color: white;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: 700;
        }

        .user-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
            padding: 0;
            max-height: 400px;
            overflow-y: auto;
        }

        .user-list::-webkit-scrollbar {
            width: 10px;
        }

        .user-list::-webkit-scrollbar-thumb {
            background-color: rgb(95, 2, 95);
            border-radius: 5px;
            border: 2px solid rgba(0, 0, 0, 0.3);
            transition: background-color 0.3s ease;
        }

        .user-list::-webkit-scrollbar-thumb:hover {
            background-color: rgb(146, 5, 146);
        }

        .user-item {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .user-item p {
            margin: 8px 0;
        }

        .user-item strong {
            font-weight: 600;
        }

        .no-users {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            color: white;
            width: 100%;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 150px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            background: rgb(95, 2, 95);
            font-weight: 700;
            transition: 0.3s ease;
        }

        a:hover {
            background: rgb(146, 5, 146);
        }

        form  {
            display: flex;
            flex-direction: column;
            gap: 5px;
            align-items: center;
        }

        button {
            width: 80%;
            outline: none;
            border: none;
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 8px;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: background 0.5s ease;
        }

        button:hover {
            background: rgba(146, 5, 146, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Lista Grup</h1>
        <div class="user-list">
            <form method="POST">
            <?php
                $counter = 0;

                foreach($user->getGroups() as $group)
                {
                    $counter++;
                    
                    echo "<button type='submit' name='submit' value='" . $counter . "' class='user-item'>
                            <p><strong>Nazwa grupy:</strong> " . $group->name . "</p>
                        </button>";
                }
                
                if($counter == 0)
                {
                    echo "<div class='no-users'><p>Brak Grup</p></div>";
                }

            ?>
            </form>
        </div>
        
        <a href="../ManageGroups/index.php" class="back-button">Zarządzaj Grupami</a>
        <a href="../PanelLocationSystem/index.php" class="back-button">Powrót</a>
    </div>
</body>
</html>


