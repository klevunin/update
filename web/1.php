<?php
/**
 * Webhook bitrix 1C
 * Exchange with the site 1C Trade 10
 */

set_time_limit(0);
require_once __DIR__ . '/../config_1c.php';


if (($_SERVER['PHP_AUTH_USER'] == $auth_user) AND ($_SERVER['PHP_AUTH_PW'] == $auth_user_pw) AND ($_SERVER['REMOTE_ADDR'] == $remote_addr) AND ($_GET['mode'] == 'checkauth')) {

    $mysqli = new mysqli($dbhost, $dblogin, $dbpassword, $dbname);

    /* проверка соединения */
    if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s\n", $mysqli->connect_error);
        //отправим письмо об ощибки
        $text = 'Не удалось подключиться к базе данных 1С';
        setEmail($email, 'Ошибка обмена 1С!', $text);
        exit('Ошибка обмена 1С! Не удалось подключиться к базе данных.');
    }
    $length = 10;
    $coockie = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);

    $sql = "INSERT INTO `" . $db_table . "` (`name`,`coockie`) VALUES ('one','" . $coockie . "') ON DUPLICATE KEY UPDATE `coockie`='" . $coockie . "'";
    $result = $mysqli->query($sql);
    $mysqli->close();

    echo "success\n";
    echo "coockie\n";
    echo $coockie;
}


if (($_SERVER['REMOTE_ADDR'] == $remote_addr) AND ($_GET['mode'] == "init")) {


    $mysqli = new mysqli($dbhost, $dblogin, $dbpassword, $dbname);
    /* проверка соединения */
    if ($mysqli->connect_errno) {
        printf("Не удалось подключиться: %s\n", $mysqli->connect_error);

        //отправим письмо об ощибки
        $text = 'Не удалось подключиться к базе данных 1С';
        setEmail($email, 'Ошибка обмена 1С!', $text);

        exit('Не удалось подключиться к базе данных');
    }

    $sql = "SELECT `coockie` FROM `" . $db_table . "` WHERE `name` = 'one'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $mysqli->close();

    if ($_COOKIE['coockie'] == $row['coockie']) {
        if (extension_loaded('zip')) {
            $zip = "yes";
        } else {
            $zip = "no";
        }
        print "zip={$zip}\n";
        print "file_limit=" . return_bytes(ini_get('post_max_size'));
    }
}


if (($_SERVER['REMOTE_ADDR'] == $remote_addr) AND ($_GET['type'] == "catalog") AND ($_GET['mode'] == "file") AND (isset($_GET['filename']))) {

    $mysqli = new mysqli($dbhost, $dblogin, $dbpassword, $dbname);
    $sql = "SELECT `coockie` FROM `" . $db_table . "` WHERE `name` = 'one'";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    $mysqli->close();

    if ($_COOKIE['coockie'] == $row['coockie']) {

        //Забераем файл
        $filename = $_GET["filename"];
        $f = fopen($dir . $filename, 'ab');
        fwrite($f, file_get_contents('php://input'));
        fclose($f);

        //Unzip
        $zip = new ZipArchive;
        $zip->open($dir . $filename);
        $zip->extractTo($dir);
        $zip->close();

        //Удаляем архив
        unlink($dir . $filename);


        //Есть ли файл
        if (!file_exists($dir . 'offers.xml')) {
            $error_a = "1";
            $body .= "\r\nНе найден файл offers.xml - ONE";
        } else {
            //проверка на валидность
            $reader = new XMLReader();
            $reader->open($dir . 'offers.xml');
            $reader->setParserProperty(XMLReader::VALIDATE, true);
            if (!$reader->isValid()) {
                $error_a = "1";
                $body .= "\r\nНе валидный offers.xml - ONE";
            }
        }

        //Есть ли файл
        if (!file_exists($dir . 'import.xml')) {
            $error_a = "1";
            $body .= "\r\nНе найден файл import.xml - ONE";
        } else {
            //проверка на валидность
            $reader = new XMLReader();
            $reader->open($dir . 'import.xml');
            $reader->setParserProperty(XMLReader::VALIDATE, true);
            if (!$reader->isValid()) {
                $error_a = "1";
                $body .= "\r\nНе валидный import.xml - ONE";
            }
        }

        if (isset($error_a)) {
            //отправим письмо об ощибки
            echo "failure";

            $text = $body;
            setEmail($email, 'Ошибка обмена 1С!', $text);

            exit('Ошибка обмена 1С! ' . $text);

        } else {

            $mysqli = new mysqli($dbhost, $dblogin, $dbpassword, $dbname);

            if ($result = $mysqli->query("SHOW COLUMNS FROM updaite_site_multi")) {
                echo "failure";
                $text = 'База еще не обновлена, нужно ждать 1С';
                setEmail($email, 'Ошибка обмена 1С!', $text);
                exit('База еще не обновлена, нужно ждать!');
            }

                echo 'success';
                $sql = "INSERT INTO `" . $db_table . "` (`name`,`datestart`) VALUES ('one','" . time() . "') ON DUPLICATE KEY UPDATE `datestart`='" . time() . "'";
                $result = $mysqli->query($sql);
                $mysqli->close();
                exec("/usr/bin/php " . __DIR__ . "/../preparation/setBd.php > /dev/null &");
                $mysqli->close();
                exit;
        }
    } else {
        echo 'failure';
        $text = 'Аутентификация не пройдена!';
        setEmail($email, 'Ошибка обмена 1С!', $text);
        exit('Ошибка обмена 1С! Аутентификация не пройдена!');
    }
}


if (($_SERVER['REMOTE_ADDR'] == $remote_addr) AND ($_GET['type'] == "catalog") AND ($_GET['mode'] == "import") AND (isset($_GET['filename']))) {
    echo "success";
    exit;
}


if (($_SERVER['REMOTE_ADDR'] == $remote_addr) AND ($_GET['type'] == "sale") AND ($_GET['mode'] == "query")) {

    echo 'success';
    exit;
}


if (($_SERVER['REMOTE_ADDR'] == $remote_addr) AND ($_GET['type'] == "sale") AND ($_GET['mode'] == "success")) {
    echo 'success';
    exit;
}


if (($_SERVER['REMOTE_ADDR'] == $remote_addr) AND ($_GET['type'] == "sale") AND ($_GET['mode'] == "file")) {

    $filename = $_GET['filename'];
    $f = fopen($dir . $filename, 'ab');
    fwrite($f, file_get_contents('php://input'));
    fclose($f);

    $zip = new ZipArchive;
    $zip->open($dir . $filename);
    $zip->extractTo($dir);
    $zip->close();

    unlink($dir . $filename);

    echo 'success';
}

