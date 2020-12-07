<?php
session_start();
//checks if the log off button was pushed
if (isset($_GET["logged_off"])) {
    session_destroy(); //terminates the session and logs the user off
    header ('Location: ../login');
}
include("../connection.php");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Правила Игры</title>
    <link href="../css/style.css" rel="stylesheet" type="text/css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src=../htmlEdit.js></script>
</head>
<body>
    <div id="sticky">
        <header>
            <a href="..">
                <div id="logo">
                    <h1>Футбология</h1>
                    <img src="../images/ball.png" alt="Логотип">
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
                <a id="login" href="../login">Вход</a>
            <?php 
            }?>
            <br class="clear">
        </header>
        <nav>
            <!-- the navigation bar -->
            <ul>
                <li><a href="../history">История Футбола</a></li>
                <li><a href="../rules" class="thisPage">Правила Игры</a></li>
                <li><a href="../techniques">Навыки и Техника</a></li>
                <li><a href="../people">Значимые Личности</a></li>
                <li><a href="../matches">Футбольные Матчи</a></li>
                <li><a href="../tactics">Тактика и Рассуждение</a></li>
                <li><a href="../quizzes">Викторина</a></li>
            </ul>
            <br class="clear">
        </nav>
    </div>
    <section id="content">
        <h2>Правила Игры</h2>
        <p id='important'></p>
        <?php
        //connecting to the database and changing the content of the page
        if (isset($_POST["updateRules"])) {
            $content_page = htmlentities($_POST["content_page"], ENT_QUOTES | ENT_HTML401); //avoiding special characters
            $sql = "UPDATE one_pagers SET content_page = '$content_page' WHERE id_page = 2";
            $con->query($sql);
        }
        //showing the page editor
        if (isset($_POST["editRules"])) {
            $pageDetails = mysqli_fetch_assoc (mysqli_query ($con, "SELECT * FROM one_pagers WHERE id_page = 2"));
            ?>
            <form action='' method='post' target='_self'>
                <fieldset>
                    <legend>Изменить Данные Страницы</legend>
                    <textarea class='bigBox breaker' required='required' id='theInput' name='content_page' placeholder='Описание...' maxlength='10000'><?php echo $pageDetails["content_page"]; ?></textarea>
                    <br>
                    <input type='submit' name='updateRules' class='submit' value='Изменить'>
                </fieldset>
            </form>
            <div id='editorAddon'>
                <!-- a window for inputting elements to the input box -->
                <button type="button" class='submit' onclick='addBreak()'>Добавить Абзац</button>
                <form onsubmit='return addLink(this)'>
                    <label for='name'>Введите название ссылки</label>
                    <br>
                    <input type='text' required='required' name='name'>
                    <br>
                    <label for='link'>Введите ссылку</label>
                    <br>
                    <input type='url' required='required' name='link'>
                    <br>
                    <input type='submit' class='submit' value='Добавить Ссылку'>
                </form>
            </div>
        <?php
        die();
        }
        if ($_SESSION["logged_in"] == true) {
            //showing the button to show the editor of the contents of the page
            ?>
            <fieldset>
                <form action='' method='post' target='_self'>
                    <label for='editRules'>Изменить Данные Страницы</label>
                    <br>
                    <input type='submit' name='editRules' class='submit' value='Изменить'>
                </form>
            </fieldset>
        <?php
        } 
        //outputing the contents of the page that are in the database on the webpage
        $rules = mysqli_fetch_assoc (mysqli_query ($con, "SELECT * FROM one_pagers WHERE id_page = 2"));
        echo "<p id='blogText'>" . html_entity_decode($rules["content_page"], ENT_QUOTES | ENT_HTML401) . "</p>";
        ?>
    </section>
</body>
</html>