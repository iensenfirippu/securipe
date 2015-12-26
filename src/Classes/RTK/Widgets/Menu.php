<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a menu in HTML
	 **/
	class RTK_Menu extends RTK_List
	{
		public function __construct($id, $class, $links, $titles, $selected=null, $args=null)
		{
			HtmlAttributes::Assure($args);
			$args->Add('id', $id, true);
			$args->Add('class', $class, true);
			
			$items = array();
			if (sizeof($links) == sizeof($titles)) {
				for ($i=0; $i<sizeof($links); $i++) {
					$linkargs = null;
					$forcehttps = false;
					if (_string::StartsWith($titles[$i], '_')) {
						$titles[$i] = _string::RemovePrefix($titles[$i], '_');
						$forcehttps = true;
					}
					if ($selected != null && $selected == $titles[$i]) { $linkargs = array('selected' => true); }
					$items[] = new RTK_Link($links[$i], $titles[$i], $forcehttps, $linkargs);
				}
			}
			parent::__construct($items, $args);
		}
		
		public function AddMenuItem($link, $title, $forcehttps=false)
		{
			$this->AddChild(new RTK_Link($links[$i], $titles[$i], $forcehttps));
		}
		
		public function SetSelected($idortitle) {
			$children = $this->GetChildren();
			if (is_integer($idortitle) && $idortitle < sizeof($children)) {
				$children[$idortitle]->GetAttributes->Add('selected', true, true);
			} elseif (is_string($idortitle)) {
				foreach ($children as $child) {
					if ($child->GetAttributes()->KeyHasValue('title', $idortitle)) {
						$child->GetAttributes()->Add('selected', true, true);
					}
				}
			}
		}
	}
}	
?>