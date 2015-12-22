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
			if (!isset($args['name'])) { $args['name'] = $name; }
			if (!isset($args['value'])) { $args['value'] = $title; }
			if (!isset($args['type'])) { $args['type'] = 'submit'; }
			if (!isset($args['class'])) { $args['class'] = 'submit'; }
			
			parent::__construct('input', HtmlElement::ArgsToString($args));
		}
	}
}
?>