<?php
//JSONデータの読み込み
$jsonString = file_get_contents('index.json');
//JSONデータをphp配列に
$questionList = json_decode($jsonString, true);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>plantUML 練習サイト</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <main style="max-width: 800px; margin: auto;">
        <div style="text-align: center; margin-top: 20px;">
            <h1>plantUML 練習サイト</h1>
        </div>
        <table class="question-table">
            <tr style="background-color:lightgreen;">
                <th>ID</th>
                <th>Title</th>
                <th>Theme</th>
            </tr>
            <?php foreach ($questionList as $question) : ?>
            <tr class="row" onclick="window.location.href='question.php?id=<?= $question['id'] ?>'">
                <td><?= $question['id'] ?></td>
                <td class="row-title"><?= $question['title'] ?></td>
                <td><?= $question['theme'] ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </main>
</body>
</html>