<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a user form in HTML
	 **/
	class RTK_Form extends HtmlElement
	{
		/**
		 * A widget containing a user input form
		 * @param string $name The HTML #id and name of the element
		 * @param string $action The url that should handle the request (leave blank for current page)
		 * @param string $method POST or GET
		 * @param boolean $usetoken Includes a security token on all forms, pass false to opt out (not recommended)
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
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
		
		/**
		 * Add an RTK_TextView to the form
		 * @param string $text The text to display
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
		public function AddText($text, $container=null)
		{
			$textview = new RTK_Textview($text, false, null, 'formtext');
			$this->AddToContainer($textview, $container);
		}
		
		/**
		 * Add a hidden field to the form
		 * @param string $name The name of the hidden field
		 * @param string $value The predefined value in the hidden field
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
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
		
		/**
		 * Add a text input field to the form
		 * @param string $name The HTML name (and #id) of the input field
		 * @param string $title The text written next to the input field
		 * @param string $value The predefined value in the input field
		 * @param integer $size How many rows the input field should span
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
		public function AddTextField($name, $title, $value=null, $size=null, $container=null)
		{
			$args = new HtmlAttributes();
			$args->Add('name', $name);
			$args->Add('id', $name);
			
			$line = new HtmlElement('div', array('class' => 'formline'));
			$line->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$group = new HtmlElement('div', array('class' => 'formgroup'));
			
			if ($size == null || intval($size) <= 0) {
				$args->Add('type', 'text');
				if (Value::SetAndNotNull($value)) { $args->Add('value', $value); }
				$group->AddChild(new HtmlElement('input', $args));
			} else {
				$args->Add('rows', $size);
				$group->AddChild(new HtmlElement('textarea', $args, $value));
			}
			
			$line->AddChild($group);
			$this->AddToContainer($line, $container);
		}
		
		/**
		 * Add a password input field to the form
		 * @param string $name The HTML name (and #id) of the input field
		 * @param string $title The text written next to the input field
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
		public function AddPasswordField($name, $title, $container=null)
		{
			$args = new HtmlAttributes();
			$args->Add('type', 'password');
			$args->Add('name', $name);
			$args->Add('id', $name);
			
			$line = new HtmlElement('div', array('class' => 'formline'));
			$line->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$group = new HtmlElement('div', array('class' => 'formgroup'));
			$group->AddChild(new HtmlElement('input', $args));
			$line->AddChild($group);
			
			$this->AddToContainer($line, $container);
		}
		
		/**
		 * Add a file upload field to the form
		 * @param string $name The HTML name (and #id) of the upload field
		 * @param string $title The text written next to the upload field
		 * @param string $value The value sent if there us no file selected
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
		public function AddFileUpload($name, $title, $value='false', $container=null)
		{
			$args = new HtmlAttributes();
			$args->Add('class', 'filebox');
			$args->Add('type', 'file');
			$args->Add('name', $name);
			$args->Add('id', $name);
			$args->Add('value', $value);
			
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$group = new HtmlElement('div', array('class' => 'formgroup'));
			$group->AddChild(new HtmlElement('input', $args));
			$field->AddChild($group);
			
			$this->GetAttributes()->Add('enctype', 'multipart/form-data');
			$this->AddToContainer($field, $container);
		}
		
		/**
		 * Add a checkbox to the form
		 * @param string $name The HTML name (and #id) of the input field
		 * @param string $title The text written next to the input field
		 * @param boolean $checked Whether the checkbox is checked
		 * @param string $value The value sent if it is checked
		 * @param string $text (optional) a text to display next to the checkbox
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
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
			
			$group = new HtmlElement('div', array('class' => 'formgroup'));
			$group->AddChild(new HtmlElement('input', $args));
			if ($text != null) { $group->AddChild(new HtmlElement('span', EMPTYSTRING, $text)); }
			$field->AddChild($group);
			
			$this->AddToContainer($field, $container);
		}
		
		/**
		 * Add a row of radiobuttons to the form
		 * @param string $name The HTML name (and #id) of the input field
		 * @param string $title The text written next to the input field
		 * @param string[][] $options An array of options, each of which is an array of value and title
		 * @param string $selected The value of the selected radiobutton
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
		public function AddRadioButtons($name, $title, $options, $selected=null, $container=null)
		{
			$group = new HtmlElement('div', array('class' => 'formgroup'));
			
			$option_value = EMPTYSTRING;
			$option_title = EMPTYSTRING;
			foreach ($options as $option) {
				if (_array::IsLongerThan($option, 1)) {
					$option_value = $option[0];
					$option_title = $option[1];
				} else { $option_value = $option_title = $option; }
				
				$args = new HtmlAttributes();
				$args->Add('type', 'radio');
				$args->Add('class', 'radiobox');
				$args->Add('name', $name);
				$args->Add('id', $name);
				$args->Add('value', $option_value);
				if ($selected == $option_value) { $args->Add('checked', true); }
				
				$group->AddChild(new HtmlElement('input', $args));
				$group->AddChild(new HtmlElement('span', EMPTYSTRING, $option_title));
			}
			
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$field->AddChild($group);
			
			$this->AddToContainer($field, $container);
		}
		
		/**
		 * Add a dropdown selector to the form
		 * @param string $name The HTML name (and #id) of the input field
		 * @param string $title The text written next to the input field
		 * @param string[][] $options An array of options, each of which is an array of value and title
		 * @param string $selected The value of the selected item in the dropdown
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
		public function AddDropDown($name, $title, $options, $selected=null, $container=null)
		{
			$dropdown = new RTK_DropDown($name, $options, $selected);
			
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$field->AddChild(new HtmlElement('div', array('class' => 'formgroup'), EMPTYSTRING, $dropdown));
			
			$this->AddToContainer($field, $container);
		}
		
		/**
		 * Add a button to the form
		 * @param string $name The name/id of the button
		 * @param string $text The text written on the button
		 * @param string $title The text written next to the button
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
		public function AddButton($name='submit', $text='Submit', $title=EMPTYSTRING, $container=null)
		{
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$group = new HtmlElement('div', array('class' => 'formgroup'));
			$group->AddChild(new RTK_Button($name, $text));
			$field->AddChild($group);
			
			$this->AddToContainer($field, $container);
		}
		
		/**
		 * Add a custom HtmlElement into the form (not recommended)
		 * @param string $name The name/id of the element
		 * @param string $title The text written on the element
		 * @param HtmlElement $HtmlElement The element to add
		 * @param HtmlElement $container (optional) The "container" to add it to
		 **/
		public function AddElement($name, $title, $htmlelement, $container=null)
		{
			$field = new HtmlElement('div', array('class' => 'formline'));
			$field->AddChild(new HtmlElement('label', array('for' => $name), $title));
			$group = new HtmlElement('div', array('class' => 'formgroup'));
			$group->AddChild($htmlelement);
			$field->AddChild($group);
			
			$this->AddToContainer($field, $container);
		}
	}
}
?>