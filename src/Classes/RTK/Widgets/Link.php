<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a link (a/anchor) in HTML
	 **/
	class RTK_Link extends HtmlElement
	{
		public function __construct($url=EMPTYSTRING, $name=EMPTYSTRING, $args=null)
		{
			if ($args == null || !is_array($args)) { $args = array(); }
			$args['href'] = $url;
			
			parent::__construct('a', HtmlElement::ArgsToString($args), $name);
		}
	}
}
?>