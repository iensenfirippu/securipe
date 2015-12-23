<?php
if (defined('securipe') or exit(1))
{
	class ListObject implements Iterator
	{
		public $_list;
		private $_index = 0;
		public $_nb;
		public $_nbTotal;
		
		/**
		 * list navigation
		 */
		public function rewind() { $this->_index = 0;}
		public function current() { $k = array_keys($this->_list); $var = $this->_list[$k[$this->_index]]; return $var; }
		public function key() { $k = array_keys($this->_list); $var = $k[$this->_index]; return $var; }
		public function next() { $k = array_keys($this->_list); if (isset($k[++$this->_index])) { $var = $this->_list[$k[$this->_index]]; return $var; } else { return false; } }
		public function valid() { $k = array_keys($this->_list); $var = isset($k[$this->_index]);return $var; }
		//public function Add($item) { $this->_list[] = $item; }
		
		/**
		 * Constructor
		 */
		public function __construct()
		{
			$this->_list = array();
			$this->_nb = 0;
			$this->_nbTotal = 0;
			return $this;
		}
	}
}
?>