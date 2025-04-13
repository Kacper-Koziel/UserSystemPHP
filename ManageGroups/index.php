<?php
    $lastPage = $_SERVER['HTTP_REFERER'] ?? '../Main/index.php';
    require("../Classes/index.php");
    session_start();
    
    $uDatabase = &$_SESSION['Database'];
    $user = $uDatabase[$_SESSION['loggedID'] - 1];

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakty</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Zarządzanie Grupami</h1>
        <a href="../GroupsOperations/AddGroup/index.php" class="back-button">Dodaj Grupę</a>
        <a href="../GroupsOperations/DeleteGroup/index.php" class="back-button">Usuń Grupę</a>
        <a href="../GroupsDisplayer/index.php" class="back-button">Powrót</a>
    </div>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $submVal = isset($_POST['submit']) && !empty($_POST['submit']) ? $_POST['submit'] : null;

        if(!$submVal)
        {
            header('Location: index.php');
            exit;
        }


        $_SESSION['groupName'] = $user->getGroups()[$submVal]->name;
        $_SESSION['groupMessages'] = $user->getGroups()[$submVal]->getMessages();
        
    }
?>

