<?php

class contacts 
{
    private $idContact;
    private $JID;
    private $name;

    public function setIdContact($idcontact) 
    {
        $this->idContact = $idcontact;
    }

    public function setJID($JID)
    {
        $this->JID = $JID;
    }

    public function setName($name) 
    {
        $this->name = $name;
    }

    public function getIdContact() 
    {
        return $this->idContact;
    }

    public function getJID() 
    {
        return $this->JID;
    }

    public function getName() 
    {
        return $this->name;
    }

    public function addContact($number, $name = '') 
    {
        $sql = new sql();
        $jid = "55".$number."@s.whatsapp.net";

        if (!$this->checkNumberExist($jid)) 
        {

            $sql->execQuery("INSERT INTO tb_usuarios (Jid, name) VALUES (:JID, :NAME)", array(
                ':JID' => $jid,
                ':NAME' => $name
            ));

            $newContact = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = LAST_INSERT_ID()");

            $this->setData($newContact[0]);

        }

    }

    public function searchId($id) 
    {
        $sql = new sql();

        $data = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
            ':ID' => $id
        ));

        if (count($data) > 0) 
        {
            $this->setData($data[0]);
        }
    }

    public function updateData($name) 
    {
        $sql = new sql();

        $sql->execQuery("UPDATE tb_usuarios SET name = :NAME WHERE idusuario = :ID", array(
            ':NAME' => $name,
            ':ID' => $this->getIdContact()
        ));
    }

    public function removeData() 
    {
        $sql = new sql();

        $sql->execQuery("DELETE FROM tb_usuarios WHERE idusuario = :ID", array(
            ':ID' => $this->getIdContact()
        ));
    }

    public function setData($data)
    {
        $this->idContact = $data['idusuario'];
        $this->JID = $data['Jid'];
        $this->name = $data['name'];
    }

    public function checkNumberExist($numberJid) 
    {
        $sql = new sql();

        $exist = $sql->select("SELECT * FROM tb_usuarios WHERE Jid = :JID", array(
            ':JID' => $numberJid
        ));

        if (count($exist) > 0) 
        {
            $this->setData($exist[0]);
        }

        return count($exist) > 0 ? true : false;
    }

    public function __toString() 
    {
        return json_encode(array(
            'idContact' => $this->getIdContact(),
            'JID' => $this->getJID(),
            'name' => $this->getName()
        ));
    }

}

?>