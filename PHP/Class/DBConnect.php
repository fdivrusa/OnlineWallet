<?php

/**
 * Created by IntelliJ IDEA.
 * User: Di Vrusa Florian
 * Date: 27-04-17
 * Time: 09:11
 */
class DBConnect
{
    private $_db;
    private $_host;
    private $_nameDB;
    private $_user;
    private $_pwd;

    function __construct()
    {
        $this->_host = 'localhost';
        $this->_user = 'OnlineWalletAdmin';
        $this->_nameDB = 'onlinewalletdb';
        $this->_pwd = '77I9c2OGFDYf10wO';
        $this->connect();
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    public function connect()
    {
        //Connexion à la BDD
        try {
            $this->_db = new PDO('mysql:host=' . $this->_host . ';dbname=' . $this->_nameDB . '', $this->_user, $this->_pwd);
        } catch (Exception $e) {

            die('Error : ' . $e->getMessage()); //Permet de ne pas continuer les instructions (alias de exit())
        }
    }

    //deco de la BDD
    public function disconnect()
    {
        $this->_db = null;
    }

    //Retourne la connexion à la BDD
    function getDBConnection()
    {
        if ($this->_db instanceof PDO) {
            return $this->_db;
        }
    }

}