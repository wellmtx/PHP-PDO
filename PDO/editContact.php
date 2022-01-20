<?php

require_once('config.php');

$userId = $_GET['userid'];

$editContact = new contacts();

$editContact->searchId($userId);

?>
<style> ul, li { list-style: none; } </style>

<center>
<form action='/pdo/editData.php?iduser=<?php echo $userId; ?>' method='POST'>
    <span> DADOS DO CONTATO </span>
    </br>
    </br>
    <li>
        <span> Id do contato: </span>
        <?php echo $editContact->getIdContact() === null ? "<b>Não encontrado</b>" : "<b>".$editContact->getIdContact()."</b>"; ?>
    </li>
    <br>
    <li>
        <span> Nome do contato: </span>
        <input type="text" name='contactName' value='<?php echo $editContact->getName(); ?>'>
    </li>
    <br>
    <li>
        <span> JID do contato: </span>
        <input type="text" name='contactJID' readonly value=<?php echo $editContact->getJID(); ?>>
    </li>
    </br>
    <li>
        <button type="submit"> ALTERAR </button>    <a href='/pdo'><button type="button"> CANCELAR </button></a>
    </li>
</form>
</center>
