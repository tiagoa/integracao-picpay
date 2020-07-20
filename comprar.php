<?php
//caso não tenha selecionado nenhum produto e enviado o formulário, retorna para index.php
if (empty($_POST)) {
    header('location: index.php');
}

//recuperar os produtos para obter os valores
$produtos = include('produtos.php');

$total = 0;
//iterar sobre os produtos selecionados
foreach ($_POST['id'] as $id) {
    $total += $produtos[$id]['valor'];
}
echo 'Total: ' . $total;

$solicitacao = [
    'referenceId' => microtime(true),
    'callbackUrl' => 'http://'.$_SERVER['HTTP_HOST'].'/notificacao.php',
    'value' => $total,
    'buyer' => [
        'firstName' => 'João',
        'lastName' => 'Da Silva',
        'document' => '123.456.789-10',
        'email' => 'test@picpay.com',
        'phone' => '+55 27 12345-6789'
    ]
];
$picPayToken = 'seu-token-aqui';
// inicializar o cURL
$ch = curl_init();
// fornecer a url de destino
curl_setopt($ch, CURLOPT_URL, 'https://appws.picpay.com/ecommerce/public/payments');
// passar o parâmetro para retornar a resposta
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// fornecer os dados necessários para gerar o QR Code
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($solicitacao));
// informar que iremos fazer uma requisição utilizando o método POST
curl_setopt($ch, CURLOPT_POST, true);

// enviar os headers obrigatórios
$headers = [];
$headers[] = 'Content-Type: application/json';
$headers[] = 'X-Picpay-Token: ' . $picPayToken;
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// fazer a requisição
$result = curl_exec($ch);
// armazenar a resposta
$resposta = json_decode($result);
// exibir o conteúdo da resposta
var_dump($resposta);
// abortar caso aconteça algum erro
if (curl_errno($ch)) {
    die('Erro: ' . curl_error($ch));
}
// fechar a conexão
curl_close($ch);
?>
<img src="<?= $resposta->qrcode->base64 ?>" alt="QR Code">
<br>
<a href="<?= $resposta->qrcode->content ?>" title="Ir para o site do PicPay">Pagar no PicPay</a>
<br>
<a href="status.php?referencia=<?= $resposta->referenceId ?>" title="Consultar o status">Consultar o status</a>
<br>
<a href="index.php" title="Voltar para os produtos">Voltar para os produtos</a>