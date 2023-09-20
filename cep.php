<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cep = $_POST["cep"];

    if (preg_match('/^\d{8}$/', $cep)) {
        $urlViaCEP = "https://viacep.com.br/ws/$cep/json/";
        $responseViaCEP = file_get_contents($urlViaCEP);
        $dataViaCEP = json_decode($responseViaCEP, true);

        if (!isset($dataViaCEP["erro"])) {
            $endereco = urlencode($dataViaCEP["logradouro"] . ", " . $dataViaCEP["bairro"] . ", " . $dataViaCEP["localidade"] . " - " . $dataViaCEP["uf"]);


            $googleMapsAPIKey = "chavapigoogle"; 
            $urlGeocoding = "https://maps.googleapis.com/maps/api/geocode/json?address=$endereco&key=$googleMapsAPIKey";

            $ch = curl_init($urlGeocoding);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $responseGeocoding = curl_exec($ch);
            curl_close($ch);

            $dataGeocoding = json_decode($responseGeocoding, true);

            if (isset($dataGeocoding["results"][0]["geometry"]["location"]["lat"]) && isset($dataGeocoding["results"][0]["geometry"]["location"]["lng"])) {
                $latitude = $dataGeocoding["results"][0]["geometry"]["location"]["lat"];
                $longitude = $dataGeocoding["results"][0]["geometry"]["location"]["lng"];


                echo "<h3>Endereço encontrado:</h3>";
                echo "<p>CEP: " . $dataViaCEP["cep"] . "</p>";
                echo "<p>Logradouro: " . $dataViaCEP["logradouro"] . "</p>";
                echo "<p>Complemento: " . $dataViaCEP["complemento"] . "</p>";
                echo "<p>Bairro: " . $dataViaCEP["bairro"] . "</p>";
                echo "<p>Cidade: " . $dataViaCEP["localidade"] . "</p>";
                echo "<p>Estado: " . $dataViaCEP["uf"] . "</p>";
                echo "<p>Código IBGE: " . $dataViaCEP["ibge"] . "</p>";
                echo "<p>DDD: " . $dataViaCEP["ddd"] . "</p>";

                echo "<p><a href='https://www.google.com/maps?q=$latitude,$longitude' target='_blank'>Ver no Google Maps</a></p>";
            } else {
                
                echo "<h3>Endereço encontrado:</h3>";
                echo "<p>CEP: " . $dataViaCEP["cep"] . "</p>";
                echo "<p>Logradouro: " . $dataViaCEP["logradouro"] . "</p>";
                echo "<p>Complemento: " . $dataViaCEP["complemento"] . "</p>";
                echo "<p>Bairro: " . $dataViaCEP["bairro"] . "</p>";
                echo "<p>Cidade: " . $dataViaCEP["localidade"] . "</p>";
                echo "<p>Estado: " . $dataViaCEP["uf"] . "</p>";
                echo "<p>Código IBGE: " . $dataViaCEP["ibge"] . "</p>";
                echo "<p>DDD: " . $dataViaCEP["ddd"] . "</p>";
                echo "<p>Endereço não encontrado no Google maps (tirei a api key pra atividade)</p>";
            }
        } else {
            echo "<p>CEP não encontrado.</p>";
        }
    } else {
        echo "<p>CEP inválido. Certifique-se de que o CEP possui 8 dígitos.</p>";
    }
}
?>




