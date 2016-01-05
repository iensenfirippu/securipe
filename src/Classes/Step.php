<?php
if (defined('securipe') or exit(1))
{
	class Step{
		
		private $stepId = null;
		private $recipeId = null;
		private $pictureId = null;
		private $number = null;
		private $description = null;
		
		public function __construct ()
		{
		$stepId = "Use curry";
		$recipeId = "";
		$pictureId = "";
		$number = "1";
		$description = "step description";
		}
		
		public function createRecipe()
		{	
			if($stmt = Database::GetLink()->prepare('INSERT INTO `Step`(`step_id`, `recipe_id`, `picture_id`, `step_number`, `step_des`) VALUES (?,?,?,?,?)'))
			{
				$stmt->bindParam(1, $stepId, PDO::PARAM_STR, 255);
				$stmt->bindParam(2, $recipeId, PDO::PARAM_STR, 255);
				$stmt->bindParam(3, $pictureId, PDO::PARAM_STR, 255);
				$stmt->bindParam(4, $number, PDO::PARAM_STR, 255);
				$stmt->bindParam(5, $description,PDO::PARAM_STR, 255);
				$stmt->execute();
				$stmt->closeCursor();
				echo "all good";
			}
		}
	
		Public function getStepId() { return $this->stepId; }
		Public function getRecipeId() { return $this->recipeId; }
		Public function getPictureId(){ return $this->pictureId; }
		Public function getStepNumber(){ return $this->number; }
		Public function getStepDescription(){ return $this->description; }
		
		public function __set($stepId, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
		return $this;
		}
		
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
		
		public function __set($number, $value) {
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
}
?>