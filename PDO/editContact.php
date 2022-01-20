<?php

require_once('config.php');

$userId = $_GET['userid'];

$editContact = new contacts();

$editContact->searchId($userId);

?>
<style>
    
</style>
<center>
<form action='editData.php' method='POST'>
    <span> DADOS DO CONTATO </span>
    </br>
    </br>
    <li>
        <span> Id do contato </span>
        <input type='text' name='iduser' readonly value='<?php echo $editContact->getIdContact() === null ? "'Não encontrado'" : $editContact->getIdContact(); ?>'>
    </li>
    <li>
        <span> Nome do contato: </span>
        <input type="text" name='contactName' value='<?php echo $editContact->getName(); ?>'>
    </li>
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