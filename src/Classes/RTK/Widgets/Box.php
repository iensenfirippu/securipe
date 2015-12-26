<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a Box or Container (i.e. div) in HTML
	 **/
	class RTK_Box extends HtmlElement
	{
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