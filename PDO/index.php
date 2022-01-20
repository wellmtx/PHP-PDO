<?php 

require_once("config.php");

$totalContacts = 25;
$pag = 1;
$pc = $pag;

if (isset($_GET['pag']))
{
    $pc = $_GET['pag'];
}

$inicioContacts = $pc - 1;
$inicioContacts = $inicioContacts * $totalContacts;

$sql = new sql();

$pgContacts = $sql->select("SELECT * FROM tb_usuarios LIMIT $inicioContacts, $totalContacts");

$allContacts = $sql->select("SELECT * FROM tb_usuarios");

$totalPag = count($allContacts) / $totalContacts;

function createTableContacts($pgContacts) 
{
    $html = "<tr>";

    foreach($pgContacts as $key => $values) 
    {

        $html .= "<th name='id'>" . $pgContacts[$key]['idusuario'] . "</th>";

        $html .= "<th name='jid'>" . $pgContacts[$key]['Jid'] . "</th>";

        $html .= "<th name='name'>" . $pgContacts[$key]['name'] . "</th>";

        $html .= "<th><a href=editContact.php/?userid=".$pgContacts[$key]['idusuario']."><button> EDITAR </button></a></th>";

        $html .= "<th><a href=deletContact.php/?userid=".$pgContacts[$key]['idusuario']."><button> DELETAR </button></a></th>";

        $html .= "</tr>";

    }

    return $html;

}

$anterior = $pc - 1;
$prox = $pc + 1;

?>
<style> ul, li { list-style: none; } </style>
<body>
<div width="1600"><center>

    <a href=attContacts.php><button> ATUALIZAR LISTA DE CONTATOS </button></a>

    </br></br>

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
    echo "||";
    if ($pc < $totalPag) 
    {
        echo "<a href=?pag=$prox><button> PRÓXIMO </button></a>";
        echo "</br></br>";
    }
    
    ?>

</center>
</div>

</body>
