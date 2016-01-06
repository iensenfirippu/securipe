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
			if (is_integer($id) && $id > 0) {
				$this->_id = $id;
				// Load from database
			}
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
					$comment->_user = null; // = User::Load($userid);
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
