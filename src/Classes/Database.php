<?php
if (defined('securipe') or exit(1))
{
	class Database
	{
		public static function GetLink() { return $GLOBALS['DATABASE']; }
		
		public static function Connect()
		{
			$GLOBALS['DATABASE'] = new mysqli(DBSERVER, DBUSERNAME, DBPASSWORD, DBDATABASE);
			//Database::getInstance()->_connection = new mysqli(DBSERVER, DBUSERNAME, DBPASSWORD, DBDATABASE);
			Database::Check();
		}
		
		public static function Check()
		{
			if (mysqli_connect_errno()) {
				printf("Couldn't connect to database: %s\n", mysqli_connect_error());
				exit(1);
			}
		}
		
		public static function Disconnect()
		{
			// Close database connection
			$GLOBALS['DATABASE']->close();
			//Database::getInstance()->_connection->close();
		}
	}
	
	Database::Connect();
}
?>