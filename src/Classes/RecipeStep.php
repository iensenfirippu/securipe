<?php
if (defined('securipe') or exit(1))
{
	class RecipeStep
	{
		private $_id = 0;
		private $_recipe = null;
		private $_picture = null;
		private $_number = 0;
		private $_description = EMPTYSTRING;
		
		Public function GetId() { return $this->_id; }
		Public function GetRecipe() { return $this->_recipe; }
		Public function GetPicture() { return $this->_picture; }
		Public function GetNumber() { return $this->_number; }
		Public function GetDescription() { return $this->_description; }
		
		public function SetId($value) { $this->_id = $value; }
		public function SetRecipe($value) { $this->_recipe = $value; }
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
		
		public function Create()
		{
			$result = false;
			if (is_a($this->_recipe, 'Recipe') && $this->_recipe->GetId() != null)
			{
				$recipeid = $this->_recipe->GetId();
				
				if ($stmt = Database::GetLink()->prepare('INSERT INTO `Step` (`recipe_id`) VALUES (?);'))
				{
					$stmt->bindParam(1, $recipeid, PDO::PARAM_INT);
					if ($stmt->execute()) {
						$this->_id = Database::GetLink()->lastInsertId();
						$result = true;
					}
					$stmt->closeCursor();
				}
			}
			return $result;
		}
		
		public function Save()
		{
			$result = false;
			
			$picture_id = null;
			if ($this->_picture != null) { $picture_id = $this->_picture->GetId(); }
			$step_number = 100;
			if ($this->_number != null && is_numeric($this->_number) && is_integer(intval($this->_number))) { $step_number = intval($this->_number); }
			else { vdd($this->_number); }
			
			if ($stmt = Database::GetLink()->prepare('UPDATE `Step` SET `picture_id`=?, `step_number`=?, `step_description`=? WHERE `step_id`=?;')) {
				$stmt->bindParam(1, $picture_id, PDO::PARAM_INT);
				$stmt->bindParam(2, $step_number, PDO::PARAM_INT);
				$stmt->bindParam(3, $this->_description, PDO::PARAM_LOB);
				$stmt->bindParam(4, $this->_id, PDO::PARAM_INT);
				
				if ($stmt->execute()) {
					$this->_id = Database::GetLink()->lastInsertId();
					$result = true;
				}
				$stmt->closeCursor();
			}
			
			return $result;
		}
		
		public static function Load($id)
		{
			$result = false;
			
			if ($stmt = Database::GetLink()->prepare('SELECT `recipe_id`, `picture_id`, `step_number`, `step_description` FROM `Step` WHERE `step_id`=?;'))
			{
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->execute();
				$stmt->bindColumn(1, $recipeid);
				$stmt->bindColumn(2, $pictureid);
				$stmt->bindColumn(3, $stepnumber);
				$stmt->bindColumn(4, $stepdescription);
				$stmt->fetch();
				$stmt->closeCursor();
				
				if ($recipeid != null) {
					$step = new RecipeStep($id);
					$step->_recipe = Recipe::Load($recipeid);
					if ($pictureid != null) { $step->_picture = Picture::Load($pictureid); }
					$step->_number = $stepnumber;
					$step->_description = $stepdescription;
					
					$result = $step;
				}
			}
			
			return $result;
		}
		
		public static function LoadAllForRecipe($id)
		{
			$result = false;
			
			if ($stmt = Database::GetLink()->prepare('SELECT `step_id`, `picture_id`, `step_number`, `step_description` FROM `Step` WHERE `recipe_id`=? ORDER BY `step_number` ASC;'))
			{
				$stmt->bindParam(1, $id, PDO::PARAM_INT);
				$stmt->execute();
				$stmt->bindColumn(1, $stepid);
				$stmt->bindColumn(2, $pictureid);
				$stmt->bindColumn(3, $stepnumber);
				$stmt->bindColumn(4, $stepdescription);
				
				while ($stmt->fetch()) {
					$step = new RecipeStep($stepid);
					//$step->_recipe = Recipe::Load($recipeid);
					if ($pictureid != null) { $step->_picture = Picture::Load($pictureid); }
					$step->_number = $stepnumber;
					$step->_description = $stepdescription;
					
					$result[] = $step;
				}
				$stmt->closeCursor();
			}
			
			return $result;
		}
		
		public function Delete()
		{
			$result = false;
			
			if ($stmt = Database::GetLink()->prepare('DELETE FROM `Step` WHERE `step_id`=?;')) {
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
			return $result;
		}
	}
}
?>