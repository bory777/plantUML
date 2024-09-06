<?php
// codeをPOSTから受け取る
$code = $_POST['code'];
$format = $_POST['format'];

// ディレクトリパス
$folderPath = 'temp';

// ディレクトリが存在しない場合は作成する
if (!is_dir($folderPath)) {
    mkdir($folderPath, 0777, true);
}

// ファイルパス
$filePath = $folderPath . '/userCode.txt';

// ファイルに内容を書き込む
$result = file_put_contents($filePath, $code);

// 書き込み結果の確認
if ($result === false) {
    echo false;
} else {
    if (file_exists($folderPath . '/userCode.png')) {
        unlink($folderPath . '/userCode.png');
    }
    if (file_exists($folderPath . '/userCode.svg')) {
        unlink($folderPath . '/userCode.svg');
    }

    $format_command = ($format === "svg") ? "-tsvg" : "";
    
    // plantUMLの実行
    $command = 'java -jar plantUML/plantuml-1.2024.6.jar ' . $format_command . ' ' . $filePath;
    shell_exec($command);
    
    // ダウンロード
    if ($format === "svg") {
        header('Content-Type: image/svg+xml');
        header('Content-Disposition: attachment; filename="userCode.svg"');
        readfile($folderPath . "/userCode.svg");
    } else if ($format === "png") {
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="userCode.png"');
        readfile($folderPath . "/userCode.png");
    } else if ($format === "txt") {
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="userCode.txt"');
        echo $code;
    }
    
    unlink($filePath);
}
?>
