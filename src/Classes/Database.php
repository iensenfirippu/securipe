<?php
if (defined('securipe') or exit(1))
{
	class Database
	{
		public static function GetLink() { return $GLOBALS['DATABASE']; }
		
		public static function Connect()
		{
			$GLOBALS['DATABASE'] = new PDO(DBVENDOR.':host='.DBSERVER.';dbname='.DBDATABASE.';charset='.DBENCODING, DBUSERNAME, DBPASSWORD);
			Database::Check();
		}
		
		public static function Check()
		{
			// TODO: Find out how to check the connection with PDO
		}
		
		public static function Disconnect()
		{
			$GLOBALS['DATABASE'] = null;
		}
	}
	
	Database::Connect();
}
?>