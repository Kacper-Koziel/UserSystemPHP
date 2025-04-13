<?php
    require("../Classes/index.php");
    session_start();

    $uDatabase = &$_SESSION['Database'];
    $user = $uDatabase[$_SESSION['loggedID'] - 1];

    $images = [
        "../Assets/Kotki/kotek1.jpg",
        "../Assets/Kotki/kotki2.jpg",
        "../Assets/Kotki/kotki3.jpg",
        "../Assets/Kotki/kotki4.jpg",
        "../Assets/Kotki/kotki5.jpg",
        "../Assets/Kotki/kotki6.jpg",
        "../Assets/Kotki/kotki7.jpg",
        "../Assets/Kotki/kotki8.jpg"
    ];

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
    <div class="panel">
        <div class="row">
            <h1>Słodkie kotki</h1>

            <div class="img-container">
                <?php
                    $img = rand(0, 7);

                    echo "<img src='" . $images[$img] . "'>";
                ?>
            </div>
            <form method="post">
                <input type="submit" value="Losuj ponownie">
            </form>
        </div>
    </div>
</body>
</html>
