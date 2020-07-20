<?php
// pega o corpo da requisição
$payload = json_decode(file_get_contents('php://input'), true);
// token
$picPayToken = 'seu-token-aqui';
// monta a url
$url = 'https://appws.picpay.com/ecommerce/public/payments/'.$payload['referenceId'].'/status';
// inicializa o cURL
$ch = curl_init();
// fornece a url de destino
curl_setopt($ch, CURLOPT_URL, $url);
// passa o parâmetro para retornar a resposta
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// enviar os headers obrigatórios
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'X-Picpay-Token: ' . $picPayToken
]);
// faz a requisição
$result = curl_exec($ch);
// prepara o registro
$linha = date('d/m/Y H:i:s') . ' - ' . $result . "\n";
// armazena a resposta
file_put_contents('notificacoes.txt', $linha, FILE_APPEND);
// aborta caso aconteça algum erro
if (curl_errno($ch)) {
    die('Error: ' . curl_error($ch));
}
// fecha a conexão
curl_close($ch);