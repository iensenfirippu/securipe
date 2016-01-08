<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a dropdown selector (combobox) in HTML
	 **/
	class RTK_DropDown extends HtmlElement
	{
		/**
		 * A widget containing a dropdown selector
		 * @param string $name The HTML name of the element
		 * @param string[][] $options An array of options, each of which is an array of value and title
		 * @param string $selected The value of the selected item in the dropdown
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
		public function __construct($name, $options, $selected=null, $args=null)
		{
			HtmlAttributes::Assure($args);
			$args->Add('name', $name);
			
			parent::__construct('select', $args);
			
			$option_value = EMPTYSTRING;
			$option_title = EMPTYSTRING;
			foreach ($options as $option) {
				if (_array::IsLongerThan($option, 1)) {
					$option_value = $option[0];
					$option_title = $option[1];
				} else { $option_value = $option_title = $option; }
				
				$optionargs = new HtmlAttributes();
				$optionargs->Add('value', $option_value);
				if ($selected == $option_value) { $optionargs->Add('selected', true); }
				
				$this->AddChild(new HtmlElement('option', $optionargs, $option_title));
			}
		}
	}
}
?>