<?php
if (defined('securipe') or exit(1))
{
	$GLOBALS['COMMENTS'] = array();
	
	class Comment
	{
		protected $_id = 0;
		protected $_contents = EMPTYSTRING;
		protected $_timestamp = 0;
		protected $_path = EMPTYSTRING;
		protected $_comments = array();
		protected $_user = null;
		
		public function GetId() { return $this->_id; }
		public function GetContents() { return $this->_contents; }
		public function GetTimestamp() { return $this->_timestamp; }
		public function GetTime() { return Time::TimestampToHumanTime($this->_timestamp); }
		public function GetComments() { return $this->_comments; }
		public function HasComments() { return !empty($this->_comments); }
		public function GetUser() { return $this->_user; }
		
		public function SetContents($value) { if (is_string($value)) { $this->_contents = $value; } }
		public function SetTimestamp($value) { if (is_integer($value)) { $this->_timestamp = $value; } }
		
		public function __construct($id)
		{
			if (is_numeric($id)) {
				$id = intval($id);
				if ($id > 0) {
					$this->_id = $id;
				}
				// Load from database
			}
		}
		
		public static function Insert($message, $recipe, $id=EMPTYSTRING)
		{
			$result = false;
			if (Site::HasHttps() && Login::IsLoggedIn()) {
				if (Value::SetAndNotEmpty($message) && Value::SetAndNotNull($recipe)) {
					$path = 'R='.$recipe;
					
					if ($id != EMPTYSTRING) {
						if ($stmt = Database::GetLink()->prepare('SELECT `comment_path` FROM `Comment` WHERE `comment_path` LIKE ?;')) {
							$stmt->bindParam(1, $path, PDO::PARAM_STR, 255);
							$stmt->execute();
							$stmt->bindColumn(1, $result);
							$stmt->fetch();
							$stmt->closeCursor();
							
							if ($result != null && _string::StartsWith($result, $path)) { $path = $result.'>'.$id; }
							else { $path = null; }
						}
					}
					
					if ($path != null) {
						$userid = Login::GetId();
						$timestamp = time();
						
						if ($stmt = Database::GetLink()->prepare('INSERT INTO `Comment` (`user_id`, `comment_path`, `comment_contents`, `sent_at`) VALUES (?, ?, ?, ?);')) {
							$stmt->bindParam(1, $userid, PDO::PARAM_INT);
							$stmt->bindParam(2, $path, PDO::PARAM_STR, 255);
							$stmt->bindParam(3, $message, PDO::PARAM_STR, 255);
							$stmt->bindParam(4, $timestamp, PDO::PARAM_INT);
							$stmt->execute();
							$stmt->closeCursor();
						}
					}
				}
			}
			return $result;
		}
		
		public static function LoadComments($id)
		{
			$comments = array();
			$search = $id.'%%';
			
			if ($stmt = Database::GetLink()->prepare('SELECT `comment_id`, `user_id`, `comment_path`, `comment_contents`, `sent_at` FROM `Comment` WHERE `comment_path` LIKE ? ORDER BY `comment_path`, `sent_at` ASC;')) {
				$stmt->bindParam(1, $search, PDO::PARAM_STR, 255);
				$stmt->execute();
				$stmt->bindColumn(1, $commentid);
				$stmt->bindColumn(2, $userid);
				$stmt->bindColumn(3, $path);
				$stmt->bindColumn(4, $contents);
				$stmt->bindColumn(5, $timestamp);
				
				while ($stmt->fetch()) {
					$comment = new Comment($commentid);
					$comment->_user = User::Load($userid);
					$comment->_contents = $contents;
					$comment->_timestamp = $timestamp;
					$GLOBALS['COMMENTS'][$commentid] = $comment;
					
					if ($path == $id) { $comments[] = $GLOBALS['COMMENTS'][$commentid]; }
					else {
						$parts = explode('>', $path);
						$lastid = end($parts);
						if (is_numeric($lastid)) {
							$lastid = intval($lastid);
							if (array_key_exists($lastid, $GLOBALS['COMMENTS'])) {
								$parent = $GLOBALS['COMMENTS'][$lastid];
								$parent->_comments[] = $comment;
							}
						}
					}
				}
			
				$stmt->closeCursor();
				
				return $comments;
			}
		}
	}
}
?>
