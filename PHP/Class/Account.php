<?php

/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 29-04-17
 * Time: 12:00
 */
class Account
{

    private $userMail;
    private $accountName;
    private $type;
    private $motto;
    private $balance;

    public function __construct($userMail, $accountName, $type, $motto, $balance)
    {
        $this->userMail = $userMail;
        $this->accountName = $accountName;
        $this->type = $type;
        $this->motto = $motto;
        $this->balance = $balance;
    }

    //-----GETTERS-----//

    /**
     * @return mixed
     */
    public function getAccountName()
    {
        return $this->accountName;
    }

    /**
     * @return mixed
     */
    public function getBalance()
    {
        return $this->balance;
    }

    /**
     * @return mixed
     */
    public function getMotto()
    {
        return $this->motto;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }


    //------------------//

    //-----SETTERS------//

    /**
     * @param mixed $accountName
     */
    public function setAccountName($accountName)
    {
        $this->accountName = $accountName;
        $_SESSION['AccountName'] = $accountName;
    }

    /**
     * @param mixed $balance
     */
    public function setBalance($balance)
    {
        $this->balance = $balance;
        $_SESSION['Balance'] = $balance;
    }

    /**
     * @param mixed $motto
     */
    public function setMotto($motto)
    {
        $this->motto = $motto;
        $_SESSION['Motto'] = $motto;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
        $_SESSION['Type'] = $type;
    }

    /**
     * @param mixed $userMail
     */
    public function setUserMail($userMail)
    {
        $this->userMail = $userMail;
        $_SESSION['UserMail'] = $userMail;
    }



}