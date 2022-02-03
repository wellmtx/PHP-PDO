<?php 

require_once("config.php");

$totalContacts = 25;
$pc = 1;
$sql = new sql();

if (isset($_GET['pag']))
{
    $pc = $_GET['pag'];
}

$inicioContacts = $pc - 1;
$inicioContacts = $inicioContacts * $totalContacts;

$pgContacts = $sql->select("SELECT * FROM tb_usuarios LIMIT $inicioContacts, $totalContacts");

$allContacts = $sql->select("SELECT * FROM tb_usuarios");

$totalPag = count($allContacts) / $totalContacts;

$anterior = $pc - 1;
$prox = $pc + 1;

//////////////////////////////////////////// TABELA CONTATOS ///////////////////////////////////////////////////////////

function createTableContacts($pgContacts) 
{
    $html = "<tr>";

    foreach($pgContacts as $key => $values) 
    {

        $html .= "<th name='id'>" . $pgContacts[$key]['idusuario'] . "</th>";

        $html .= "<th name='jid'>" . $pgContacts[$key]['Jid'] . "</th>";

        $html .= "<th name='name'>" . $pgContacts[$key]['name'] . "</th>";

        $html .= "<th><a href=/pdo/?edit=1&userid=".$pgContacts[$key]['idusuario']."><button> EDITAR </button></a></th>";

        $html .= "<th><a href=/pdo/?delet=1&userid=".$pgContacts[$key]['idusuario']."><button> DELETAR </button></a></th>";

        $html .= "</tr>";

    }

    return $html;

}

//////////////////////////////////////////// EDITAR USUÁRIO ///////////////////////////////////////////////////////////

if (isset($_GET['userid']) && isset($_GET['edit']) == 1) 
{
    $userId = $_GET['userid'];

    $editContact = new contacts();

    $editContact->searchId($userId);

    ?>

    <style> ul, li { list-style: none; }</style>

<center>
<form method="GET">
    <span> DADOS DO CONTATO </span>
    </br>
    </br>
    <li>
        <span> Id do contato: </span>
        <?php echo $editContact->getIdContact() === null ? "<b>Não encontrado</b>" : "<input type='text' name='userid' value=".$editContact->getIdContact().">"; ?>
    </li>
    <br>
    <li>
        <span> Nome do contato: </span>
        <input type="text" name='contactName' value='<?php echo $editContact->getName(); ?>'>
    </li>
    <br>
    <li>
        <span> JID do contato: </span>
        <input type="text" readonly value=<?php echo $editContact->getJID(); ?>>
    </li>
    </br>
    <li>
        <button type="submit"> ALTERAR </button>    <a href='/pdo'><button type="button"> CANCELAR </button></a>
    </li>
</form>

</center>

<?php

} else if (isset($_GET['userid']) && isset($_GET['contactName'])) {
    {
        $contactName = $_GET['contactName'];
        $contactId = $_GET['userid'];

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
    }
}

//////////////////////////////////////////// ADICIONAR CONTATO ///////////////////////////////////////////////////////////

else if(isset($_GET['name']) && isset($_GET['number'])) 
{
    $number = $_GET['number'];
    $name = $_GET['name'];

    function addContact($number, $name) 
    {

        $addContact = new contacts();
        if (strlen($number) > 12 || strlen($number) < 10) 
        {

            echo "<center>";
            echo "<b> NÚMERO INVÁLIDO!! </b></br></br>";
            echo "<a href=/pdo><button> VOLTE AO INICIO </button></a>";
            echo "</center>";

        }   else {

            if($addContact->addContact($number, $name) !== true) 
            {

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
            } else {

                echo "<center>";
                echo "<b> CONTATO JÁ EXISTENTE! </b></br></br>";
                echo "<a href=/pdo><button> VOLTE AO INICIO </button></a>";
                echo "</center>";
                
            }
        }
    }

    addContact($number, $name);
}

//////////////////////////////////////////// EXCLUIR USUÁRIO ///////////////////////////////////////////////////////////

else if(isset($_GET['delet']) == 1 && isset($_GET['userid'])) 
{
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
}

//////////////////////////////////////////// ATUALIZAR LISTA DE CONTATOS ///////////////////////////////////////////////////////////

else if(isset($_GET['attcontact']) == 1) 
{
    function attContacts() 
    {

        $ch = curl_init();
    
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://v4.chatpro.com.br/chatpro-xbcsytl3hj/api/v1/contacts",
            CURLOPT_RETURNTRANSFER => true ,
            CURLOPT_CUSTOMREQUEST => "GET" ,
            CURLOPT_HTTPHEADER => array (
            "Authorization: 8r7d2vx43ll3hm9kp07s9812tviyr3",
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
}

//////////////////////////////////////////// LISTA DE CONTATOS DO BANCO DE DADOS ///////////////////////////////////////////////////////////
else 
{

?>
<style> ul, li { list-style: none; } </style>
<body>
<div width="1600"><center>

    <a href='/pdo/?attcontact=1'><button> ATUALIZAR LISTA DE CONTATOS </button></a> </br> </br>
    <form method='GET'> <span> Número: </span> <input type='text' name='number'> <span> Nome: </span> <input type='text' name='name'></br></br><button type='submit'> ADICIONAR CONTATO </button> </form>

    <table border="1">
        <tr><td><center> ID </center></td> <td><center> JID </center></td> <td><center> NOME </center></td>

    <?php echo createTableContacts($pgContacts); ?>

    </table>
    </br></br>

    <?php
    
    if ($pc > 1) 
    {
        echo "<a href=?pag=$anterior><button> ANTERIOR </button></a>";
    }
    echo " || ";
    if ($pc < $totalPag) 
    {
        echo "<a href=?pag=$prox><button> PRÓXIMO </button></a>";
    }
    echo "</br></br>";
    echo "<b>" . $pc . "</b>";
    
    ?>

</center>
</div>

</body>
<?php

}

?>
