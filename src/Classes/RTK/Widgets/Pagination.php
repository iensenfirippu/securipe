<?php
if (defined('RTK') or exit(1))
{
	/**
	 * Contains the definition of paginition in HTML
	 **/
	class RTK_Pagination extends HtmlElement
	{
		/**
		 * @param baseurl, the base part of the URL that all links in the paginition shares
		 * @param amount, the amount of items to divide into pages
		 * @param perpage, the amount of items per page
		 * @param page, the currently selected page
		 **/
		public function __construct($baseurl, $amount, $perpage, $page)
		{
			if ($amount > $perpage || PAGINATIONSHOWEMPTY)
			{
				parent::__construct('ul', 'class="pagination"');
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
							new HtmlElement('a', 'href="'.$baseurl.$firstpage.'/"', PAGINATIONFIRST)
						)
					);
					$this->AddChild(
						new HtmlElement('li', EMPTYSTRING, EMPTYSTRING,
							new HtmlElement('a', 'href="'.$baseurl.($page - 1).'/"', PAGINATIONPREV)
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
					
					if ($i == $page) { $this->AddChild(new HtmlElement('li', 'class="current"', $page)); }
					elseif ($i >= $firstpage && $i <= $lastpage)
					{
						$this->AddChild(
							new HtmlElement('li', EMPTYSTRING, EMPTYSTRING,
								new HtmlElement('a', 'href="'.$baseurl.$i.'/"', $i)
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
							new HtmlElement('a', 'href="'.$baseurl.($page + 1).'/"', PAGINATIONNEXT)
						)
					);
					$this->AddChild(
						new HtmlElement('li', EMPTYSTRING, EMPTYSTRING,
							new HtmlElement('a', 'href="'.$baseurl.$lastpage.'/"', PAGINATIONLAST)
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