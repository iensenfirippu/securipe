<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a user form in HTML
	 **/
	class RTK_Form extends HtmlElement
	{
		public function __construct($name=EMPTYSTRING, $action=EMPTYSTRING, $method='POST', $usetoken=true)
		{
			parent::__construct('form', 'name="'.$name.'" id="'.$name.'" action="'.$action.'" method="'.$method.'"');
			if ($usetoken) {
				$this->AddHiddenField('securitytoken', Site::CreateSecurityToken());
			}
			$this->_containers = array();
		}
		
		public function AddText($text, $container=null)
		{
			$field = new HtmlElement('div', 'class="formtext"', $text);
			$this->AddToContainer($field, $container);
		}
		
		public function AddHiddenField($name, $value=null, $container=null)
		{
			$field = new HtmlElement('input', 'type="hidden" name="'.$name.'" id="'.$name.'" value="'.$value.'"');
			$this->AddToContainer($field, $container);
		}
		
		public function AddTextField($name, $title, $value=null, $size=null, $container=null)
		{
			$field = new HtmlElement('div', 'class="formline"');
			$field->AddChild(new HtmlElement('label', 'for="'.$name.'"', $title));
			
			if ($size == null || intval($size) <= 0) {
				$field->AddChild(new HtmlElement('input', 'type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'"'));
			} else {
				$field->AddChild(new HtmlElement('textarea', 'name="'.$name.'" rows="'.$size.'"', $value));
			}
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddPasswordField($name, $title, $container=null)
		{
			$field = new HtmlElement('div', 'class="formline"');
			$field->AddChild(new HtmlElement('label', 'for="'.$name.'"', $title));
			$field->AddChild(new HtmlElement('input', 'type="password" name="'.$name.'" id="'.$name.'"'));
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddCheckBox($name, $title, $checked=false, $value='true', $text=null, $container=null)
		{
			$field = new HtmlElement('div', 'class="formline"');
			$field->AddChild(new HtmlElement('label', 'for="'.$name.'"', $title));
			
			$checkedtext = EMPTYSTRING; if ($checked) { $checkedtext = ' checked'; }
			$field->AddChild(new HtmlElement('input', 'class="checkbox" type="checkbox" name="'.$name.'" value="'.$value.'"'.$checkedtext));
			
			if ($text != null) { $field->AddChild(new HtmlElement('span', EMPTYSTRING, $text)); }
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddRadioButtons($name, $title, $options, $selected=null, $container=null)
		{
			$buttons = new HtmlElement('div', 'class="radiobuttons"');
			
			$o_value = EMPTYSTRING;
			$o_title = EMPTYSTRING;
			foreach ($options as $option)
			{
				if (General::IsArrayLongerThan($option, 1))
				{
					$o_value = $option[0];
					$o_title = $option[1];
				}
				else { $o_value = $o_title = $option; }
				
				$checked = EMPTYSTRING; if ($selected == $o_value) { $checked = ' checked'; }
				//$buttons->AddChild(new HtmlElement('input', array('type' => 'radio', 'name' => $name, 'value' => $o_title, 'checked' => $checked));
				$buttons->AddChild(new HtmlElement('input', 'type="radio" name="'.$name.'" value="'.$o_title.'"'.$checked));
			}
			
			$field = new HtmlElement('div', 'class="formline"');
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$field->AddChild($buttons);
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddDropDown($name, $title, $options, $selected=null, $container=null)
		{
			$dropdown = new RTK_DropDown($name, $options, $selected);
			
			$field = new HtmlElement('div', 'class="formline"');
			$field->AddChild(new HtmlElement('label', 'for="'.$name.'"', $title));
			$field->AddChild($dropdown);
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddButton($name='submit', $title='Submit', $container=null)
		{
			$field = new HtmlElement('div', 'class="formline"');
			$field->AddChild(new RTK_Button($name, $title));
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddElement($htmlelement, $container=null)
		{
			$field = new HtmlElement('div', 'class="formline"');
			$field->AddChild($htmlelement);
			
			$this->AddToContainer($field, $container);
		}
	}
}
?>