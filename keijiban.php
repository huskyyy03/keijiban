<?php

$filename = './bbs.txt';
$name = '';
$comment = '';
$log = date('Y-m-d H:i:s') . "\n";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['name']) === TRUE && isset($_POST['comment']) === TRUE) {
        $name = $_POST['name'] . ": ";
        $comment = $_POST['comment'] . " -";
    }

    if (($fp = fopen($filename, 'a')) !== FALSE) {
        if (fwrite($fp, $name) === FALSE) {
            print 'ファイル書き込み失敗:  ' . $filename;
        }

        if (fwrite($fp, $comment) === FALSE) {
            print 'ファイル書き込み失敗:  ' . $filename;
        }

        if (fwrite($fp, $log) === FALSE) {
            print 'アクセスログ書き込み失敗: ' . $filename;
        }
        fclose($fp);
    }
}

$data = array();

if (is_readable($filename) === TRUE) {
    if (($fp = fopen($filename, 'r')) !== FALSE) {
        while (($tmp = fgets($fp)) !== FALSE) {
            $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
        }
        fclose($fp);
    }
} else {
    $data[] = 'ファイルがありません';
}

?>
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
        <form method="post">
            <h2>ひとこと掲示板</h2>
            <label>名前: <input type="text" name="name"></label>
            <label>ひとこと: <input type="text" name="comment"></label>
            <input type="submit" value="送信">
        </form>
        <p>発言一覧</p>
        <ul>
<?php foreach ($data as $read): ?>
        <li><?php print $read; ?></li>
<?php endforeach; ?>
        </ul>
    </body>
</html>
