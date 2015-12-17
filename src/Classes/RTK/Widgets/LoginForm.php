<?php
if (defined('RTK') or exit(1))
{
	// Remove?
	
	/**
	 * Contains the definition of a login form in HTML
	 **/
	class RTK_LoginForm extends RTK_Box
	{
		public function __construct($name=EMPTYSTRING, $action=EMPTYSTRING, $method='POST')
		{
			parent::__construct("loginbox");
			
			if (Login::GetStatus()->IsLoggedIn()) {
				// Logged in
				$this->AddChild(new RTK_Textview('You are logged in as: '.Login::GetStatus()->GetUsername()));
				$this->AddChild(new RTK_Link('https://'.$_SERVER['HTTP_HOST'].'?action=logout', 'click here for log out'));
			} elseif (Site::HasHttps()) {
				// Not logged in, running secure
				$form = new RTK_Form($name, $action, $method);
				$form->AddTextField("loginname", "Username:");
				$form->AddPasswordField("loginpass", "Password:");
				$form->AddButton("submit", "log in");
				$this->AddChild($form);
			} else {
				// Not logged in, not running secure
				$this->AddChild(new RTK_Textview('You are not running secure and therefore cannot be allowed to log in.'));
				$this->AddChild(new RTK_Link('https://'.$_SERVER['HTTP_HOST'], 'click here for encrypted login'));
			}
		}
	}
}
?>