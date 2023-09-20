<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de CEP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        input[type="text"] {
            padding: 10px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        #endereco {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Consulta de CEP</h2>
        <form method="post" id="cepForm">
            <input type="text" name="cep" id="cepInput" placeholder="Digite o CEP">
            <button type="button" onclick="buscarEndereco()">Buscar</button>
        </form>
        <div id="endereco">
            <!-- O endereço será exibido aqui -->
        </div>
    </div>

    <script>
        function buscarEndereco() {
            const cepInput = document.getElementById('cepInput').value;
            const enderecoDiv = document.getElementById('endereco');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'cep.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    enderecoDiv.innerHTML = xhr.responseText;
                } else if (xhr.readyState === 4) {
                    enderecoDiv.innerHTML = '<p>CEP não encontrado.</p>';
                }
            };

            xhr.send('cep=' + cepInput);
        }
    </script>
</body>
</html>