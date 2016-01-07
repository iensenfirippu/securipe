<?php
if (defined('securipe') or exit(1))
{
	class Recipe{
		
		private $recipeId;
		private $pictureId;
		private $userId = 1;
		private $typeId;
		private $title;
		private $description;
		private $favoriteCount;
		private $disable;
		private $imagepath;
		
		public function __construct ($_title, $_typeId = 0, $_description, $_imagepath)
		{
		
			$this->title 			  = $_title;
			$this->typeId			  = $_typeId;//safty risk need serverside validation
			$this->description 	= $_description;
			$this->imagepath 		= $_imagepath;
		//	vdd($_imagepath);
			//vd(" pictureid " .$this->pictureId);
			//vd(" userID " .$this->userId);
			//vd(" typeId ".$this->typeId);
			//vd(" title " .$this->title);
			//vdd(" decription " .$this->description);
			//
			//
			$this->insertPicture();
	
		}
		
		public function createRecipe ()
		{
			$disable = 0;
				if($stmt = Database::GetLink()->prepare('INSERT INTO `Recipe`(`picture_id`, `user_id`, `type_id`, `recipe_title`, `recipe_des`,`disable`) VALUES (?,?,?,?,?,?)'))
				{
					
					echo "<br />--------------------------------";
					echo "<br />pictureId: ". $this->pictureId;
					echo "<br />userId: ". $this->userId;
					echo "<br />typeId: ". $this->typeId;
					echo "<br />title: ". $this->title;
					echo "<br />description: ". $this->description;
					echo "<br />disable: ". $disable;

					$stmt->bindParam(1, $this->pictureId, PDO::PARAM_INT);
					$stmt->bindParam(2, $this->userId, PDO::PARAM_INT);
					$stmt->bindParam(3, $this->typeId, PDO::PARAM_INT);
					$stmt->bindParam(4, $this->title, PDO::PARAM_STR, 255);
					$stmt->bindParam(5, $this->description, PDO::PARAM_STR, 255);
					$stmt->bindParam(6, $disable, PDO::PARAM_INT);
					$stmt->execute();
					$stmt->closeCursor();
					$errorMsg =$stmt->errorInfo();
					
					echo "<br /><br /><br /><br />all good createRecipe Error: " . $errorMsg[0];;
				}
		
				else
				{
				echo "<br /><br /><br /><br />not good";
				}
		}
		public function insertPicture()
		{
			if($stmt = Database::GetLink()->prepare('INSERT INTO `Picture`(`pic_path`) VALUES (?)'))
				{
					$stmt->bindParam(1, $this->imagepath, PDO::PARAM_STR, 255);
					$stmt->execute();
					$stmt->closeCursor();
					$this->pictureId = Database::GetLink()->lastInsertId();
					$errorMsg =$stmt->errorInfo();
					
					echo "<br /><br /><br /><br />all good insertPicture Error: " . $errorMsg[0];;
					$this->createRecipe();
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
		
		public function __setRecipeId($recipeId, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __setPictureId($pictureId, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		public function __setUserId($userId, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		public function __setTypeId($typeId, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __setTitle($title, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __setDescription($description, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __setFavoriteCount($favoriteCount, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
		
		public function __setDisable($disable, $value) {
			if (property_exists($this, $property)) {
				$this->$property = $value;
			}
			return $this;
		}
	}
}
						//$this->favoriteCount = $favoriteCount;
			//$this->disable = $disable;	
			//$this->userId = $userId;
			//$this->typeId = $typeID;
?>