<?php

/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 29-04-17
 * Time: 12:00
 */
class Transaction
{

    private $idAccount;
    private $title;
    private $category;
    private $value;
    private $date;

    public function __construct($idAccount, $title, $category, $value, $date)
    {
        $this->idAccount = $idAccount;
        $this->title = $title;
        $this->category = $category;
        $this->value = $value;
        $this->date = $date;
    }

    //-----GETTERS-----//

    /**
     * @return mixed
     */
    public function getIdAccount()
    {
        return $this->idAccount;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    //------------------//

    //-----SETTERS------//

    /**
     * @param mixed $idAccount
     */
    public function setIdAccount($idAccount)
    {
        $this->idAccount = $idAccount;
        $_SESSION['idAccount'] = $idAccount;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
        $_SESSION['Title'] = $title;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
        $_SESSION['Category'] = $category;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
        $_SESSION['Value'] = $value;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
        $_SESSION['Date'] = $date;
    }

}