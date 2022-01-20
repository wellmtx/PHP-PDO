<?php
require_once ('config.php');

$idUser = $_GET['userid'];

function deletContact($id) 
{

    $userRemoved = new contacts();

    $userRemoved->searchId($id);

    if ($userRemoved->getIdContact() != null)
    {

        $userName = $userRemoved->getName();

        $userRemoved->removeData();

        echo "<center>";
        echo "<b> O contato {$userName} foi excluído com sucesso!! </b>";
        echo "</br></br>";
        echo "<a href=/pdo><button> VOLTE AO INICIO </button></a>";
        echo "</center>";

    } else if ($userRemoved->getIdContact() == null) 
    {
        echo "<center>";
        echo "<b> Não foi encontrando nenhum usuário </b>";
        echo "</br></br>";
        echo "<a href=/pdo><button> VOLTE AO INICIO </button></a>";
        echo "</center>";
    }
}

deletContact($idUser);
?>