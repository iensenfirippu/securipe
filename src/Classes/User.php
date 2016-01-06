<?php
class User
{
		private $userName;
		private $userNameHashed;
		private $passwordHased;
		private $personalSalt;
		private $firstName;
		private $lastName;
		private $email;
		private $telNo;
		
	  function __construct($_userName, $_password, $_firstName, $_lastName, $_email, $_telNo)
		{
			$this->userName  = $_userName;
			$this->hashUserNameAndPassword($_password);
			$this->firstName = $_firstName;
			$this->lastName  = $_lastName;
			$this->email     = $_email;
			$this->telNo     = $_telNo;

		}

		public function getUserName()
		{
			return $this->userName;
		}
		
		public function setUsername($_userName)
		{
			$this->userName  = $_userName;	
		}
		
		public function getPassword()//// slet måske???
		{
			return $this->password;
		}

		public function setPassword($_password)// slet måske???
		{
			$this->password = $_password;	
		}
		
		public function getFname()
		{
			return $this->firstName;	
		}
		
		public function setFname($_firstName)
		{	 
			$this->firstName  = $_firstName;
		}
		
		public function getLname()
		{
			return $this->lastName;
		}
		
		public function setLname($_lastName)
		{
			$this->lastName  = $_lastName;	
		}
		
		public function getEmail()
		{
			return $this->email;
		}
		
		public function setEmail($_email)
		{
			$this->email  = $_email;	
		}
		
		public function getTelNo()
		{
			return $this->telNo;
		}
		
		public function getUserNameHashed()
		{
		
			return $this->userNameHashed;

		}
			public function getPasswordHashed()
		{
			return $this->passwordHashed;	
		}
		public function getPersonalSalt()
		{
			return $this->personalSalt;	
		}
		
		public function hashUserNameAndPassword($_password)
		{
			
			$md5UserName= md5($this->userName);

			$md5UserNameAndPassword =  md5($this->userName.$_password);//$userName.$password

			$this->userNameHashed = hash('sha512', $md5UserName); //userNameHash $sha512Ofmd5UserName
			
			$this->personalSalt = hash("sha512", UUID::Create());// dynamic salt personal salt sha512OfUUID
			
			$this->passwordHashed = hash("sha512", STATIC_SALT.$md5UserNameAndPassword.	$this->personalSalt.$this->userNameHashed );//password hash
		}
	
		
}


?>










