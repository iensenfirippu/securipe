<?php
if (defined('securipe') or exit(1))
{
	/**
	 * Contains logic for connecting to the database
	 */
	class Database
	{
		/**
		 * Returns the current database connection ($GLOBALS['DATABASE'])
		 */
		public static function GetLink() { return $GLOBALS['DATABASE']; }
		
		/**
		 * Tries to connect to the database
		 */
		public static function Connect()
		{
			$GLOBALS['DATABASE'] = new PDO(DBVENDOR.':host='.DBSERVER.';dbname='.DBDATABASE.';charset='.DBENCODING, DBUSERNAME, DBPASSWORD);
			Database::Check();
		}
		
		/**
		 * Checks if a connection to the database has been established
		 */
		public static function Check()
		{
			// TODO: Find out how to check the connection with PDO
		}
		
		/**
		 * Disconnects from the database
		 */
		public static function Disconnect()
		{
			$GLOBALS['DATABASE'] = null;
		}
	}
	
	Database::Connect();
}
?>