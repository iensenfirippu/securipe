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
			if ($args == null || !is_array($args)) { $args = array(); }
			$args['name'] = $name;
			
			parent::__construct('select', HtmlElement::ArgsToString($args));
			
			$o_value = EMPTYSTRING;
			$o_title = EMPTYSTRING;
			foreach ($options as $option)
			{
				if (_array::IsLongerThan($option, 1))
				{
					$o_value = $option[0];
					$o_title = $option[1];
				}
				else { $o_value = $o_title = $option; }
				
				$optionargs = array('value' => $o_value);
				if ($selected == $o_value) { $optionargs['selected'] = true; }
				$this->AddChild(new HtmlElement('option', HtmlElement::ArgsToString($optionargs), $o_title));
			}
		}
	}
}
?>