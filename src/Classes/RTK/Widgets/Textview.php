<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a text in HTML
	 **/
	class RTK_Textview extends HtmlElement
	{
		public function __construct($text=EMPTYSTRING, $inline=false, $id=null, $class=null, $args=null)
		{
			HtmlAttributes::Assure($args);
			$args->Add('id', $id);
			$args->Add('class', $class);
			
			$tag = $inline ? 'span' : 'div';
			parent::__construct($tag, $args, $text);
		}
	}
}
?>