<?php
    //echo phpversion();
    require("../Classes/index.php");
    session_start();

    //Tworzenie globalnej tablicy (prawie bazy danych)
    if (!isset($_SESSION['Database'])) {
        $_SESSION['Database'] = [];
    }
    $uDatabase = &$_SESSION['Database'];
    

    //Jestem zbyt leniwy by manualnie to tworzyć :D. 
    function CreateUser($uName, $uPassword, $perm)
    {
        global $uDatabase;

        switch($perm)
        {
            case 1:
                $user = new User($uName, $uPassword);
                $uDatabase[] = $user;
                return $user;
            
            case 2:
                $mod = new Moderator($uName, $uPassword);
                $uDatabase[] = $mod;
                return $mod;
            
            case 3:
                $adm = new Admin($uName, $uPassword);
                $uDatabase[] = $adm;
                return $adm;
            
            default: 
                throw new Exception("No to se nie utworzysz. Pozdro"); // Pozdro
        }
    }

    function UpdateSession()
    {
        $_SESSION['usersCount'] = User::$userCount;
        $_SESSION['modCount'] = Moderator::$moderatorsCount;
        $_SESSION['adminsCount'] = Admin::$adminsCount;
        $_SESSION['contactsCount'] = Contact::$contactCount;
        $_SESSION['groupsCount'] = Group::$groupCount;
    }
    

    function SynchronizeStaticMembers()
    {
        Admin::$adminsCount = isset($_SESSION['adminsCount']) ? $_SESSION['adminsCount'] : 0;
        Moderator::$moderatorsCount = isset($_SESSION['modCount']) ? $_SESSION['modCount'] : 0;
        User::$userCount = isset($_SESSION['usersCount']) ? $_SESSION['usersCount'] : 0;
        Contact::$contactCount = isset($_SESSION['contactsCount']) ? $_SESSION['contactsCount'] : 0;
        Group::$groupCount = isset($_SESSION['groupsCount']) ? $_SESSION['groupsCount'] : 0;
    }


    SynchronizeStaticMembers();

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
        <h1>Witaj w panelu symulacji :D</h1>
        <div class="input-group">
            <label for="username">Nazwa użytkownika</label>
            <input type="text" name="username" id="username" placeholder="Wpisz nazwę użytkownika">
            
        </div>
        <div class="input-group">
            <label for="password">Hasło</label>
            <input type="password" name="password" id="password" placeholder="Wpisz hasło">
        </div>
        <div class="input-group">
            <label for="permLvl">Poziom uprawnień</label>
            <input type="number" name="permLvl" id="permLvl" placeholder="User| 1 - 3 | Admin">
        </div>
        
        <button type="submit">Stwórz użytkownika</button>
        <a href="../Login/index.php">Zaloguj się</a>
    </form>
</body>
</html>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $name = isset($_POST['username']) && !empty($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;
        $perm = isset($_POST['permLvl']) && !empty($_POST['permLvl']) && $_POST['permLvl'] <= 3 && $_POST['permLvl'] > 0 ? $_POST['permLvl'] : null;

        foreach($uDatabase as $user)
        {
            if($name == $user->getName())
            {
                exit;
            }
        }


        if($name && $password && $perm)
        {
            CreateUser($name, $password, $perm);
            UpdateSession();
            header('Location: ../Login/index.php');
        }
    }
?>
