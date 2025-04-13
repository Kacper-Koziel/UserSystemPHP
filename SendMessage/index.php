<?php
    require("../Classes/index.php");
    session_start();

    $uDatabase = &$_SESSION['Database'];
    $user = $uDatabase[$_SESSION['loggedID'] - 1];
    $lastPage = $_SERVER['HTTP_REFERER'] ?? '../../Main/index.php';
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
        <h1>Wyślij wiadomość</h1>
        <div class="input-group">
            <label for="username">Do: (nazwa użytkownika)</label>
            <input type="text" name="username" id="username" placeholder="Wpisz nazwę użytkownika">
        </div>
        <div class="input-group">
            <label for="password">Tekst: </label>
            <textarea name="text" id="text" rows="5" cols="40" placeholder="Hej, co tam?"></textarea>
        </div>
        
        <button type="submit">Wyślij</button>
        <a href="../PanelLocationSystem/index.php" class="creationLink">Wróć do panelu</a>
    </form>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $name = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : null;
        $text = isset($_POST['text']) && !empty($_POST['text']) ? $_POST['text'] : null;

        if(!($name && $text))
        {
            header('Location: index.php');
            exit;
        }

        $target = null;

        foreach($uDatabase as $potTarget)
        {
            if($name == $potTarget->getName())
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

        if($target->isBlocked($user->ID))
        {
            header('Location: ../PanelLocationSystem/index.php');
            exit;
        }

        $target->addMessage(new Message($user->ID, $text, $user->getName()));
        header('Location: ../PanelLocationSystem/index.php');
        exit;
    }
?>