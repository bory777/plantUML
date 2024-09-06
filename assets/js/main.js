document.getElementById('answerCodeButton').addEventListener('click', ()=> {
    var img = document.getElementById('answerImage');
    img.style.display = 'none'
    var code = document.getElementById('answerCodeHtml');
    code.style.display = 'inline';
});

document.getElementById('answerUMLButton').addEventListener('click', () => {
    var img = document.getElementById('answerImage');
    img.style.display = 'inline'
    var code = document.getElementById('answerCodeHtml');
    code.style.display = 'none';
});

require.config({
    paths: {
        vs: "https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs",
    },
});

require(["vs/editor/editor.main"], ()=> {
    var editor = monaco.editor.create(document.getElementById('editor'), {
        value: "",
        language: "markdown",
    });

    let timeout;
    editor.onDidChangeModelContent(()=> {
        var placeholder = document.getElementById("placeholder");
        if (editor.getValue()) {
            placeholder.style.display = "none";
        } else {
            placeholder.style.display = "block";
        }

        var codeInput = document.getElementById('code');
        codeInput.value = editor.getValue();

        clearTimeout(timeout);
        timeout = setTimeout(()=> {
            fetch('generateUML.php', {
                method: 'POST',
                headers: {
                    'Content-Type' : 'application/x-www-form-urlencoded',
                },
                body: 'code=' + encodeURIComponent(editor.getValue()),
            })
            .then(response => response.text())
            .then(data => {
                var img = document.getElementById('userImage');
                if (data) {
                    img.src = "temp/userCode.png" + '?t=' + new Date().getTime();
                    img.style.display = 'inline';
                } else {
                    img.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error: ', error);
            });
        }, 300);
    });
});