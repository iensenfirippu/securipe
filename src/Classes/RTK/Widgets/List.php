<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a list in HTML
	 **/
	class RTK_List extends HtmlElement
	{
		/**
		 * A widget containing an unordered list (ul)
		 * @param HtmlElement[] $items The items for the list
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
		public function __construct($items=null, $args=null)
		{
			parent::__construct('ul', $args);
			foreach ($items as $item) {
				if (is_a($item, 'HtmlElement')) {
					$this->AddChild($item);
				}
			}
		}
		
		/**
		 * Adds an item to the list
		 * @param HtmlElement $item The item to add
		 **/
		public function AddItem($item)
		{
			if (is_a($item, 'HtmlElement')) {
				$this->AddChild($item);
			}
		}
	}
}	
?>