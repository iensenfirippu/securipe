<?php
if (defined('securipe') or exit(1))
{
	class Step{
		
		private $stepId;
		private $recipeId;
		private $pictureId;
		private $number;
		private $description;
		
		public function __construct ($_recipeId, $_pictureId, $_number, $_description)
		{
		$this->stepId = $_stepId;
		$this->recipeId = $_recipeId;
		$this->pictureId = $_pictureId;
		$this->number = $_number;
		$this->description = $_description;
		$this->createStep();
		}
		
		public function createStep()
		{	
			if($stmt = Database::GetLink()->prepare('INSERT INTO `Step`(`recipe_id`, `picture_id`, `step_number`, `step_description`) VALUES (?,?,?,?)'))
			{
				$stmt->bindParam(1, $this->recipeId, PDO::PARAM_STR, 255);
				$stmt->bindParam(2, $this->pictureId, PDO::PARAM_STR, 255);
				$stmt->bindParam(3, $this->number, PDO::PARAM_STR, 255);
				$stmt->bindParam(4, $this->description,PDO::PARAM_STR, 255);
				$stmt->execute();
				$stmt->closeCursor();
				$errorMsg =$stmt->errorInfo();
							
				echo "all good";
			}
			else
			{
			echo "<br /><br /><br /><br />all good createRecipe Error: " . $errorMsg[0];;	
			}
		}
		
		public function viewStep()
		{
			if($stmt = Database::GetLink()->prepare('SELECT FROM `Step`(`picture_id`, `step_number`, `step_description`) WHERE (`recipe_id = ?`) VALUES (?,?,?,?)'))
			{
				$stmt->bindParam(1, $this->pictureId, PDO::PARAM_STR, 255);
				$stmt->bindParam(2, $this->number, PDO::PARAM_STR, 255);
				$stmt->bindParam(3, $this->description,PDO::PARAM_STR, 255);
				$stmt->bindParam(4, $this->recipeId, PDO::PARAM_STR, 255);
				$stmt->execute();
				$stmt->closeCursor();
				$errorMsg =$stmt->errorInfo();
				
				echo "all good";
			}
			else 
			{
			echo "<br /><br /><br /><br />all good createRecipe Error: " . $errorMsg[0];;	
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