<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('background.png');
            justify-content: center;
            align-items: center;
        }

        h2 {
            margin-top: 20px;
            font-size: 24px;
            color: #3440eb;
            text-align: center;
        }

        h1 {
            text-align: center;
            color: #043163;
            font-family: "Cursive";
        }

        .header {
            color: black;
            letter-spacing: 20px;
            font-size: 60px;
            background-color: white;
        }

        .instructions {
            text-align: center;
            font-size: 25px;
            background-color: white;
            color: #1A1A1A;
            letter-spacing: 10px;
            height: 150px;
            padding-top: 20px;
        }

        .buttons {
            display: flex;
            flex-direction: column;
            align-content: center;
            margin-left: auto;
            margin-right: auto;
            align-items: center;
        }

        button {
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 30px;
            width: 600px;
            height: 120px;
            color: white;
            border-radius: 15px;
            border: none;
            letter-spacing: 10px;
            cursor: pointer;
            transition: transform ease-in-out;
            /* animation: moveUp;
            animation-duration: 2s;
            position: relative; */
        }

        @keyframes moveOne {
            0% {
                top: 20px;
            }

            100% {
                top: 0px;
            }
        }

        @keyframes moveTwo {
            0% {
                top: 40px;
            }

            100% {
                top: 0px;
            }
        }

        @keyframes moveThree {
            0% {
                top: 80px;
            }

            100% {
                top: 0px;
            }
        }


        button:hover {
            transform: scale(0.8);
        }

        #button1 {
            background-color: #0E8B03;
            animation: moveOne;
            animation-duration: 2s;
            position: relative;
        }

        #button2 {
            background-color: #F2BE04;
            animation: moveTwo;
            animation-duration: 2s;
            position: relative;
        }

        #button3 {
            background-color: #DB2626;
            animation: moveThree;
            animation-duration: 2s;
            position: relative;
        }

        .level {
            font-size: 30px;

        }
    </style>

    <h1><span class="header">HANGMAN</span></h1>

</head>

<body>
    <p span class="instructions"> Instructions: Select the difficulty level and select<br>the letter you think the
        word/phrase contains. <br>Beware of
        number of attempts you have left.</p>
    <div class="buttons">
        <a href="hangman.php?level=easy"><button type="button" id="button1"> <span class="level">Easy</span><br> Level
                1-6 <br> </button></a><br>
        <a href="hangman.php?level=medium"><button type="button" id="button2"><span class="level">Medium</span><br>Level
                7-12 <br> </button></a><br>
        <a href="hangman.php?level=hard"><button type="button" id="button3"><span class="level">Hard</span><br> Level
                12-18 <br></button></a>
    </div>
</body>

</html>