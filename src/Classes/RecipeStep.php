<?php
if (defined('securipe') or exit(1))
{
	class RecipeStep
	{
		private $_id = 0;
		//private $_recipe = null;
		private $_picture = null;
		private $_number = 0;
		private $_description = EMPTYSTRING;
		
		Public function GetId() { return $this->_id; }
		//Public function GetRecipe() { return $this->_recipe; }
		Public function GetPicture() { return $this->_picture; }
		Public function GetNumber() { return $this->_number; }
		Public function GetDescription() { return $this->_description; }
		
		public function SetId($value) { $this->_id = $value; }
		//public function SetRecipe($value) { $this->_recipe = $value; }
		public function SetPicture($value) { $this->_picture = $value; }
		public function SetNumber($value) { $this->_number = $value; }
		public function SetDescription($value) { $this->_description = $value; }
		
		public function __construct($id=0)
		{
			if (is_numeric($id)) {
				$id = intval($id);
				if ($id > 0) {
					$this->_id = $id;
				}
			}
		}
		
		public static function Create($recipe, $picture, $number, $description)
		{
			if (is_a($recipe, 'Recipe') && $recipe->GetId() != null)
			{
				$recipeid = $recipe->GetId();
				$pictureid = null;
				//if (is_a($picture, 'Picture')) { $pictureid = $picture->GetId(); }
				
				if ($stmt = Database::GetLink()->prepare('INSERT INTO `Step`(`recipe_id`, `picture_id`, `step_number`, `step_description`) VALUES (?,?,?,?)'))
				{
					$stmt->bindParam(1, $this->recipeId, PDO::PARAM_STR, 255);
					$stmt->bindParam(2, $this->pictureId, PDO::PARAM_STR, 255);
					$stmt->bindParam(3, $this->number, PDO::PARAM_STR, 255);
					$stmt->bindParam(4, $this->description,PDO::PARAM_STR, 255);
					$stmt->execute();
					$stmt->closeCursor();
				}
			}
		}
		
		public static function Load()
		{
			return false;
			/*if ($stmt = Database::GetLink()->prepare('SELECT FROM `Step`(`picture_id`, `step_number`, `step_description`) WHERE (`recipe_id = ?`) VALUES (?,?,?,?)'))
			{
				$stmt->bindParam(1, $this->pictureId, PDO::PARAM_STR, 255);
				$stmt->bindParam(2, $this->number, PDO::PARAM_STR, 255);
				$stmt->bindParam(3, $this->description,PDO::PARAM_STR, 255);
				$stmt->bindParam(4, $this->recipeId, PDO::PARAM_STR, 255);
				$stmt->execute();
				$stmt->closeCursor();
				$errorMsg =$stmt->errorInfo();
			}*/
		}
	}
}
?>