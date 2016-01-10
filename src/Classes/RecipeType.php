<?php
if (defined('securipe') or exit(1))
{
	$GLOBALS['RECIPETYPES'] = array();
	
	class RecipeType
	{
		private static $ALL_LOADED = false;
		
		private $_id = 0;
		private $_name = EMPTYSTRING;
		
		Public function GetId() { return $this->_id; }
		Public function GetName() { return $this->_name; }
		
		public function SetId($value) { $this->_id = $value; }
		public function SetName($value) { $this->_name = $value; }
		
		public function __construct($id=0, $name=EMPTYSTRING)
		{
			if (is_numeric($id)) {
				$id = intval($id);
				if ($id > 0) {
					$this->_id = $id;
				}
			}
			if (is_string($name)) {
				$this->_name = $name;
			}
		}
		
		public static function Load($id)
		{
			$result = false;
			if (Value::SetAndNotNull($GLOBALS['RECIPETYPES'], $id)) {
				$result = $GLOBALS['RECIPETYPES'][$id];
			} else {
				if ($stmt = Database::GetLink()->prepare('SELECT `type_name` FROM `RecipeType` WHERE `type_id`=?;')) {
					$stmt->bindParam(1, $id, PDO::PARAM_INT);
					$stmt->execute();
					$stmt->bindColumn(1, $name);
					
					while ($stmt->fetch()) {
						$result = $GLOBALS['RECIPETYPES'][$id] = new RecipeType($id, $name);
					}
					$stmt->closeCursor();
				}
				if (empty($result)) { $result = false; }
			}
			return $result;
		}
		
		public static function LoadAll()
		{
			$result = null;
			if (RecipeType::$ALL_LOADED == true) { $result = $GLOBALS['RECIPETYPES']; }
			else {
				$result = array();
				if ($stmt = Database::GetLink()->prepare('SELECT `type_id`, `type_name` FROM `RecipeType` ORDER BY `type_id` ASC;')) {
					$stmt->execute();
					$stmt->bindColumn(1, $id);
					$stmt->bindColumn(2, $name);
					while ($stmt->fetch()) {
						$GLOBALS['RECIPETYPES'][$id] = new RecipeType($id, $name);
					}
					$stmt->closeCursor();
					
					$result = $GLOBALS['RECIPETYPES'];
					RecipeType::$ALL_LOADED = true;
				}
				if (empty($result)) { $result = false; }
			}
			return $result;
		}
	}
}
?>