<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a user form in HTML
	 **/
	class RTK_Form extends HtmlElement
	{
		public function __construct($name=EMPTYSTRING, $action=EMPTYSTRING, $method='POST', $usetoken=true, $args=null)
		{
			HtmlAttributes::Assure($args);
			$args->Add('name', $name);
			$args->Add('id', $name);
			$args->Add('action', $action);
			$args->Add('method', $method);
			
			parent::__construct('form', $args);
			if ($usetoken) {
				$this->AddHiddenField('securitytoken', Site::CreateSecurityToken());
			}
			$this->_containers = array();
		}
		
		public function AddText($text, $container=null)
		{
			$field = new HtmlElement('div', array('class' => 'formtext'), $text);
			$this->AddToContainer($field, $container);
		}
		
		public function AddHiddenField($name, $value=null, $container=null)
		{
			$args = new HtmlAttributes();
			$args->Add('type', 'hidden');
			$args->Add('name', $name);
			$args->Add('id', $name);
			if (Value::SetAndNotNull($value)) $args->Add('value', $value);
			
			$field = new HtmlElement('input', $args);
			$this->AddToContainer($field, $container);
		}
		
		public function AddTextField($name, $title, $value=null, $size=null, $container=null)
		{
			$args = new HtmlAttributes();
			$args->Add('name', $name);
			$args->Add('id', $name);
			
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			
			if ($size == null || intval($size) <= 0) {
				$args->Add('type', 'text');
				if (Value::SetAndNotNull($value)) { $args->Add('value', $value); }
				$field->AddChild(new HtmlElement('input', $args));
			} else {
				$args->Add('rows', $size);
				$field->AddChild(new HtmlElement('textarea', $args, $value));
			}
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddPasswordField($name, $title, $container=null)
		{
			$args = new HtmlAttributes();
			$args->Add('type', 'password');
			$args->Add('name', $name);
			$args->Add('id', $name);
			
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			
			$field->AddChild(new HtmlElement('input', $args));
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddCheckBox($name, $title, $checked=false, $value='true', $text=null, $container=null)
		{
			$args = new HtmlAttributes();
			$args->Add('class', 'checkbox');
			$args->Add('type', 'checkbox');
			$args->Add('name', $name);
			$args->Add('id', $name);
			$args->Add('value', $value);
			$args->Add('checked', $checked);
			
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			
			$field->AddChild(new HtmlElement('input', $args));
			
			if ($text != null) { $field->AddChild(new HtmlElement('span', EMPTYSTRING, $text)); }
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddRadioButtons($name, $title, $options, $selected=null, $container=null)
		{
			$buttons = new HtmlElement('div', array('class' => 'radiobuttons'));
			
			$option_value = EMPTYSTRING;
			$option_title = EMPTYSTRING;
			foreach ($options as $option) {
				if (_array::IsLongerThan($option, 1)) {
					$option_value = $option[0];
					$option_title = $option[1];
				} else { $option_value = $option_title = $option; }
				
				$args = new HtmlAttributes();
				$args->Add('type', 'radio');
				$args->Add('name', $name);
				$args->Add('id', $name);
				$args->Add('value', $option_value);
				if ($selected == $option_value) { $args->Add('checked', true); }
				
				$buttons->AddChild(new HtmlElement('input', $args, $option_title));
			}
			
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$field->AddChild($buttons);
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddDropDown($name, $title, $options, $selected=null, $container=null)
		{
			$dropdown = new RTK_DropDown($name, $options, $selected);
			
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$field->AddChild($dropdown);
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddButton($name='submit', $title='Submit', $container=null)
		{
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new RTK_Button($name, $title));
			
			$this->AddToContainer($field, $container);
		}
		
		public function AddElement($htmlelement, $container=null)
		{
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild($htmlelement);
			
			$this->AddToContainer($field, $container);
		}
	}
}
?>