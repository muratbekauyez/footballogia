<?php
session_start();
//checks if the log off button was pushed
if (isset($_GET["logged_off"])) {
    session_destroy(); //terminates the session and logs the user off
    header ('Location: login');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Футбология</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <div id="sticky">
        <header>
            <a href="">
                <div id="logo">
                    <h1>Футбология</h1>
                    <img src="images/ball.png" alt="Логотип">
                </div>
            </a>
            <?php
            if ($_SESSION["logged_in"] == true) {
            ?>
                <!-- the log off button -->
                <a id="login" href="?logged_off=true">Выход</a>
            <?php
            } else {
            ?>
                <!-- the login button -->
                <a id="login" href="login">Вход</a>
            <?php 
            }?>
            <br class="clear">
        </header>
    </div>
    <section id="homeNav">
        <!-- the navigation section with image panels representing different pages -->
        <a href="history">
            <div class="homePanels" id="history">
                <div>История Футбола</div>                
            </div>
        </a>
        <a href="rules">
            <div class="homePanels" id="rules">
                <div>Правила Игры</div>                       
            </div>
        </a>
        <a href="techniques">
            <div class="homePanels" id="techniques">
                <div>Навыки и Техника</div>                          
            </div>
        </a>
        <a href="people">
            <div class="homePanels" id="people">
                <div>Значимые Личности</div>                           
            </div>
        </a>
        <a href="matches">
            <div class="homePanels" id="matches">
                <div>Футбольные Матчи</div>                            
            </div>
        </a>
        <a href="tactics">
            <div class="homePanels" id="tactics">
                <div>Тактика и Рассуждение</div>                         
            </div>
        </a>
        <a href="quizzes">
            <div class="homePanels" id="quizzes">
                <div>Викторина</div>                            
            </div>
        </a>
    </section>
</body>
</html>