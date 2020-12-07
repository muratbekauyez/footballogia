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
    <title>Тактика и Рассуждение</title>
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
                <li><a href="../rules">Правила Игры</a></li>
                <li><a href="../techniques">Навыки и Техника</a></li>
                <li><a href="../people">Значимые Личности</a></li>
                <li><a href="../matches">Футбольные Матчи</a></li>
                <li><a href="../tactics" class="thisPage">Тактика и Рассуждение</a></li>
                <li><a href="../quizzes">Викторина</a></li>
            </ul>
            <br class="clear">
        </nav>
    </div>
    <section id="content">
        <h2>Тактика и Рассуждение</h2>
        <p id='important'></p>
        <?php
        //delete the blog entry from the database
        if (isset($_POST["deleteTactic"])) {
            $sql = "DELETE FROM tactics WHERE id_tactic = '".$_POST["idOfTact"]."'";
            $con->query($sql);
        }
        //open the full version of the blog entry
        if (isset($_POST["readTactic"])) {
            $tactic = mysqli_fetch_assoc (mysqli_query ($con, "SELECT * FROM tactics WHERE id_tactic = '".$_POST["idOfTact"]."'"));
            echo "<h3 id='blogHead'>" . $tactic["name_tactic"] . "</h3>";
            echo "<p id='blogText'>" . html_entity_decode($tactic["content_tactic"], ENT_QUOTES | ENT_HTML401) . "</p>";
            die();
        }
        //add a blog entry to the database
        if (isset($_POST["addTactic"])) {
            $name_tactic = htmlentities($_POST["name_tactic"], ENT_QUOTES | ENT_HTML401);
            $content_tactic = htmlentities($_POST["content_tactic"], ENT_QUOTES | ENT_HTML401);
            $photo_tactic = htmlentities($_POST["photo_tactic"], ENT_QUOTES | ENT_HTML401);
            $sql = "INSERT INTO tactics (name_tactic, content_tactic, photo_tactic) VALUES ('$name_tactic', '$content_tactic', '$photo_tactic')";
            $con->query($sql);
            
        }
        //change a blog entry in the database
        if (isset($_POST["updateTactic"])) {
            $name_tactic = htmlentities($_POST["name_tactic"], ENT_QUOTES | ENT_HTML401);
            $content_tactic = htmlentities($_POST["content_tactic"], ENT_QUOTES | ENT_HTML401);
            $photo_tactic = htmlentities($_POST["photo_tactic"], ENT_QUOTES | ENT_HTML401);
            $sql = "UPDATE tactics SET name_tactic = '$name_tactic', content_tactic = '$content_tactic', photo_tactic = '$photo_tactic' WHERE id_tactic = '".$_POST["idOfTact"]."'";
            $con->query($sql);
        }
        //the form for editing the database data
        if (isset($_POST["editTactic"])) {
            $tacticDetails = mysqli_fetch_assoc (mysqli_query ($con, "SELECT * FROM tactics WHERE id_tactic = '".$_POST["idOfTact"]."'"));
            ?>
            <form action='' method='post' target='_self'>
                <fieldset>
                    <legend>Изменить Запись</legend>
                    <label for='name_tactic'>Название Записи</label>
                    <br>
                    <input type='text' required='required' name='name_tactic' placeholder='Имя' value="<?php echo $tacticDetails["name_tactic"]; ?>" maxlength='60'>
                    <br>
                    <label for='photo_tactic'>Ссылка на фото обложки (если есть)</label>
                    <br>
                    <input type='url' name='photo_tactic' placeholder='Фото' value="<?php echo $tacticDetails["photo_tactic"]; ?>" maxlength='1000'>
                    <br>
                    <label for='content_tactic'>Запись</label>
                    <br>
                    <textarea class='fixBox breaker' required='required' id='theInput'  name='content_tactic' placeholder='Описание...' maxlength='15000'><?php echo $tacticDetails["content_tactic"]; ?></textarea>
                    <br>
                    <input hidden='hidden' type='text' name='idOfTact' value='<?php echo $_POST["idOfTact"]; ?>'>
                    <input type='submit' name='updateTactic' class='submit' value='Изменить'>
                </fieldset>
            </form>
            <form action='' method='post' target='_self'>
                <input hidden='hidden' type='text' name='idOfTact' value='<?php echo $_POST["idOfTact"]; ?>'>
                <input type='submit' name='deleteTactic' class='submit delete' value='Удалить'>
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
            //add a data entry to the website
            ?>
            <form action='' method='post' target='_self'>
                <fieldset>
                    <legend>Добавить Запись</legend>
                    <label for='name_tactic'>Название Записи</label>
                    <br>
                    <input type='text' required='required' name='name_tactic' placeholder='Имя' maxlength='60'>
                    <br>
                    <label for='photo_tactic'>Ссылка на фото обложки (если есть)</label>
                    <br>
                    <input type='url' name='photo_tactic' placeholder='Фото' maxlength='1000'>
                    <br>
                    <label for='content_tactic'>Запись</label>
                    <br>
                    <textarea class='fixBox breaker' required='required' id='theInput' name='content_tactic' placeholder='Описание...' maxlength='15000'></textarea>
                    <br>
                    <input type='submit' name='addTactic' class='submit' value='Добавить'>
                </fieldset>
            </form>
            <div id='editorAddon'>
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
        }
        $tactics = mysqli_query($con, "SELECT * FROM tactics ORDER BY id_tactic DESC");
        
        //output the data in form of a graph
        while($row = $tactics->fetch_assoc()) {
            if ($row["photo_tactic"] == NULL) {
                $row["photo_tactic"] = "../images/unknownPost.svg";
            }
            $row["content_tactic"] = substr($row["content_tactic"],0,100);
            echo "<div class='blogPost'><h3>" . $row["name_tactic"] . "</h3><img src='" . html_entity_decode($row["photo_tactic"], ENT_QUOTES | ENT_HTML401) . "' alt='Фото " . $row["name_tactic"] . "'><p>" . html_entity_decode($row["content_tactic"], ENT_QUOTES | ENT_HTML401) . "...</p>
            <form action='' method='post' target='_self'>
            <input hidden='hidden' type='text' name='idOfTact' value='" . $row["id_tactic"] . "'>
            <input type='submit' name='readTactic' class='readMore' value='Читать дальше'></form>";
            if ($_SESSION["logged_in"] == true) {
                echo "
            <form action='' method='post' target='_self'>
            <input hidden='hidden' type='text' name='idOfTact' value='" . $row["id_tactic"] . "'>
            <input type='submit' name='editTactic' class='submit' value='Изменить'></form>";
            }
            echo "</div>";
        }
        ?>
    </section>
</body>
</html>