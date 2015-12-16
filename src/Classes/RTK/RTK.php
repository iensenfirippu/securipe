<?php
/*
 * [R]TK [T]ool [K]it
 *  - "make PHP, not HTML..."
 */

define("RTK", true);
include_once("Classes/RTK/HtmlElement.php");
foreach (glob("Classes/RTK/Widgets/*.php") as $classfile) { include_once($classfile); }

class RTK
{
	protected $_stylesheets = array();
	protected $_javascripts = array();
	protected $_breadcrumbs = null;
	protected $_elements = array();
	protected $_references = array();
	protected $_pointer = null;
	
	public function __construct($title, $doctype='html')
	{
		$tmp = new HtmlElement('!doctype', $doctype);
		array_push($this->_elements, $tmp);
		
		$this->AddElement(new HtmlElement('html'), null, 'HTML');
		$this->AddElement(new HtmlElement('head'), 'HTML', 'HEAD');
		$this->AddElement(new HtmlElement('body'), 'HTML', 'BODY');
		
		$this->AddElement(new HtmlElement('title', null, $title), 'HEAD', 'TITLE');
		
		$this->_pointer = $this->_references['BODY'];
	}
	
	public function GetBreadcrumbs()			{ return $this->_breadcrumbs; }
	
	public function AddStylesheet($filename, $args=null)	{ $this->_stylesheets[$filename] = new HtmlElement('link', 'rel="stylesheet" type="text/css" href="'.$filename.'"'.$args); }
	public function AddJavascript($filename, $args=null)	{ $this->_javascripts[$filename] = new HtmlElement('script', 'src="'.$filename.'"'.$args); }
	
	public function SetPointer($name)			{ $this->_pointer = $this->_references[$name]; }
	
	public function AddElement($HtmlElement, $inelement=null, $registeras=null, $index=null)
	{
		if ($HtmlElement != null && is_a($HtmlElement, 'HtmlElement'))
		{
			if ($inelement != null)
			{
				if (isset($this->_references[$inelement]) && is_a($this->_references[$inelement], 'HtmlElement'))
				{
					$this->_references[$inelement]->AddChild($HtmlElement, $index);
				}
				else
				{
					// TODO: Add error reporting at some point
				}
			}
			elseif ($this->_pointer != null)
			{
				$this->_pointer->AddChild($HtmlElement);
			}
			else
			{
				array_push($this->_elements, $HtmlElement);
			}
			
			if ($registeras != null)
			{
				if (!isset($this->_references[$registeras]))
				{
					$this->_pointer = $this->_references[$registeras] = $HtmlElement;
				}
				else
				{
					// TODO: Add error reporting at some point
				}
			}
		}
	}
	
	public function GetReference($name)
	{
		if (isset($this->_references[$name]) && is_a($this->_references[$name], 'HtmlElement'))
		{
			return $this->_references[$name];
		}
		else
		{
			return false;
		}
	}
	
	public function __tostring()
	{
		$html = EMPTYSTRING;
		$headprocessed = false;
		
		// To make sure that stylesheets are always loaded in the same order (important for some rules), sort the stylesheet collection
		// TODO: This wont always be the preferable solution so a "weight" or "importance" system might need to be implemented
		sort($this->_stylesheets);
		
		foreach ($this->_stylesheets as $stylesheet) { $this->_references['HEAD']->AddChild($stylesheet); }
		foreach ($this->_javascripts as $javascript) { $this->_references['HEAD']->AddChild($javascript); }
		$this->_stylesheets = array();
		$this->_javascripts = array();
		
		$newline = false;
		foreach ($this->_elements as $HtmlElement)
		{
			if ($newline) { $html .= OUTPUTNEWLINE; } else { $newline = true; }
			$html .= $HtmlElement;
		}
		
		return $html;
	}
}
?>