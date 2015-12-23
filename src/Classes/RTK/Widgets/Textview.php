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
			if ($args == null || !is_array($args)) { $args = new HtmlAttributes(); }
			elseif (!is_a($args, 'HtmlAttributes')) { $args = new HtmlAttributes($args); }
			
			if ($id != null) { $args->Add('id', $id); }
			if ($class != null) { $args->Add('class', $class); }
			
			$tag = $inline ? 'span' : 'div';
			parent::__construct($tag, $args, $text);
		}
	}
}
?>