<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a Box or Container (i.e. div) in HTML
	 **/
	class RTK_Box extends HtmlElement
	{
		/**
		 * A widget for containing/structuring other widgets (div)
		 * @param string $id The HTML #id of the box
		 * @param string $class The HTML .class of box
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
		public function __construct($id=null, $class=null, $args=null)
		{
			HtmlAttributes::Assure($args);
			$args->Add('id', $id);
			$args->Add('class', $class);
			
			parent::__construct('div', $args);
		}
	}
}
?>