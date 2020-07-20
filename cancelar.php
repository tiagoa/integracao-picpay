<?php
if (empty($_GET) && !isset($_GET['referencia'])) {
    die('Forneça a refência');
}
$picPayToken = 'seu-token-aqui';
// inicializa o cURL
$ch = curl_init();
// monta a URL
$url = 'https://appws.picpay.com/ecommerce/public/payments/' . $_GET['referencia'] . '/cancellations';
// fornece a url de destino
curl_setopt($ch, CURLOPT_URL, $url);
// passa o parâmetro para retornar a resposta
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// informa que iremos fazer uma requisição utilizando o método POST
curl_setopt($ch, CURLOPT_POST, true);
// envia o código de autorização caso necessário
if (isset($_GET['autorizacao'])) {
    $autorizacao = ['authorizationId' => $_GET['autorizacao']];
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($autorizacao));
}
// envia os headers obrigatórios
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Picpay-Token: ' . $picPayToken
]);
// faz a requisição
$result = curl_exec($ch);
// armazena a resposta
$resposta = json_decode($result);
// exibe o conteúdo da resposta
var_dump($resposta);
// aborta caso aconteça algum erro
if (curl_errno($ch)) {
    die('Erro: ' . curl_error($ch));
}
// fecha a conexão
curl_close($ch);
?>
Transação cancelada com sucesso!
<br>
Caso queira, <a href="status.php?referencia=<?= $_GET['referencia'] ?>">consulte o status novamente</a>.