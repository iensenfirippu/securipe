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
			if ($args == null || !is_array($args)) { $args = array(); }
			$args['src'] = $imgurl;
			$args['alt'] = $alttext;
			
			parent::__construct();
			$this->AddChild('img', HtmlElement::ArgsToString($args));
		}
		
		public function AddLink($link, $args=null) {
			$child = $this->GetFirstChild();
			if ($child != false && $child->GetType() == 'img') {
				$img = $child;
				$child = new RTK_Link($link, EMPTYSTRING, $args, $img);
				$child->SetOneLine(true);
			}
		}
		
		public function RemoveLink() {
			$child = $this->GetFirstChild();
			if ($child != false && $child->GetType() == 'a') {
				$grandchild = $child->GetFirstChild();
				if ($child != false && $child->GetType() == 'img') {
					$child = $grandchild;
					$child->SetOneLine(false);
				}
			}
		}
	}
}
?>