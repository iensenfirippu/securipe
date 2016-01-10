<?php
/*
 * [R]TK [T]ool [K]it
 *  - "make PHP, not HTML..."
 *
 * Toolkit to make manual HTML creation obsolete.
 * It automatically renders nested PHP objects into 100% valid HTML
 *
 * The main class "RTK" acts like an HTML document,
 * or like a window/canvas from other desktop toolkits
 * (like: winforms, java swing, gtk, etc.)
 */

define("RTK", true);

// Include general classes
include_once("Classes/RTK/HtmlElement.php");
include_once("Classes/RTK/HtmlAttributes.php");

// Include widget classes
include_once("Classes/RTK/Widgets/Box.php");
include_once("Classes/RTK/Widgets/Button.php");
include_once("Classes/RTK/Widgets/CommentView.php");
include_once("Classes/RTK/Widgets/Dropdown.php");
include_once("Classes/RTK/Widgets/Form.php");
include_once("Classes/RTK/Widgets/Header.php");
include_once("Classes/RTK/Widgets/Image.php");
include_once("Classes/RTK/Widgets/Link.php");
include_once("Classes/RTK/Widgets/List.php");
include_once("Classes/RTK/Widgets/Listview.php");
include_once("Classes/RTK/Widgets/Menu.php");
include_once("Classes/RTK/Widgets/Pagination.php");
include_once("Classes/RTK/Widgets/Textview.php");

class RTK
{
	protected $_doctype = EMPTYSTRING;
	protected $_stylesheets = array();
	protected $_javascripts = array();
	protected $_popups = array();
	protected $_elements = array();
	protected $_references = array();
	protected $_pointer = null;
	
	/**
	 * Class containing an abstracted HTML document
	 * @param string $title The title of the document (The <TITLE> to put in <HEAD>)
	 * @param string $doctype The doctype of the document (not implemented, only "html" will generate valid html)
	 */
	public function __construct($title, $doctype='html')
	{
		$this->_doctype = $doctype;
		
		$this->AddElement(new HtmlElement('html'), null, 'HTML');
		$this->AddElement(new HtmlElement('head'), 'HTML', 'HEAD');
		$this->AddElement(new HtmlElement('body'), 'HTML', 'BODY');
		
		$this->AddElement(new HtmlElement('title', null, $title), 'HEAD', 'TITLE');
		
		$this->_pointer = $this->_references['BODY'];
	}
	
	/**
	 * Adds a stylesheet to the HTML document
	 * @param string $filename The name of the file to add
	 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
	 */
	public function AddStylesheet($filename, $args=null)
	{
		HtmlAttributes::Assure($args);
		$args->Add('rel', 'stylesheet');
		$args->Add('type', 'text/css');
		$args->Add('href', $filename);
		
		$this->_stylesheets[$filename] = new HtmlElement('link', $args);
	}
	
	/**
	 * Adds a javascript to the HTML document
	 * @param string $filename The name of the file to add
	 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
	 */
	public function AddJavascript($filename, $args=null)
	{
		HtmlAttributes::Assure($args);
		$args->Add('src', $filename);
		
		$this->_javascripts[$filename] = new HtmlElement('script', $args);
	}
	
	/**
	 * Adds a Popup to the HTML document
	 * @param HtmlElement $element The element to display
	 **/
	public function AddPopup($element)
	{
		$id = 'Popup-'.(sizeof($this->_popups)+1);
		$popup = new RTK_Box($id, 'popup', array('onclick' => 'ClosePopup(\''.$id.'\')'));
		if (is_a($element, 'HtmlElement')) { $popup->AddChild($element); }
		elseif (is_string($element)) { $popup->SetContent($element); }
		else { $popup = null; }
		
		if ($popup != null) {
			$close = new RTK_Image('Close.png', 'X', array('class' => 'close'));
			$popup->AddChild($close, 0);
			$this->_popups[] = $popup;
		}
	}
	
	/**
	 * Sets the "pointer" to a "reference"d name
	 * @param string $name The name of the "reference"
	 */
	public function SetPointer($name) { $this->_pointer = $this->_references[$name]; }
	
	/**
	 * Adds an HtmlElement to the document
	 * @param HtmlElement $HtmlElement The element (or "widget") to add
	 * @param string $inelement (optional) The name of a "reference"d element, in which to add the element to 
	 * @param string $registeras (optional) The name to "reference" the added element as
	 * @param integer $index (optional) A forced index of the new element, to assure a specific placement in the document (doesn't override another element but pushes it instead)
	 */
	public function AddElement($HtmlElement, $inelement=null, $registeras=null, $index=null)
	{
		if ($HtmlElement != null && is_a($HtmlElement, 'HtmlElement')) {
			if ($inelement != null) {
				if (isset($this->_references[$inelement]) && is_a($this->_references[$inelement], 'HtmlElement')) {
					$this->_references[$inelement]->AddChild($HtmlElement, $index);
				} else {
					// TODO: Add error reporting at some point
				}
			} elseif ($this->_pointer != null) {
				$this->_pointer->AddChild($HtmlElement);
			} else {
				array_push($this->_elements, $HtmlElement);
			}
			
			if ($registeras != null) {
				if (!isset($this->_references[$registeras])) {
					$this->_pointer = $this->_references[$registeras] = $HtmlElement;
				} else {
					// TODO: Add error reporting at some point
				}
			}
		}
	}
	
	/**
	 * Gets the HtmlElement that was "reference"d as the specified name
	 * @param string $name The name of the "reference" to get
	 * @return var Returns the specified "reference", or false if it doesn't exist
	 */
	public function GetReference($name)
	{
		if (isset($this->_references[$name]) && is_a($this->_references[$name], 'HtmlElement')) {
			return $this->_references[$name];
		} else {
			return false;
		}
	}
	
	public function __tostring()
	{
		$html = '<!doctype '.$this->_doctype.'>'.OUTPUTNEWLINE;
		$headprocessed = false;
		
		// To make sure that stylesheets are always loaded in the same order (important for some rules), sort the stylesheet collection
		// TODO: This wont always be the preferable solution so a "weight" or "importance" system might need to be implemented
		sort($this->_stylesheets);
		
		if (file_exists('Images/favicon.png')) {
			$this->_references['HEAD']->AddChild(
				new HtmlElement('link', array('rel'=>'icon', 'type'=>'image/png', 'href'=>'http://'.BASEURL.'favicon.png'))
			);
		}
		
		foreach ($this->_stylesheets as $stylesheet) { $this->_references['HEAD']->AddChild($stylesheet); }
		foreach ($this->_javascripts as $javascript) { $this->_references['HEAD']->AddChild($javascript); }
		$this->_stylesheets = array();
		$this->_javascripts = array();
		
		if (sizeof($this->_popups) > 0) {
			$popups = new HtmlElement('div', array('id' => 'Popups'));
			$popups->AddChild(new HtmlElement('script', array('language' => 'javascript'), 'function ClosePopup(divid) { var popups = document.getElementById(\'Popups\'); if (popups.children.length > 2) { var popup = document.getElementById(divid); popup.parentNode.removeChild(popup); } else { popups.parentNode.removeChild(popups); } }'));
			foreach ($this->_popups as $popup) { $popups->AddChild($popup); }
			$this->_references['BODY']->AddChild($popups, 0);
		}
		
		$newline = false;
		foreach ($this->_elements as $HtmlElement) {
			if ($newline) { $html .= OUTPUTNEWLINE; } else { $newline = true; }
			$html .= $HtmlElement;
		}
		
		return $html;
	}
}
?>