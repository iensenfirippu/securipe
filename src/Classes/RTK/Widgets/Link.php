<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a link (a/anchor) in HTML
	 **/
	class RTK_Link extends HtmlElement
	{
		/**
		 * A widget containing a clickable link (a)
		 * @param string $url The url of the link
		 * @param string $name The title of the list
		 * @param boolean $forcehttps Specify if the link has to have https
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
		public function __construct($url=EMPTYSTRING, $name=EMPTYSTRING, $forcehttps=false, $args=null)
		{
			HtmlAttributes::Assure($args);
			$args->Add('href', Site::GetBaseURL($forcehttps).$url);
			
			parent::__construct('a', $args, $name);
		}
	}
}
?>