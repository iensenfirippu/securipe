<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of paginition in HTML
	 **/
	class RTK_Pagination extends HtmlElement
	{
		/**
		 * A widget containing the links to different pages for a common URL
		 * @param string $baseurl The base part of the URL that all links in the paginition shares
		 * @param integer $amount The amount of items to divide into pages
		 * @param integer $perpage The amount of items per page
		 * @param HtmlAttributes $args Allows custom html tag arguments to be specified (not recommended)
		 **/
		public function __construct($baseurl, $amount, $perpage, $page, $args=null)
		{
			HtmlAttributes::Assure($args);
			$args->Add('class', 'pagination', false);
			
			if ($amount > $perpage || PAGINATIONSHOWEMPTY)
			{
				parent::__construct('ul', $args);
				$firstpage = 1;
				$lastpage = ceil($amount / $perpage);
				$lowerlimit = ($page - PAGINATIONLINKS);
				$upperlimit = ($page + PAGINATIONLINKS);
				$nolink = new HtmlElement('li', EMPTYSTRING, '&nbsp;');
				
				// First, previous
				if ($page > $firstpage)
				{
					$this->AddChild(
						new HtmlElement('li', EMPTYSTRING, EMPTYSTRING,
							new HtmlElement('a', array('href' => $baseurl.$firstpage.SINGLESLASH), PAGINATIONFIRST)
						)
					);
					$this->AddChild(
						new HtmlElement('li', EMPTYSTRING, EMPTYSTRING,
							new HtmlElement('a', array('href' => $baseurl.($page - 1).SINGLESLASH), PAGINATIONPREV)
						)
					);
				}
				else
				{
					$this->AddChild($nolink);
					$this->AddChild($nolink);
				}
				
				// Available page numbers
				for ($i = $lowerlimit; $i <= $upperlimit; $i++)
				{
					
					if ($i == $page) { $this->AddChild(new HtmlElement('li', array('class' => 'current'), $page)); }
					elseif ($i >= $firstpage && $i <= $lastpage)
					{
						$this->AddChild(
							new HtmlElement('li', EMPTYSTRING, EMPTYSTRING,
								new HtmlElement('a', array('href' => $baseurl.$i.SINGLESLASH), $i)
							)
						);
					}
					else { $this->AddChild($nolink); }
				}
				
				// Next Page, Last Page
				if ($page < $lastpage)
				{
					$this->AddChild(
						new HtmlElement('li', EMPTYSTRING, EMPTYSTRING,
							new HtmlElement('a', array('href' => $baseurl.($page + 1).SINGLESLASH), PAGINATIONNEXT)
						)
					);
					$this->AddChild(
						new HtmlElement('li', EMPTYSTRING, EMPTYSTRING,
							new HtmlElement('a', array('href' => $baseurl.$lastpage.SINGLESLASH), PAGINATIONLAST)
						)
					);
				}
				else
				{
					$this->AddChild($nolink);
					$this->AddChild($nolink);
				}
			}
			else
			{
				parent::__construct();
			}
		}
		
		public function __tostring()
		{
			return parent::__tostring();
		}
	}
}
?>