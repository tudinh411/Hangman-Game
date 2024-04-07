<?php
session_start();

function registerUser($username, $password)
{
    $userData = file_get_contents('users.txt');
    $users = unserialize($userData);

    if (isset($users[$username])) {
        return "Username already exists!";
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $users[$username] = $hashedPassword;

    file_put_contents('users.txt', serialize($users));

    return "Registration successful!";
}

function authenticateUser($username, $password)
{
    $userData = file_get_contents('users.txt');
    $users = unserialize($userData);

    if (isset($users[$username])) {
        if (password_verify($password, $users[$username])) {
            $_SESSION['username'] = $username;
            header("Location: hangman.php");
            exit;
        } else {
            return "Invalid password!";
        }
    } else {
        return "User not found!";
    }
}

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $registrationResult = registerUser($username, $password);
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $loginResult = authenticateUser($username, $password);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background.png');
        }

        h2 {
            margin-top: 20px;
            font-size: 24px;
            color: #3440eb;
            text-align: center;
        }

        form {
            width: fit-content;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #0E8B03;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0E8B03;
        }

        form {
            border-radius: 10px;
            color: #f2fcff;
            background-color: white;
        }

        h1 {
            text-align: center;
            color: #043163;
            font-family: "Cursive";
        }

        .message {
            text-align: center;
            margin-top: 10px;
            color: #0a1fbf;
            font-weight: bold;
        }

        .header {
            color: black;
            letter-spacing: 20px;
            font-size: 60px;
        }

        input[type="text"] {
            background-color: #F8F8F8;
            border: 1px #BCB7B7 solid;
            width: 600px;
            height: 145px;
            font-size: 25px;
            letter-spacing: 15px;
        }

        input[type="password"] {
            background-color: #F8F8F8;
            border: 1px #BCB7B7 solid;
            width: 600px;
            height: 145px;
            font-size: 25px;
            letter-spacing: 15px;
        }

        input[type="submit"] {
            background-color: #F2BE04;
            border: 1px #BCB7B7 solid;
            width: 600px;
            height: 145px;
            letter-spacing: 20px;
        }

        .link {
            text-align: center;
            padding-top: 20px;
            color: black;
        }
    </style>
</head>

<body>

    <form action="" method="post">
        <h1><span class="header">HANGMAN</span></h1>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="submit" name="login" value="LOGIN"><br>
        <div class="link"><a href="register.php"> Register </a></div>
    </form>
    <?php if (isset($loginResult)): ?>
        <div class="message">
            <?php echo $loginResult; ?>
        </div>
    <?php endif; ?>
</body>

</html>