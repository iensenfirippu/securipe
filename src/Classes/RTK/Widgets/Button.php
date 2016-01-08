<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains definitions of a button in HTML
	 **/
	class RTK_Button extends HtmlElement
	{
		/**
		 * A button widget
		 * @param string $name The name/id of the button
		 * @param string $title The text written on the button
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
		public function __construct($name='submit', $title='Submit', $args=null)
		{
			HtmlAttributes::Assure($args);
			$args->Add('type', 'submit', false);
			$args->Add('name', $name, false);
			$args->Add('class', 'submit', false);
			$args->Add('value', $title, false);
			
			parent::__construct('input', $args);
		}
	}
}
?>