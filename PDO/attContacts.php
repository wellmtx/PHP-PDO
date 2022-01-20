<?php
require_once('config.php');

function attContacts() 
{

    $ch = curl_init();
    
    curl_setopt_array($ch, array(
        CURLOPT_URL => "https://v4.chatpro.com.br/[EndPoint]/api/v1/contacts",
        CURLOPT_RETURNTRANSFER => true ,
        CURLOPT_CUSTOMREQUEST => "GET" ,
        CURLOPT_HTTPHEADER => array (
        "Authorization: [seuToken]",
        "cache_control: no-cache"
        )
    ));

    $responseContacts = curl_exec($ch);

    curl_close($ch);

    $contacts = json_decode($responseContacts, true);

    if (isset($contacts['code']) == 400 || null) 
    {

        echo "<center>";
        echo "<b> Não foi possível está atualizando a lista de contatos </b>";
        echo "</br></br>";
        echo "<a href=/pdo><button> VOLTAR AO INICIO </button></a>";

    } else {

        insertContacts($contacts);

    }
}

function insertContacts($contactsJSON) 
{
    $sql = new sql();
    foreach ($contactsJSON as $infoProfile) 
    {
        if (!checkNumberExist($infoProfile['Jid'])) 
        {
            if ($infoProfile['Name'] !== '') 
            {
                $sql->execQuery("INSERT INTO tb_usuarios (name, Jid) VALUES (:NAME, :JID)", array(
                    ':NAME' => $infoProfile['Name'],
                    ':JID' => $infoProfile['Jid']
                ));
            }
        }
    }
    echo "<style> center {top: 90} </style>";
    echo "<center><b> Sua lista de contatos foi atualizada com sucesso!!! </b></br></center>";
    echo "</br>";
    echo "<center> <a href=/pdo> <button> VOLTAR PARA O PAINEL </button> </a> </center>";
}

function checkNumberExist($numberJid) 
{
    $sql = new sql();

    $exist = $sql->select("SELECT * FROM tb_usuarios WHERE Jid = :JID", array(
        ':JID' => $numberJid
    ));

    return count($exist) > 0 ? true : false;
}

attContacts();

?>
