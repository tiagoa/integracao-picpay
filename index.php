<?php
$produtos = include('produtos.php');
?>
<!-- criar um formulário para enviar os produtos selecionados -->
<form method="post" action="comprar.php">
  <table border="1">
    <thead>
      <tr>
        <th></th><!-- deixe vazia -->
        <th>Nome</th>
        <th>Descrição</th>
        <th>Valor</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($produtos as $produto) { ?>
      <tr>
        <!-- troque o id por um input checkbox para enviar somente os ids dos produtos desejados -->
        <td><input type="checkbox" name="id[]" value="<?= $produto['id'] ?>"></td>
        <td><?= $produto['nome'] ?></td>
        <td><?= $produto['descricao'] ?></td>
        <td><?= $produto['valor'] ?></td>
      </tr>
    <? } ?>
    </tbody>
  </table>
  <!-- adiciona um botão para enviar o formulário -->
  <input type="submit" value="Comprar">
</form>