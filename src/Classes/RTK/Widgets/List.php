<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a list in HTML
	 **/
	class RTK_List extends HtmlElement
	{
		public function __construct($items=null, $args=null)
		{
			parent::__construct('ul', $args);
			foreach ($items as $item) {
				if (is_a($item, 'HtmlElement')) {
					$this->AddChild($item);
				}
			}
		}
		
		public function AddItem($item)
		{
			if (is_a($item, 'HtmlElement')) {
				$this->AddChild($item);
			}
		}
	}
}	
?>