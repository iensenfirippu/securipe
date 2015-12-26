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
			HtmlAttributes::Assure($args);
			if (Site::HasHttps() || $forcehttps) { $args->Add('href', 'https://'.BASEURL.$url); }
			else { $args->Add('href', 'http://'.BASEURL.$url); }
			
			parent::__construct('a', $args, $name);
		}
	}
}
?>