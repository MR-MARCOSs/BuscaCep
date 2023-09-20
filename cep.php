<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cep = $_POST["cep"];

    if (preg_match('/^\d{8}$/', $cep)) {
        $urlViaCEP = "https://viacep.com.br/ws/$cep/json/";
        $responseViaCEP = file_get_contents($urlViaCEP);
        $dataViaCEP = json_decode($responseViaCEP, true);

        if (!isset($dataViaCEP["erro"])) {
           
            echo "<h3>Endereço encontrado:</h3>";
            echo "<p>CEP: " . $dataViaCEP["cep"] . "</p>";
            echo "<p>Logradouro: " . $dataViaCEP["logradouro"] . "</p>";
            echo "<p>Complemento: " . $dataViaCEP["complemento"] . "</p>";
            echo "<p>Bairro: " . $dataViaCEP["bairro"] . "</p>";
            echo "<p>Cidade: " . $dataViaCEP["localidade"] . "</p>";
            echo "<p>Estado: " . $dataViaCEP["uf"] . "</p>";
            echo "<p>Código IBGE: " . $dataViaCEP["ibge"] . "</p>";
            echo "<p>DDD: " . $dataViaCEP["ddd"] . "</p>";

            $cepForMaps = str_replace("-", "", $cep); 
            echo "<p><a href='https://www.google.com/maps?q=$cepForMaps' target='_blank'>Ver no Google Maps</a></p>";
        } else {
            echo "<p>CEP não encontrado.</p>";
        }
    } else {
        echo "<p>CEP inválido. Certifique-se de que o CEP possui 8 dígitos.</p>";
    }
}
?>

