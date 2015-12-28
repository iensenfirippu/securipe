<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a header in HTML
	 **/
	class RTK_Header extends HtmlElement
	{
		/**
		 * A widget for displaying a title/header (h1)
		 * @param string $text The text in the title
		 * @param integer $level The level (or "debth") of the title
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
		public function __construct($text=EMPTYSTRING, $level=1, $args=null)
		{
			$tag = is_numeric($level) && $level > 0 && $level < 9 ? 'h'.$level : 'h1';
			parent::__construct($tag, $args, $text);
		}
	}
}
?>