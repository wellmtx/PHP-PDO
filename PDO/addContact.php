<?php

require_once('config.php');

$number = $_POST['number'];
$name = $_POST['name'];

function addContact($number, $name) 
{

    $addContact = new contacts();
    if (strlen($number) > 12 || strlen($number) < 10) 
    {

        echo "<center>";
        echo "<b> NÚMERO INVÁLIDO!! </b></br></br>";
        echo "<a href=/pdo><button> VOLTE AO INICIO </button></a>";
        echo "</center>";

    } else {

        $addContact->addContact($number, $name);

        echo "<center>";

        if ($addContact->getIdContact() == null) 
        {

            echo "<b> Ocorreu algum erro! Tente novamente! </b></br></br>";
            echo "<a href=/pdo><button> VOLTE AO INICIO </button></a>";

        } else {
            
            echo "<b> CONTATO CRIADO COM SUCESSO </b></br></br>";
            echo "<b> ID: ". $addContact->getIdContact() . "</b></br></br>";
            echo "<b> Jid: ". $addContact->getJID() . "</b></br></br>";
            echo "<b> Nome: ". $addContact->getName() . "</b></br></br>";
            echo "<a href=/pdo><button> VOLTE AO INICIO </button></a>";

        }
    
        echo "</center>";
    }
}

addContact($number, $name);

?>