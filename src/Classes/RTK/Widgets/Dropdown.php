<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a dropdown selector (combobox) in HTML
	 **/
	class RTK_DropDown extends HtmlElement
	{
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