<?php
class CreateRecipe{

	public function createRecipe()
			{	
			
			$recipeId = "1";
			$pictureId = "1232";
			$userId = "1234";
			$recipeName = "Boller i karry";
			$recipeType = "12323";
			$recipeFavoriteCount = "9000";
			$recipeDisable = "0";
			$stepId1 = "Use curry";
			$stepId2 = "Use balls";
			$stepId3 = "Mix curry with balls";
			$stepId4 = "Cook";
			$stepId5 = "Curry balls";

					if($stmt = Database::GetLink()->prepare('INSERT INTO `Recipe`(`recipe_id`, `picture_id`, `user_id`, `recipe_type`, `user_name`) VALUES (?,?,?,?,?)'))
					{
						$stmt->bindParam(1, $sv1, PDO::PARAM_STR, 255);
						$stmt->bindParam(2, $semail, PDO::PARAM_STR, 255);
						$stmt->bindParam(3, $semail2, PDO::PARAM_STR, 255);
						$stmt->bindParam(4, $v4, PDO::PARAM_STR, 255);
						$stmt->bindParam(5, $sv2,PDO::PARAM_STR, 255);
						$stmt->execute();
						$stmt->closeCursor();
						echo "all good";
					}		
					else
					{
					echo "not good";
					}	
			}
}
?>