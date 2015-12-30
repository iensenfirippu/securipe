<?php

 class User
{
    private $fromDB;
    private $userID;
    private $userName;
    private $password;
    private $firstName;
    private $lastName;
    private $email;
    private $telePhoneNo;
    private $priveledgeLvl;
    
    
    public function __construct($userName, $password, $firstName, $lastName, $email, $priveledgeLvl, $telePhoneNo, $userID = null)
    {
        $this->userName = $userName;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->telePhoneNo = $telePhoneNo;
        $this->priveledgeLvl = $priveledgeLvl;
    }

        function getUser()
        {
            return this;
        }
        
        function setUser()
        
        {
         
        }
 }

?>