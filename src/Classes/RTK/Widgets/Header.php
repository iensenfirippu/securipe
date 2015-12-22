<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a header in HTML
	 **/
	class RTK_Header extends HtmlElement
	{
		public function __construct($text=EMPTYSTRING, $level=1, $args=null)
		{
			if ($args == null || !is_array($args)) { $args = array(); }
			
			$tag = is_numeric($level) && $level > 0 && $level < 9 ? 'h'.$level : 'h1';
			parent::__construct($tag, HtmlElement::ArgsToString($args), $text);
		}
	}
}
?>