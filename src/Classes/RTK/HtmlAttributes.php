<?php
if (defined('RTK') or exit(1))
{
	// Parameter keys that should not have a value assignment
	define("BOOLEANPARAMETERS", "|checked|selected|");

	/**
	 * Contains a list of HTML attributes/parameters
	 * like src="/path/to.file" or style="color:blue;"
	 **/
	class HtmlAttributes extends ListObject
	{
		/**
		 * A list of HTML attributes
		 **/
		public function __construct($attributes=null)
		{
			if (!is_array($attributes)) { $attributes = array(); } 
			$this->_list = $attributes;
		}
		
		public function __tostring()
		{
			$result = EMPTYSTRING;
			if (Value::SetAndNotNull($this->_list) && is_array($this->_list)) {
				ksort($this->_list);
				foreach ($this->_list as $key => $val) {
					if (strstr(BOOLEANPARAMETERS, '|'.$key.'|') && $val == true) {
						$result .= SINGLESPACE.$key;
					} else {
						$result .= SINGLESPACE.$key.'="'.$val.'"';
					}
				}
			}
			return $result;
		}
		
		/**
		 * Add an HTML attributes to the list
		 * @param var $key The key in the array
		 * @param var $value The value to put into the array
		 * @param bool $override Allow override if a value already exists at the specified key
		 **/
		public function Add($key, $value, $override=true)
		{
			if ($value == null) {
				if ($override == true && array_key_exists($key, $this->_list)) {
					$this->Remove([$key]);
				}
			} elseif ($override == true || !array_key_exists($key, $this->_list)) {
				$this->_list[$key] = $value;
			}
		}
		
		/**
		 * Remove an HTML attributes from the list
		 * @param var $key The key of the value to remove from the array
		 **/
		public function Remove($key)
		{
			_array::Remove($this->_list, $key);
		}
		
		/**
		 * Checks if a certain key has a certain value
		 * @param var $key The key in the array
		 * @param var $value The value to check for
		 * @return bool Returns true if the specified key has the specified value
		 **/
		public function KeyHasValue($key, $value)
		{
			$result = false;
			if (array_key_exists($key, $this->_list) && $this->_list[$key] == $value) { $result = true; }
			return $result;
		}
		
		/**
		 * Assures that a variable is an HtmlAttributes object
		 * @param var $var The variable to assure
		 **/
		public static function Assure(& $var) {
			if ($var == null || !is_array($var)) { $var = new HtmlAttributes(); }
			elseif (!is_a($var, 'HtmlAttributes')) { $var = new HtmlAttributes($var); }
		}
	}
}
?>
