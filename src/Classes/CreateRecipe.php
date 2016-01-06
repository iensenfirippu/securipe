<?php
if (defined('securipe') or exit(1))
{
	class Recipe{
		
		private $recipeId;
		private $pictureId;
		private $userId;
		private $typeId;
		private $title;
		private $description;
		private $favoriteCount;
		private $disable;
		
		public function __construct ($pictureId, $userId, $typeId, $title, $description, $favoriteCount, $disable)
		{
			$this->pictureId = $pictureId;
			$this->userId = $userId;
			$this->typeId = $typeID;
			$this->title = $title;
			$this->desription = $description;
			$this->favoriteCount = $favoriteCount;
			$this->disable = $disable;	
		}
		
		public function createRecipe ()
		{	
				if($stmt = Database::GetLink()->prepare('INSERT INTO `Recipe`(`picture_id`, `user_id`, `type_id`, `recipe_title`, `recipe_des`, `favorite_count`, `disable`) VALUES (?,?,?,?,?,?,?)'))
				{
					$stmt->bindParam(1, $pictureId, PDO::PARAM_STR, 255);
					$stmt->bindParam(2, $userId, PDO::PARAM_STR, 255);
					$stmt->bindParam(3, $typeId, PDO::PARAM_STR, 255);
					$stmt->bindParam(4, $title, PDO::PARAM_STR, 255);
					$stmt->bindParam(5, $description, PDO::PARAM_STR, 255);
					$stmt->bindParam(6, $favoriteCount,PDO::PARAM_STR, 255);
					$stmt->bindParam(7, $disable, PDO::PARAM_STR, 255);
					$stmt->execute();
					$stmt->closeCursor();
					echo "all good";
				}
		
				else
				{
				echo "not good";
				}
		}
		Public function getRecipeId() { return $this->recipeId; }
		Public function getPictureId() { return $this->pictureId; }
		Public function getUserId(){ return $this->userId; }
		Public function getTypeId(){ return $this->typeId; }
		Public function getTitle(){ return $this->title; }
		Public function getDescription(){ return $this->description; }
		Public function GetFavoriteCount(){ return $this->favoriteCount; }
		Public function GetDisable(){ return $this->disable; }
		
		public function __set($recipeId, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __set($pictureId, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		public function __set($userId, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		public function __set($typeId, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __set($title, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __set($description, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __set($favoriteCount, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __set($disable, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
	}
}
?>