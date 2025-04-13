<?php
    require_once("../Classes/index.php");
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
        <h1><?= $group->name ?> <a href="../ManageUsersGroupMenu/index.php" class="addBtn">+</a></h1>
        <div class="user-list">
            <?php

                $counter = 0;

                foreach($group->getMessages() as $message)
                {

                    if($message->getSenderID() == $user->ID)
                    {
                        echo "<h2 class='yours'> <span>Ty: </span>" . $message->getText() . "</h2>";
                    }
                    else
                    {
                        echo "<h2 class='others'> <span>" . $uDatabase[$message->getSenderID() - 1]->getName()  . ": </span>" . $message->getText() . "</h2>";
                    }

                    $counter++;
                }
                
                if($counter == 0)
                {
                    echo "<div class='no-users'><p>Brak Wiadomości</p></div>";
                }
            ?>
        </div>
        <div class="wrapper">
            <a href="../GroupsDisplayer/index.php" class="back-button">Powrót</a>
            <form method="post">
                <textarea name="messageText" id="messageText" cols="55" rows="1" placeholder="Napisz wiadomość.."></textarea>
                <input type="submit" value="Wyślij">
            </form>
            
        </div>
        
    </div>
</body>
</html>

<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $text = isset($_POST['messageText']) && !empty($_POST['messageText']) ? $_POST['messageText'] : null;
    
        if (!$text) {
            header('Location: index.php');
            exit;
        }

        $group->addMessage(new Message($user->ID, $text, $group->name));

        header('Location: index.php');
        exit;
    }
    
?>
