<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a text in HTML
	 **/
	class RTK_Textview extends HtmlElement
	{
		public function __construct($text=EMPTYSTRING, $inline=false, $id=null, $class=null, $args=null)
		{
			if ($args == null || !is_array($args)) { $args = array(); }
			if ($id != null && !isset($args['id'])) { $args['id'] = $id; }
			if ($class != null && !isset($args['class'])) { $args['class'] = $class; }
			
			$tag = $inline ? 'span' : 'div';
			parent::__construct($tag, HtmlElement::ArgsToString($args), $text);
		}
	}
	
	new RTK_Textview('text', array("id" => "idjegvilsoegeefter"));
}
?>