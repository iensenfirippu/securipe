<?php
if (defined('RTK') or exit(1))
{
	// Tags that must not be closed in any way
	//define("NONCLOSINGELEMENTS", "|!doctype|");
	// Tags that must NOT be closed by "/>"
	define("NONVOIDELEMENTS", "|ul|script|a|tr|td|div|textarea|article|");
	// Tags that MUST be closed by "/>"
	define("VOIDELEMENTS", "|area|base|br|col|command|embed|hr|img|input|keygen|link|meta|param|source|track|wbr|");
	// Tags which contents must not be altered (i.e. indented)
	define("PRESERVECONTENTS", "|textarea|");
	
	if (ONELINEOUTPUT === true) {
		define("OUTPUTNEWLINE",	EMPTYSTRING);
		define("OUTPUTINDENT",	EMPTYSTRING);
	} else {
		define("OUTPUTNEWLINE",	NEWLINE);
		define("OUTPUTINDENT",	INDENT);
	}

	class HtmlElement
	{
		protected $_indent = 0;
		protected $_oneline = 0;
		protected $_tag = EMPTYSTRING;
		protected $_endtag = EMPTYSTRING;
		protected $_attributes = null;
		protected $_content = EMPTYSTRING;
		protected $_children = array();
		protected $_containers = array();
		protected $_pointer = null;
		
		public function GetIndent()			{ return $this->_indent; }
		public function GetOneline()		{ return ($this->_oneline == true); }
		public function GetTag()			{ return $this->_tag; }
		public function GetAttributes()		{ return $this->_attributes; }
		public function GetContent()		{ return $this->_content; }
		public function GetChildren()		{ return $this->_children; }
		public function HasChildren()		{ return sizeof($this->_children) > 0; }
		
		public function SetTag($value)			{ if (is_string($value)) { $this->_tag = $value; } }
		public function SetAttributes($value)	{ if (is_string($value)) { $this->_attributes = $value; } }
		public function SetContent($value)		{ if (is_string($value)) { _string::EnforceProperLineEndings($this->_content = $value); } }
		public function SetOneline()			{ $this->_oneline = 1; }
		
		public function __construct($tag=EMPTYSTRING, $attributes=EMPTYSTRING, $content=EMPTYSTRING, $child=null)
		{
			if ($tag == 'comment' || $tag == '!--') {
				$this->_tag = '!--';
				$this->_endtag = '--';
			} else {
				$this->_tag = $tag;
			}
			
			if (is_a($attributes, 'HtmlAttributes')) {
				$this->_attributes = $attributes;
			} elseif (is_array($attributes)) {
				$this->_attributes = new HtmlAttributes($attributes);
			} else {
				$this->_attributes = new HtmlAttributes();
			}
			
			$this->_content = _string::EnforceProperLineEndings($content);
			if ($child !== null)
			{
				if (!is_array($child)) { $this->AddChild($child); }
				else { foreach ($child as $c) { $this->AddChild($c); } }
			}
		}
		
		public function SetPointer($containerindex)
		{
			if (isset($this->_containers[$containerindex])) {
				$this->_pointer = $this->_containers[$containerindex];
			}
		}
		
		public function AddAttributes($attributes, $override=true)
		{
			foreach ($attributes as $key => $val) {
				$this->_attributes->Add($key, $val);
			}
		}
		
		public function AddAttribute($key, $value, $override=true)
		{
			$this->_attributes->Add($key, $value, $override);
		}
		
		public function RemoveAttribute($key)
		{
			$this->_attributes->Remove($key);
		}
		
		public function AddContainer($HtmlElement, $name)
		{
			$this->AddChild($HtmlElement);
			while ($HtmlElement->HasChildren()) { $HtmlElement = end($HtmlElement->_children); }
			$this->_pointer = $this->_containers[$name] = $HtmlElement;
		}
		
		protected function AddToContainer($HtmlElement, $container=null)
		{
			if ($container != null && Value::SetAndNotNull($this->_containers[$container])) {
				$this->_containers[$container]->AddChild($HtmlElement);
			} elseif ($this->_pointer != null) {
				$this->_pointer->AddChild($HtmlElement);
			} else {
				$this->AddChild($HtmlElement);
			}
		}
		
		public function GetFirstChild() {
			$result = false;
			if ($this->HasChildren()) {
				$result = $this->_children[0];
			}
			return $result;
		}
		
		public function GetNthChild($n) {
			$result = false;
			if ($n > 0 && count($this->_children) > $n) {
				$result = $this->_children[$n-1];
			}
			return $result;
		}
		
		public function GetLastChild() {
			$result = false;
			if ($this->HasChildren()) {
				$result = end($this->_children);
			}
			return $result;
		}
		
		public function AddChild($child, $index=null)
		{
			$child->_indent = $this->_indent + 1;
			$child->UpdateChildren();
			
			if ($index !== null && $index >= 0 && $index < sizeof($this->_children)) {
				array_splice($this->_children, $index, 0, array($child));
			} else {
				array_push($this->_children, $child);
			}
		}
		
		private function UpdateChildren()
		{
			foreach ($this->_children as $c) {
				if ($c instanceof HtmlElement) {
					$c->_indent = $this->_indent + 1;
					if ($this->_tag == EMPTYSTRING) { $c->_indent = $this->_indent; }
					if ($this->_oneline > 0) { $c->_oneline = $this->_oneline + 1; }
					$c->Updatechildren();
				}
			}
		}
		
		public function __tostring()
		{
			$newline = false;
			return $this->ToString($newline);
		}
		
		public function ToString(&$newline)
		{
			$return = EMPTYSTRING;
			if ($this->_tag != EMPTYSTRING) {
				if ($newline) { $return .= OUTPUTNEWLINE; } else { $newline = true; }
				if ($this->_oneline <= 1) { $return .= str_repeat(OUTPUTINDENT, $this->_indent); }
				$return .= '<'.$this->_tag;
				if (is_a($this->_attributes, 'HtmlAttributes')) { $return .= $this->_attributes; }
				if ($this->_endtag != EMPTYSTRING) { $return .= $this->_endtag.">"; }
				else {
					if (sizeof($this->_children) == 0) {
						if ($this->_content != EMPTYSTRING) {
							if (strstr($this->_content, NEWLINE) && !strstr(PRESERVECONTENTS, $this->_tag)) {
								$return .= '>';
								foreach (explode(NEWLINE, $this->_content) as $line) {
									if ($line == EMPTYSTRING || $line[strlen($line) -1] != '>') { $line .= '<br />'; }
									$return .= OUTPUTNEWLINE.str_repeat(OUTPUTINDENT, $this->_indent + 1).$line;
								}
								$return .= OUTPUTNEWLINE.str_repeat(OUTPUTINDENT, $this->_indent).'</'.$this->_tag.'>';
							}
							else { $return .= '>'.$this->_content.'</'.$this->_tag.'>'; }
						}
						//elseif (strstr(NONCLOSINGELEMENTS, '|'.$this->_tag.'|')) { $return .= '>'; }
						elseif (strstr(VOIDELEMENTS, '|'.$this->_tag.'|')) { $return .= ' />'; }
						elseif (strstr(NONVOIDELEMENTS, '|'.$this->_tag.'|') || $this->_oneline) { $return .= '></'.$this->_tag.'>'; }
						else { $return .= ' />'; }
					} else {
						if ($this->_oneline) {
							$return .= '>';
							foreach ($this->_children as $c) { $return .= $c; }
							$return .= '</'.$this->_tag.'>';
						} else {
							$return .= '>'.OUTPUTNEWLINE;
							if ($this->_content != EMPTYSTRING) { $return .= str_repeat(OUTPUTINDENT, $this->_indent + 1).str_replace("\n", '<br />'.OUTPUTNEWLINE.str_repeat(OUTPUTINDENT, $this->_indent), $this->_content).OUTPUTNEWLINE; }
							if (sizeof($this->_children) > 0)
							{
								$newline = false;
								foreach ($this->_children as $c) { $return .= $c->ToString($newline); }
							}
							$return .= OUTPUTNEWLINE.str_repeat(OUTPUTINDENT, $this->_indent).'</'.$this->_tag.'>';
						}
					}
				}
			} else {
				$sizeofchildren = sizeof($this->_children);	
				if ($sizeofchildren > 0) {
					$this->UpdateChildren();
					
					// INFO: commenting this line seems to have fixed a double-linebreak issue, but may now cause a no-linebreak in some cases... stay tuned...
					//if ($newline) { $return .= OUTPUTNEWLINE; }
					
					for ($i = 0; $i < $sizeofchildren; $i++) { $return .= $this->_children[$i]->ToString($newline); }
				}
			}
			return $return;
		}
	}
}
?>
