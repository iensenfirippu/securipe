<?php
if (defined('RTK') or exit(1))
{
	// Parameter keys that should not have a value assignment
	define("SOLITARYPARAMETERS", "|checked|selected|");

	class HtmlAttributes extends ListObject
	{
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
					if (strstr(SOLITARYPARAMETERS, '|'.$key.'|') && $val == true) {
						$result .= SINGLESPACE.$key;
					} else {
						$result .= SINGLESPACE.$key.'="'.$val.'"';
					}
				}
			}
			return $result;
		}
		
		public function Add($key, $value, $override=true)
		{
			if ($override == true || !array_key_exists($key, $this->_list)) {
				$this->_list[$key] = $value;
			}
		}
		
		public function Remove($key)
		{
			_array::Remove($this->_list, $key);
		}
		
		public function KeyHasValue($key, $value)
		{
			$result = false;
			if (array_key_exists($key, $this->_list) && $this->_list[$key] == $value) { $result = true; }
			return $result;
		}
		
		public static function Assure(& $var) {
			if ($var == null || !is_array($var)) { $var = new HtmlAttributes(); }
			elseif (!is_a($var, 'HtmlAttributes')) { $var = new HtmlAttributes($var); }
		}
	}
}
?>
