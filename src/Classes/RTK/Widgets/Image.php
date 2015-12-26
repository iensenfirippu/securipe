<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of an image in HTML
	 **/
	class RTK_Image extends HtmlElement
	{
		public function __construct($imgurl=EMPTYSTRING, $alttext=EMPTYSTRING, $args=null)
		{
			HtmlAttributes::Assure($args);
			$args->Add('src', $imgurl, true);
			$args->Add('alt', $alttext, true);
			
			parent::__construct();
			$this->AddChild(new HtmlElement('img', $args));
		}
		
		public function AddLink($link, $args=null) {
			$child = $this->GetFirstChild();
			if ($child != false && $child->GetTag() == 'img') {
				$img = $child;
				$child = new RTK_Link($link, EMPTYSTRING, $args, false);
				$child->AddChild($img);
				$child->SetOneLine(true);
			}
		}
		
		public function RemoveLink() {
			$child = $this->GetFirstChild();
			if ($child != false && $child->GetTag() == 'a') {
				$grandchild = $child->GetFirstChild();
				if ($child != false && $child->GetTag() == 'img') {
					$child = $grandchild;
					$child->SetOneLine(false);
				}
			}
		}
	}
}
?>