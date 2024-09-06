<?php
//JSONデータの読み込み
$jsonString = file_get_contents('index.json');
$questionList = json_decode($jsonString, true);

//GETパラメータからidを取得
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

//idに応じたquestionを取得
$selectQuestion = null;
foreach ($questionList as $question) {
    if ($question['id'] === $id) {
        $selectQuestion = $question;
        break;
    }
}

$answerCode = $selectQuestion['uml'];
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>plantUML 練習サイト</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.35.0/min/vs/editor/editor.main.css">
</head>
<body>
    <div>
        <h1><?=$id . ":" . $selectQuestion['title'] ?></h1>
    </div>
    <div class="editor-container">
        <div id="editor" class="editor-box">
            <div id="placeholder" class="placeholder">ここにコードを入力して下さい。</div>
        </div>
        <div id="preview" class="preview-box">
            <img id="userImage" src="" alt="userUMLImg" class="uml-image">
        </div>
        <div id="answer" class="answer-box">
            <div>
                <button type="button" id="answerUMLButton">AnswerUML</button>
                <button type="button" id="answerCodeButton">AnswerCode</button>
            </div>
            <img id="answerImage" src="/temp/answerCode<?= $selectQuestion['id'] ?>.png" alt="<?= $selectQuestion['title'] ?>" class="uml-image">
            <div style="width: 100%; height: 100%; padding:10px;">
                <pre id="answerCodeHtml" class="code-box" style="display: none;"><?= $answerCode ?></pre>
                <img id="answerImg" src="/temp/answerCode<?= $selectQuestion['id'] ?>.png" alt="<?= $selectQuestion['title'] ?>" class="uml-image">
            </div>
        </div>
    </div>

    <form id="editorForm" action="generateUML.php" method="post">
        <input type="hidden" id="code" name="code">
        <label for="format">Download format</label>
        <select name="format" id="format">
            <option value="png">.png</option>
            <option value="svg">.svg</option>
            <option value="txt">.txt</option>
        </select>
        <button type="submit">Download</button>
    </form>
    <!-- monacoエディタの読み込み -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/loader.min.js"></script>
    <script src="/assets/js/main.js"></script>
</body>
</html>