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
		public function __construct($recipe)
		{
			$GLOBALS['RTK']->AddJavascript('/commentview.js');
			
			parent::__construct('CommentView');
			if (is_a($recipe, 'Recipe')) {
				$this->AddChild(new RTK_Header('Comments'));
				$comments = Comment::LoadComments('R='.$recipe->GetId());
				$box = null;
				
				if (sizeof($comments) > 0) {
					$box = new RTK_Box('Comments');
					$this->TraverseComment($box, $comments);
				} else {
					if (Login::IsLoggedIn()) { $message = 'No comments yet, be the first to comment on this recipe!'; }
					else { $message = 'No comments yet, log in and be the first to comment on this recipe!'; }
					$box = new RTK_Textview($message, false, null, 'commentnone');
				}
				
				if (Site::HasHttps() && Login::IsLoggedIn()) {
					$form = new RTK_Form('CommentForm');
					$form->AddChild($box);
					$inputbox = new RTK_Box('NewComment');
					$inputbox->AddChild(new HtmlElement('a', array('href' => '#', 'onclick' => 'SelectComment(\'\')'), 'New comment'));
					$inputbox->AddChild(new HtmlElement('input', array('name' => 'CommentSelect', 'id' => 'CommentSelect','type' => 'hidden')));
					$inputbox->AddChild(new HtmlElement('input', array('name' => 'CommentInput', 'id' => 'CommentInput','type' => 'text', 'autocomplete' => 'off')));
					$inputbox->AddChild(new RTK_Button('submit', 'Send'));
					$form->AddChild($inputbox);
					$this->AddChild($form);
				} else {
					$this->AddChild($box);
				}
			}
		}
		
		private function TraverseComment(&$box, $comments)
		{
			if (sizeof($comments) > 0) {
				foreach ($comments as $comment) {
					if (is_a($comment, 'Comment')) {
						$args = null;
						if (Login::IsLoggedIn()) { $args = array('onclick' => 'SelectComment('.$comment->GetId().')'); }
						$childbox = new RTK_Box($comment->GetId(), 'comment');
						$infobox = new RTK_Box($comment->GetId(), 'commentinfo', $args);
						$infobox->AddChild(new RTK_Textview($comment->GetUser()->GetUserName().':', true, null, 'commentposter'));
						$infobox->AddChild(new RTK_Textview($comment->GetContents(), true, null, 'commentmessage'));
						$infobox->AddChild(new RTK_Textview('Posted '. $comment->GetTime(), true, null, 'commenttime'));
						$childbox->AddChild($infobox);
						if (!empty($comment->GetComments())) { $this->TraverseComment($childbox, $comment->GetComments()); }
						$box->AddChild($childbox);
					}
				}
			}
		}
	}
}
?>