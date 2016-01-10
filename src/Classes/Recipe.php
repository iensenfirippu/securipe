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
		
		public function __construct($id=0)
		{
			if (is_numeric($id)) {
				$id = intval($id);
				if ($id > 0) {
					$this->_id = $id;
				}
			}
		}
		
		public function Create()
		{
			$result = false;
			
			$picture_id = null;
			if ($this->_picture != null) { $picture_id = $this->_picture->GetId(); }
			$user_id = null;
			if ($this->_user != null) { $user_id = $this->_user->GetId(); }
			$type_id = 0;
			if ($this->_type != null && is_a($this->_type, 'RecipeType')) { $type_id = $this->_type->GetId() ; }
			
			if ($stmt = Database::GetLink()->prepare('INSERT INTO `Recipe`(`user_id`, `type_id`, `favorite_count`, `disabled`) VALUES (?,1,0,true)')) {
				$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
				
				if ($stmt->execute()) {
					$this->_id = Database::GetLink()->lastInsertId();
					$return = true;
				}
				
				$stmt->closeCursor();
			}
			return $result;
		}
		
		public function Save()
		{
			$result = false;
			
			$picture_id = null;
			if ($this->_picture != null) { $picture_id = $this->_picture->GetId(); }
			$type_id = 1;
			if ($this->_type != null && is_a($this->_type, 'RecipeType')) { $type_id = $this->_type->GetId() ; }
			
			if ($stmt = Database::GetLink()->prepare('UPDATE `Recipe` SET `picture_id`=?, `type_id`=?, `recipe_title`=?, `recipe_description`=?, `disabled`=? WHERE `recipe_id`=?;')) {
				$stmt->bindParam(1, $picture_id, PDO::PARAM_INT);
				$stmt->bindParam(2, $type_id, PDO::PARAM_INT);
				$stmt->bindParam(3, $this->_title, PDO::PARAM_STR, 255);
				$stmt->bindParam(4, $this->_description, PDO::PARAM_LOB);
				$stmt->bindParam(5, $this->_disabled, PDO::PARAM_BOOL);
				$stmt->bindParam(6, $this->_id, PDO::PARAM_INT);
				
				if ($stmt->execute()) {
					$result = true;
				}
				
				$stmt->closeCursor();
			}
			
			return $result;
		}
		
		public static function Load($id)
		{
			$result = false;
			if ($stmt = Database::GetLink()->prepare('SELECT `picture_id`, `user_id`, `type_id`, `recipe_title`, `recipe_description`, `disabled` FROM `Recipe` WHERE `recipe_id` = ?;'))
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
					$recipe->_user = User::Load($userId);
					if ($pictureId != null) { $recipe->_picture = Picture::Load($pictureId); }
					if ($typeId != null) { $recipe->_type = RecipeType::Load($typeId); }
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
			if ($stmt = Database::GetLink()->prepare('SELECT `recipe_id`, `picture_id`, `user_id`, `type_id`, `recipe_title`, `recipe_description`, `disabled` FROM `Recipe` WHERE `disabled`=false LIMIT ?,?;')) {
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
					if ($pictureId != null) { $recipe->_picture = new Picture($pictureId); }
					if ($typeId != null) { $recipe->_type = new RecipeType($typeId); }
					$recipe->_title = $title;
					$recipe->_description = $description;
					$recipe->_disabled = $disabled;
					
					$result[] = $recipe;
				}
				$stmt->closeCursor();
				
				foreach ($result as $recipe) {
					if ($recipe->_picture != null) { $recipe->_picture = Picture::Load($recipe->_picture->GetId()); }
					if ($recipe->_type != null) { $recipe->_type = RecipeType::Load($recipe->_type->GetId()); }
				}
			}
			if (empty($result)) { $result = false; }
			return $result;
		}
		
		public static function LoadForUser($user, $amount, $page)
		{
			$result = array();
			if (is_a($user, 'User') && $user->GetId() != 0) {
				$userid = $user->GetId();
				$page = ($amount * $page);
				if ($stmt = Database::GetLink()->prepare('SELECT `recipe_id`, `picture_id`, `user_id`, `type_id`, `recipe_title`, `recipe_description`, `disabled` FROM `Recipe` WHERE `user_id`=? LIMIT ?,?;')) {
					$stmt->bindParam(1, $userid, PDO::PARAM_INT);
					$stmt->bindParam(2, $page, PDO::PARAM_INT);
					$stmt->bindParam(3, $amount, PDO::PARAM_INT);
					$stmt->execute();
					$stmt->bindColumn(1, $recipeid);
					$stmt->bindColumn(2, $pictureid);
					$stmt->bindColumn(3, $userid);
					$stmt->bindColumn(4, $typeid);
					$stmt->bindColumn(5, $title);
					$stmt->bindColumn(6, $description);
					$stmt->bindColumn(7, $disabled);
					
					while ($stmt->fetch()) {
						$recipe = new Recipe($recipeid);
						$recipe->_user = User::Load($userid);
						if ($pictureid != null) { $recipe->_picture = Picture::Load($pictureid); }
						if ($typeid != null) { $recipe->_type = RecipeType::Load($typeid); }
						$recipe->_title = $title;
						$recipe->_description = $description;
						$recipe->_disabled = $disabled;
						
						$result[] = $recipe;
					}
					$stmt->closeCursor();
				}
				if (empty($result)) { $result = false; }
			}
			return $result;
		}
		
		public function Delete()
		{
			$result = 0;
			
			// First load and delete all steps
			$this->LoadSteps();
			foreach ($this->GetSteps() as $step) { if (!$step->Delete()) { $result++; } }
			
			// Continue if there were no errors
			if ($result == 0) {
				if ($stmt = Database::GetLink()->prepare('DELETE FROM `Recipe` WHERE `recipe_id`=?;')) {
					$stmt->bindParam(1, $this->_id, PDO::PARAM_INT);
					if ($stmt->execute()) {
						if ($this->GetPicture() != null) {
							if ($this->GetPicture()->Delete()) {
								$result = true;
							}
						} else { $result = true; }
					}
					$stmt->closeCursor();
				}
			} else { $result = false; }
			return $result;
		}
		
		/**
		 * Implement later
		 **/
		public function LoadSteps()
		{
			$result = false;
			if ($steps = RecipeStep::LoadAllForRecipe($this->_id)) {
				$this->_steps = $steps;
				$result = true;
			}
			return $result;
		}
	}
}
?>