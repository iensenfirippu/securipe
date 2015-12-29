<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a list in HTML
	 **/
	class RTK_Listview extends HtmlElement
	{
		protected $_rows = 0;
		protected $_compressedcols = array();
		protected $_altenaterow;
		protected $_altenatecell;
		protected $_nextrow;
		
		/**
		 * A widget for displaying a list of items
		 * @param string[] $columnheaders The headers in the top row
		 * @param boolean $alternaterow Determines if different styling should be applied to every other row
		 * @param boolean $alternatecell Determines if different styling should be applied to every other cell
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
		public function __construct($columnheaders, $alternaterow=true, $alternatecell=false, $args=null)
		{
			parent::__construct('table', $args);
			if ($alternaterow == false) { $this->_alternaterow = null; }
			else { $this->_alternaterow = true; }
			if ($alternatecell == false) { $this->_alternatecell = null; }
			else { $this->_alternatecell = true; }
			
			if (sizeof($columnheaders) > 0) {
				for ($i = 0; $i < sizeof($columnheaders); $i++) {
					$string = $columnheaders[$i];
					
					if (is_string($string) && strlen($string) > 0 && $string[0] == '_') {
						$this->_compressedcols[] = $i;
						$columnheaders[$i] = substr($columnheaders[$i], 1);
					}
				}
				
				$this->AddHeader($columnheaders);
			}
		}
		
		public function __tostring()
		{
			$this->Finalize();
			return parent::__tostring();
		}
		
		/**
		 * In order to apply a "finalrow" class to the final row isn't appended until the Listview is finalized
		 **/
		private function Finalize()
		{
			$this->AppendRow($this->_nextrow, null);
		}
		
		/**
		 * Gets the class for a specific row
		 * @param integer $i The index of the row
		 * @param boolean $isheader Determines whether the row is a header row or not
		 **/
		private function GetRowClass($i, $isheader=false)
		{
			// reset alternatecell, so every row starts with the same type of cell
			if ($this->_alternatecell !== null) { $this->_alternatecell = true; }
			
			$value = 'table_row';
			if ($i === 0) { $value .= ' table_first_row'; }
			if ($isheader) { $value .= ' table_header_row'; }
			else {
				_bool::Flip($this->_alternaterow);
				if ($this->_alternaterow) { $value .= ' table_alternate_row'; }
			}
			if ($i === null) { $value .= ' table_last_row'; }
			
			return $value;
		}
		
		/**
		 * Gets the class for a specific cell
		 * @param integer $i The index of the cell
		 * @param integer $last The index of the last cell in the row
		 * @param boolean $isheader Determines whether the cell is in a header row or not
		 **/
		private function GetCellClass($i, $last, $isheader=false)
		{
			$value = 'table_cell';
			_bool::Flip($this->_alternatecell);
			if ($i === 0) { $value .= ' table_first_cell'; }
			if ($isheader)
			{
				$value .= ' table_header_cell';
				if ($this->_alternatecell) { $value .= ' table_alternate_header_cell'; }
			}
			if ($this->_alternatecell) { $value .= ' table_alternate_cell'; }
			if ($i == $last) { $value .= ' table_last_cell'; }
			if (in_array($i, $this->_compressedcols)) { $value .= ' table_compressed_cell'; }
			return $value;
		}
		
		/**
		 * Adds a header row to the listview
		 * @param string[] $row The titles to go into the header
		 **/
		private function AddHeader($row)
		{
			$header = new HtmlElement('tr', array('class' => $this->GetRowClass($this->_rows, true)));
			
			$rowsize = sizeof($row) -1;
			for ($i = 0; $i <= $rowsize; $i++) {
				$header->AddChild(new HtmlElement('td', array('class' => $this->GetCellClass($i, $rowsize, true)), $row[$i]));
			}
			
			$this->AddChild($header);
			$this->_rows++;
		}
		
		/**
		 * Adds a row to the listview
		 * @param string[] $row The values to go into the header
		 **/
		public function AddRow($row)
		{
			if ($this->_nextrow != null) {
				$this->AppendRow($this->_nextrow, $this->_rows);
				$this->_rows++;
			}
			
			$this->_nextrow = $row;
		}
		
		/**
		 * Appends a row to the listview
		 * @param string[] $row The values to put into the row
		 * @param integer $i The index of the row
		 **/
		private function AppendRow($row, $i)
		{
			$line = new HtmlElement('tr', array('class' => $this->GetRowClass($i)));
			
			$rowsize = sizeof($row) -1;
			for ($i = 0; $i <= $rowsize; $i++) {
				if (is_a($row[$i], 'HtmlElement')) {
					$line->AddChild(new HtmlElement('td', array('class' => $this->GetCellClass($i, $rowsize)), EMPTYSTRING, $row[$i]));
				} else {
					$line->AddChild(new HtmlElement('td', array('class' => $this->GetCellClass($i, $rowsize)), $row[$i]));
				}
			}
			
			$this->AddChild($line);
		}
	}
}	
?>