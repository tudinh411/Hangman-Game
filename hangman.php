<?php
session_start();

// Load questions and answers from file
$questions = include ('questions.php');

// Check if difficulty level is selected
if (!isset($_GET['level'])) {
    header('Location: index.php');
    exit();
}

// Set difficulty level
$level = $_GET['level'];

// Check if level exists
if (!isset($questions[$level])) {
    header('Location: index.php');
    exit();
}

// Handle restart action
if (isset($_GET['restart']) && $_GET['restart'] === 'true') {
    // Reset session variables
    $_SESSION['attempts'] = 6; // Reset attempts
    $_SESSION['guessed_letters'] = []; // Clear guessed letters
    unset($_SESSION['current_question'], $_SESSION['current_answer'], $_SESSION['masked_answer']);
    // Redirect to index.php to start a new game
    header('Location: index.php');
    exit();
}

// Initialize session variables
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 6;
    $_SESSION['guessed_letters'] = [];
}

// Select a random question from the chosen difficulty level
if (empty($_SESSION['current_question'])) {
    // Check if the chosen difficulty level exists in the questions array
    if (isset($questions[$level])) {
        $questionsForLevel = $questions[$level];
        $randomIndex = array_rand($questionsForLevel);
        $_SESSION['current_question'] = $questionsForLevel[$randomIndex]['question'];
        $_SESSION['current_answer'] = strtoupper($questionsForLevel[$randomIndex]['answer']);
        $_SESSION['masked_answer'] = str_repeat('_', strlen($_SESSION['current_answer']));
    } else {
        // If the chosen level doesn't exist, redirect to index.php
        header('Location: index.php');
        exit();
    }
}

// Check if a letter has been guessed
if (isset($_POST['guess'])) {
    $guess = strtoupper($_POST['guess']);

    // Check if the guessed letter is in the answer
    if (strpos($_SESSION['current_answer'], $guess) !== false) {
        for ($i = 0; $i < strlen($_SESSION['current_answer']); $i++) {
            if ($_SESSION['current_answer'][$i] === $guess) {
                $_SESSION['masked_answer'][$i] = $guess;
            }
        }
    } else {
        // Reduce attempts if the guessed letter is incorrect
        if ($_SESSION['attempts'] > 0) { // Check if attempts are greater than 0
            $_SESSION['attempts']--;
        }
    }

    // Add the guessed letter to the list of guessed letters
    $_SESSION['guessed_letters'][] = $guess;

    // Check if the player has won or lost
    if ($_SESSION['masked_answer'] === $_SESSION['current_answer']) {
        $message = 'Congratulations! You won!';
    } elseif ($_SESSION['attempts'] === 0) {
        $message = 'Game over! You lost. The correct answer was: ' . $_SESSION['current_answer'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman Game</title>
    <style>
        body {
            background-image: url("background.png");
        }

        #submit {
            margin: 5px;
            padding: 10px;
            font-size: 15px;
            background-color: #F4F4F4;
        }

        .wrong {
            color: #DB2626;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            align-content: center;
            margin-left: auto;
            margin-right: auto;
        }

        #button1 {
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 30px;
            width: 600px;
            height: 120px;
            color: white;
            border-radius: 15px;
            border: none;
            letter-spacing: 10px;
            background-color: #0E8B03;
        }

        .attempts {
            animation: attemptMove;
            animation-duration: 2s;
            position: relative;
        }

        @keyframes attemptMove {
            0% {
                top: 20px;
            }

            100% {
                top: 0px;
            }
        }

        .level {
            font-size: 30px;

        }

        .t1 {
            color: #DB2626;
            font-size: 20px;
        }

        .p1 {
            letter-spacing: 5px;
            text-align: center;
        }

        .p2 {
            letter-spacing: 5px;
            text-align: center;
        }

        .hg {
            /* display: flex;
            justify-content: center; */
            text-align: center;
        }

        .whitebg {
            background-color: white;
        }

        a.b2 {
            margin-left: auto;
            margin-right: auto;
            color: #DB2626;
            border: none;
            font-size: 20px;
            font-weight: 300;
            letter-spacing: 5px;
        }

        .message {
            color: red;
            font-size: 25px;
        }
    </style>
</head>

<body>
    <div class="buttons"> <button type="button" id="button1"> <span class="level">Start Game</span><br>
            Good Luck!</button><br>
        <div class="whitebg">

            <p class="p1 question">Question:
                <?php echo $_SESSION['current_question']; ?>
            </p>
            <div class="hg">


                <p><span class="p1 current">Current word:</span>
                    <?php echo $_SESSION['masked_answer']; ?>
                </p>

                <p class="p1"> <span class="t1 attempts">
                        <?php echo max(0, $_SESSION['attempts']); ?>
                    </span>
                    attempts left
                </p>

                <img src="images/<?php echo max(0, $_SESSION['attempts']); ?>.jpg" alt="Hangman Image">

                <p class="p1">Guessed letters:
                    <?php echo implode(', ', $_SESSION['guessed_letters']); ?>
                </p>

                <form method="post">
                    <label for="guess" class="p1">Enter a letter:</label>
                    <input type="text" id="guess" name="guess" maxlength="1" pattern="[A-Za-z]" required>
                    <button type="submit">Guess</button>
                </form>


                <?php if (isset($message)): ?>
                    <p class="message">
                        <?php echo $message; ?>
                    </p>
                    <br>
                <?php endif; ?>
                <a class="b2" href="?level=<?php echo $level; ?>&restart=true">Restart</a>
            </div>

</body>

</html>