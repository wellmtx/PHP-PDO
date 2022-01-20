<?php 
require_once('config.php');

$contactName = $_POST['contactName'];
$contactId = $_GET['iduser'];

function editData($id, $name) 
{
    $userEdited = new contacts();

    $userEdited->searchId($id);

    $oldName = $userEdited->getName();

    $userEdited->updateData($name);

    echo "<center>";
    echo "<span><b> NOME ANTIGO: {$oldName} </b></span>";
    echo "</br></br>";
    
    actualData($id);
    
}

function actualData($id) 
{
    $sql = new sql();

    $searchName = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
        ':ID' => $id
    ));

    $newName = $searchName[0]['name'];

    echo "<span><b> NOME NOVO: {$newName} </b></span>";
    echo "</br></br>";
    echo "<b>O nome do contato foi alterado com sucesso!!</b>";
    echo "</br></br>";
    echo "<a href=/pdo><button> VOLTAR AO INICIO </BUTTON></a>";
    echo "</center>";
}

editData($contactId, $contactName);

?>
