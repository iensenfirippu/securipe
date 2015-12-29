<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a text in HTML
	 **/
	class RTK_Textview extends HtmlElement
	{
		/**
		 * A widget containing text (essentially just a div or span with text)
		 * @param string $text The text to display
		 * @param boolean $inline Determines if the widget should be span(true) or div(false)
		 * @param string $id The HTML #id of the element
		 * @param string $class The HTML .class of element
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
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