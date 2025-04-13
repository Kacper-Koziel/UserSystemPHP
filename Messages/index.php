<?php
    require("../Classes/index.php");
    session_start();
    $lastPage = $_SERVER['HTTP_REFERER'] ?? '../Main/index.php';

    $uDatabase = &$_SESSION['Database'];
    $user = $uDatabase[$_SESSION['loggedID'] - 1];
    $messages = $user->getMessages();
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Nowe wiadomości</h1>
        <div class="user-list">
            <?php
                if(empty($messages))
                {
                    echo "<div class='no-users'><p>Brak nowych wiadomości</p></div>";
                } 
                
                foreach($messages as $message)
                {
                    echo "<div class='user-item'>
                            <p><strong>Użytkownik</strong> " . $uDatabase[$message->getSenderID() - 1]->getName() . "
                            <strong> do grupy </strong> " . $message->parentsName . "</p>
                            <p> <i>" . $message->getText() . " </i> </p>
                        </div>";
                }
            ?>
        </div>
        <a href="../SendMessage/index.php">Wyślij wiadomość</a>
        <a href="<?php echo $lastPage; ?>" class="back-button">Powrót</a>
    </div>
</body>
</html>