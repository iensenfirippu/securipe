<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of a text in HTML
	 **/
	class RTK_CommentView extends RTK_Box
	{
		/**
		 * A widget that lists all comments for a given recipe
		 * @param Recipe $recipe A recipe object
		 **/
		public function __construct($id)
		{
			$GLOBALS['RTK']->AddJavascript('/commentview.js');
			
			parent::__construct('CommentView');
			//if (is_a($recipe, 'Recipe')) {
			
			$this->AddChild(new RTK_Header('Comments'));
			$form = new RTK_Form('CommentForm');
			$comments = Comment::LoadComments('R='.$id);
			$box = new RTK_Box(null, 'comments');
			$this->TraverseComment($box, $comments);
			$form->AddChild($box);
			$form->AddChild(new HtmlElement('input', array('name' => 'commentmessage', 'id' => 'commentmessage','type' => 'text')));
			$form->AddChild(new RTK_Box(null, 'clearfix'));
			$this->AddChild($form);
			
			//} else {
			//}
		}
		
		private function TraverseComment(&$box, $comments)
		{
			foreach ($comments as $comment) {
				if (is_a($comment, 'Comment')) {
					$childbox = new RTK_Box(null, 'comment');
					$childbox->AddChild(new RTK_Textview($comment->GetContents(), false, null, 'commentmessage'));
					if (!empty($comment->GetComments())) { $this->TraverseComment($childbox, $comment->GetComments()); }
					$box->AddChild($childbox);
				}
				else { vdd($comment); }
			}
		}
	}
}
?>