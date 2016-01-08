<?php
if (defined('securipe') or exit(1))
{
	class Recipe
	{
		private $_id = 0;
		private $_picture = null;
		private $_user = null;
		private $_type = null;
		private $_title = EMPTYSTRING;
		private $_description = EMPTYSTRING;
		private $_favoriteCount = 0;
		private $_disabled = false;
		private $_steps = array();
		
		public function __construct($id=0)
		{
			if (is_numeric($id)) {
				$id = intval($id);
				if ($id > 0) {
					$this->_id = $id;
				}
			}
		}
		
		public static function Load($id)
		{
			$result = false;
			if($stmt = Database::GetLink()->prepare('SELECT `picture_id`, `user_id`, `type_id`, `recipe_title`, `recipe_description`, `disabled` FROM `Recipe` WHERE `recipe_id` = ?;'))
			{
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->execute();
				$stmt->bindColumn(1, $pictureId);
				$stmt->bindColumn(2, $userId);
				$stmt->bindColumn(3, $typeId);
				$stmt->bindColumn(4, $title);
				$stmt->bindColumn(5, $description);
				$stmt->bindColumn(6, $disabled);
				$stmt->fetch();
				$stmt->closeCursor();
				
				if ($userId != null) {
					$recipe = new Recipe($id);
					//$recipe->_user = User::Load($userId);
					//if ($pictureId != null) { $recipe->_picture = Image::Load($pictureId); }
					//if ($typeId != null) { $recipe->_type = Recipe::GetTypeName($typeId); }
					$recipe->_title = $title;
					$recipe->_description = $description;
					$recipe->_disabled = $disabled;
					
					$result = $recipe;
				}
			}
			return $result;
		}
		
		public static function LoadNewest($amount, $page)
		{
			$result = array();
			$page = ($amount * $page);
			if($stmt = Database::GetLink()->prepare('SELECT `recipe_id`, `picture_id`, `user_id`, `type_id`, `recipe_title`, `recipe_description`, `disabled` FROM `Recipe` LIMIT ?,?;'))
			{
				$stmt->bindParam(1, $page, PDO::PARAM_INT);
				$stmt->bindParam(2, $amount, PDO::PARAM_INT);
				$stmt->execute();
				$stmt->bindColumn(1, $recipeId);
				$stmt->bindColumn(2, $pictureId);
				$stmt->bindColumn(3, $userId);
				$stmt->bindColumn(4, $typeId);
				$stmt->bindColumn(5, $title);
				$stmt->bindColumn(6, $description);
				$stmt->bindColumn(7, $disabled);
				
				while ($stmt->fetch()) {
					$recipe = new Recipe($recipeId);
					$recipe->_user = User::Load($userId);
					//if ($pictureId != null) { $recipe->_picture = Image::Load($pictureId); }
					//if ($typeId != null) { $recipe->_type = Recipe::GetTypeName($typeId); }
					$recipe->_title = $title;
					$recipe->_description = $description;
					$recipe->_disabled = $disabled;
					
					$result[] = $recipe;
				}
				$stmt->closeCursor();
			}
			if (empty($result)) { $result = false; }
			return $result;
		}
		
		public static function GetTypes()
		{
			$result = array();
			if($stmt = Database::GetLink()->prepare('SELECT `type_id`, `type_name` FROM `RecipeType`;'))
			{
				$stmt->execute();
				$stmt->bindColumn(1, $id);
				$stmt->bindColumn(2, $name);
				
				while ($stmt->fetch()) {
					$result[] = array($id, $name);
				}
				$stmt->closeCursor();
			}
			if (empty($result)) { $result = false; }
			return $result;
		}
		
		public static function Create()
		{
			$disable = 0;
			if($stmt = Database::GetLink()->prepare('INSERT INTO `Recipe`(`picture_id`, `user_id`, `type_id`, `recipe_title`, `recipe_des`,`disable`) VALUES (?,?,?,?,?,?)'))
			{
				$stmt->bindParam(1, $this->pictureId, PDO::PARAM_INT);
				$stmt->bindParam(2, $this->userId, PDO::PARAM_INT);
				$stmt->bindParam(3, $this->typeId, PDO::PARAM_INT);
				$stmt->bindParam(4, $this->title, PDO::PARAM_STR, 255);
				$stmt->bindParam(5, $this->description, PDO::PARAM_STR, 255);
				$stmt->bindParam(6, $disable, PDO::PARAM_INT);
				$stmt->execute();
				$stmt->closeCursor();
				$errorMsg =$stmt->errorInfo();
			}
		}
		
		public function insertPicture()
		{
			if ($stmt = Database::GetLink()->prepare('INSERT INTO `Picture`(`pic_path`) VALUES (?)')) {
				$stmt->bindParam(1, $this->imagepath, PDO::PARAM_STR, 255);
				$stmt->execute();
				$stmt->closeCursor();
				$this->pictureId = Database::GetLink()->lastInsertId();
				$errorMsg =$stmt->errorInfo();
				
				$this->createRecipe();
			}
		}
		
		/**
		 * Implement later
		 **/
		public function LoadSteps()
		{
			/*$comments = array();
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
			}*/
		}
		
		Public function GetId() { return $this->_id; }
		Public function GetPicture() { return $this->_picture; }
		Public function GetUser() { return $this->_user; }
		Public function GetType() { return $this->_type; }
		Public function GetTitle() { return $this->_title; }
		Public function GetDescription() { return $this->_description; }
		Public function GetFavoriteCount() { return $this->_favoriteCount; }
		Public function GetDisabled() { return $this->_disabled; }
		Public function GetSteps() { return $this->_steps; }
		
		public function SetId($value) { $this->_id = $value; }
		public function SetPicture($value) { $this->_picture = $value; }
		public function SetUser($value) { $this->_user = $value; }
		public function SetType($value) { $this->_type = $value; }
		public function SetTitle($value) { $this->_title = $value; }
		public function SetDescription($value) { $this->_description = $value; }
		public function SetDisabled($value) { $this->_disabled = $value; }
	}
}
?>