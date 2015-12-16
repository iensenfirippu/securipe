<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains definitions of a button in HTML
	 **/
	class RTK_Button extends HtmlElement
	{
		public function __construct($name='submit', $title='Submit', $args=null)
		{
			if ($args == null || !is_array($args)) { $args = array(); }
			$args['name'] = $name;
			$args['value'] = $title;
			$args['type'] = 'submit';
			$args['class'] = 'submit';
			
			parent::__construct('input', HtmlElement::ArgsToString($args));
		}
	}
}
?>