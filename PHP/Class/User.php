<?php

/**
 * Created by IntelliJ IDEA.
 * User: flori
 * Date: 29-04-17
 * Time: 12:00
 */
class User
{

    private $mail;
    private $name;
    private $firstName;
    private $pwd;
    private $userRight;

    public function __construct($mail, $name, $firstName, $pwd, $userRight)
    {
        $this->mail = $mail;
        $this->name = $name;
        $this->firstName = $firstName;
        $this->pwd = $pwd;
        $this->userRight = $userRight;
    }

    //-----GETTERS-----//

    /**
     * @return mixed
     */
    public
    function getMail()
    {
        return $this->mail;
    }

    /**
     * @return mixed
     */
    public
    function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public
    function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @return mixed
     */
    public
    function getPwd()
    {
        return $this->pwd;
    }

    /**
     * @return mixed
     */
    public
    function getUserRight()
    {
        return $this->userRight;
    }
    //------------------//

    //-----SETTERS------//

    /**
     * @param mixed $name
     */
    public
    function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $mail
     */
    public
    function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @param mixed $userRight
     */
    public
    function setUserRight($userRight)
    {
        $this->userRight = $userRight;
    }

    /**
     * @param mixed $firstName
     */
    public
    function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    //-------------//

}