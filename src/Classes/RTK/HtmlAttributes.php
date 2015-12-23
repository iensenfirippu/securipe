<?php
if (defined('RTK') or exit(1))
{
	// Parameter keys that should not have a value assignment
	define("SOLITARYPARAMETERS", "|checked|selected|");

	class HtmlAttributes extends ListObject
	{
		public function __construct($attributes=null)
		{
			if (is_array($attributes)) {
				$this->_list = $attributes;
			}
		}
		
		public function __tostring()
		{
			$result = EMPTYSTRING;
			if ($args != null) {
				if (is_array($args)) {
					ksort($args);
					foreach ($args as $key => $val) {
						if (strstr(SOLITARYPARAMETERS, '|'.$key.'|') && $val == true) {
							$result .= SINGLESPACE.$key;
						} else {
							$result .= SINGLESPACE.$key.'="'.$val.'"';
						}
					}
				}
			}			
			return trim($result);
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
	}
}
?>
