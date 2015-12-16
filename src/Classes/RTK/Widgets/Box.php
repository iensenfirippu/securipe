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
			if ($args == null || !is_array($args)) { $args = array(); }
			if ($id != null) { $args['id'] = $id; }
			if ($class != null) { $args['class'] = $class; }
			
			parent::__construct('div', HtmlElement::ArgsToString($args));
		}
	}
}
?>