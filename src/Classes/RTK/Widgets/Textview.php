<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a text in HTML
	 **/
	class RTK_Textview extends HtmlElement
	{
		public function __construct($text=EMPTYSTRING, $args=null, $inline=false)
		{
			if ($args == null || !is_array($args)) { $args = array(); }
			
			$tag = $inline ? 'span' : 'div';
			parent::__construct($tag, HtmlElement::ArgsToString($args), $text);
		}
	}
}
?>