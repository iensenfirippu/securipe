<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a link (a/anchor) in HTML
	 **/
	class RTK_Link extends HtmlElement
	{
		public function __construct($url=EMPTYSTRING, $name=EMPTYSTRING, $forcehttps=false, $args=null)
		{
			if ($args == null || !is_array($args)) { $args = array(); }
			if (Site::HasHttps() || $forcehttps) { $args['href'] = 'https://'.BASEURL.$url; }
			else { $args['href'] = 'http://'.BASEURL.$url; }
			
			parent::__construct('a', HtmlElement::ArgsToString($args), $name);
		}
	}
}
?>