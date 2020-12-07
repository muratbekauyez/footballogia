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
    <title>Навыки и Техника</title>
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
                <li><a href="../techniques" class="thisPage">Навыки и Техника</a></li>
                <li><a href="../people">Значимые Личности</a></li>
                <li><a href="../matches">Футбольные Матчи</a></li>
                <li><a href="../tactics">Тактика и Рассуждение</a></li>
                <li><a href="../quizzes">Викторина</a></li>
            </ul>
            <br class="clear">
        </nav>
    </div>
    <section id="content">
        <h2>Навыки и Техника</h2>
        <p id='important'></p>
        <?php
        //delete the blog entry from the database
        if (isset($_POST["deleteTechnique"])) {
            $sql = "DELETE FROM techniques WHERE id_technique = '".$_POST["idOfTech"]."'";
            $con->query($sql);
        }
        //open the full version of the blog entry
        if (isset($_POST["readTechnique"])) {
            $technique = mysqli_fetch_assoc (mysqli_query ($con, "SELECT * FROM techniques WHERE id_technique = '".$_POST["idOfTech"]."'"));
            echo "<h3 id='blogHead'>" . $technique["name_technique"] . "</h3>";
            echo "<p id='blogText'>" . html_entity_decode($technique["content_technique"], ENT_QUOTES | ENT_HTML401) . "</p>";
            die();
        }
        //add a blog entry to the database
        if (isset($_POST["addTechnique"])) {
            $name_technique = htmlentities($_POST["name_technique"], ENT_QUOTES | ENT_HTML401);
            $content_technique = htmlentities($_POST["content_technique"], ENT_QUOTES | ENT_HTML401);
            $photo_technique = htmlentities($_POST["photo_technique"], ENT_QUOTES | ENT_HTML401);
            $sql = "INSERT INTO techniques (name_technique, content_technique, photo_technique) VALUES ('$name_technique', '$content_technique', '$photo_technique')";
            $con->query($sql);            
        }
        //change a blog entry in the database
        if (isset($_POST["updateTechnique"])) {
            $name_technique = htmlentities($_POST["name_technique"], ENT_QUOTES | ENT_HTML401);
            $content_technique = htmlentities($_POST["content_technique"], ENT_QUOTES | ENT_HTML401);
            $photo_technique = htmlentities($_POST["photo_technique"], ENT_QUOTES | ENT_HTML401);
            $sql = "UPDATE techniques SET name_technique = '$name_technique', content_technique = '$content_technique', photo_technique = '$photo_technique' WHERE id_technique = '".$_POST["idOfTech"]."'";
            $con->query($sql);
        }
        //the form for editing the database data
        if (isset($_POST["editTechnique"])) {
            $techniqueDetails = mysqli_fetch_assoc (mysqli_query ($con, "SELECT * FROM techniques WHERE id_technique = '".$_POST["idOfTech"]."'"));
            ?>
            <form action='' method='post' target='_self'>
                <fieldset>
                    <legend>Изменить Запись</legend>
                    <label for='name_technique'>Название Записи</label>
                    <br>
                    <input type='text' required='required' name='name_technique' placeholder='Имя' value="<?php echo $techniqueDetails["name_technique"]; ?>" maxlength='60'>
                    <br>
                    <label for='photo_technique'>Ссылка на фото обложки (если есть)</label>
                    <br>
                    <input type='url' name='photo_technique' placeholder='Фото' value="<?php echo $techniqueDetails["photo_technique"]; ?>" maxlength='1000'>
                    <br>
                    <label for='content_technique'>Запись</label>
                    <br>
                    <textarea class='fixBox breaker' required='required' id='theInput' name='content_technique' placeholder='Описание...' maxlength='15000'><?php echo $techniqueDetails["content_technique"]; ?></textarea>
                    <br>
                    <input hidden='hidden' type='text' name='idOfTech' value='<?php echo $_POST["idOfTech"]; ?>'>
                    <input type='submit' name='updateTechnique' class='submit' value='Изменить'>
                </fieldset>
            </form>
            <form action='' method='post' target='_self'>
                <input hidden='hidden' type='text' name='idOfTech' value='<?php echo $_POST["idOfTech"]; ?>'>
                <input type='submit' name='deleteTechnique' class='submit delete' value='Удалить'>
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
                    <label for='name_technique'>Название Записи</label>
                    <br>
                    <input type='text' required='required' name='name_technique' placeholder='Имя' maxlength='60'>
                    <br>
                    <label for='photo_technique'>Ссылка на фото обложки (если есть)</label>
                    <br>
                    <input type='url' name='photo_technique' placeholder='Фото' maxlength='1000'>
                    <br>
                    <label for='content_technique'>Запись</label>
                    <br>
                    <textarea class='fixBox breaker' required='required' id='theInput' name='content_technique' placeholder='Описание...' maxlength='15000'></textarea>
                    <br>
                    <input type='submit' name='addTechnique' class='submit' value='Добавить'>
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
        $techniques = mysqli_query($con, "SELECT * FROM techniques ORDER BY id_technique DESC");
        
        //output the data in form of a graph
        while($row = $techniques->fetch_assoc()) {
            if ($row["photo_technique"] == NULL) {
                $row["photo_technique"] = "../images/unknownPost.svg";
            }
            $row["content_technique"] = substr($row["content_technique"],0,100);
            echo "<div class='blogPost'><h3>" . $row["name_technique"] . "</h3><img src='" . html_entity_decode($row["photo_technique"], ENT_QUOTES | ENT_HTML401) . "' alt='Фото " . $row["name_technique"] . "'><p>" . html_entity_decode($row["content_technique"], ENT_QUOTES | ENT_HTML401) . "...</p>
            <form action='' method='post' target='_self'>
            <input hidden='hidden' type='text' name='idOfTech' value='" . $row["id_technique"] . "'>
            <input type='submit' name='readTechnique' class='readMore' value='Читать дальше'></form>";
            if ($_SESSION["logged_in"] == true) {
                echo "
            <form action='' method='post' target='_self'>
            <input hidden='hidden' type='text' name='idOfTech' value='" . $row["id_technique"] . "'>
            <input type='submit' name='editTechnique' class='submit' value='Изменить'></form>";
            }
            echo "</div>";
        }
        ?>
    </section>
</body>
</html>