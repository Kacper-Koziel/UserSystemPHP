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
        <h1>Zarządzanie kontaktami</h1>
        <a href="../ContactsOperations/AddContact/index.php" class="back-button">Dodaj Kontakt</a>
        <a href="../ContactsOperations/DeleteContact/index.php" class="back-button">Usuń Kontakt</a>
        <a href="../DisplayContacts/index.php" class="back-button">Powrót</a>
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

        $_SESSION['contactName'] = $user->getContacts()[$submVal]->name;
        $_SESSION['contactMessages'] = $user->getContacts()[$submVal]->getMessages();
        
    }
?>

