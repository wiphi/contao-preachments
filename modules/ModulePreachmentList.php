<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   PhilippWinkel
 * @author    Philipp Winkel
 * @license   GNU
 * @copyright &#40;c&#41; Philipp Winkel 2017
 */


/**
 * Namespace
 */
namespace PhilippWinkel;


/**
 * Class ModulePreachmentList
 *
 * @copyright  &#40;c&#41; Philipp Winkel 2017
 * @author     Philipp Winkel
 * @package    Devtools
 */
class ModulePreachmentList extends \Preachments
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_preachmentlist';


	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			/** @var \BackendTemplate|object $objTemplate */
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['preachmentlist'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}		

		return parent::generate();
	}

	/**
	 * Generate the module
	 */
	protected function compile()
	{
		global $objPage;

		$strPreachments = '';
		$arrCriteria = array(
			'order' => 'date DESC'			
		);
		if ($this->numberOfItems > 0)
		{
			$arrCriteria = array_merge($arrCriteria, array(
				'limit' => $this->numberOfItems
			));
		}

		$arrPrechments = $this->getAllPreachments($arrCriteria);

		$offset = 0;
		$total = count($arrPrechments);
		$limit = $total;


		// Pagination
		if ($this->perPage > 0)
		{
			$id = 'page_e' . $this->id;
			$page = (\Input::get($id) !== null) ? \Input::get($id) : 1;

			// Do not index or cache the page if the page number is outside the range
			if ($page < 1 || $page > max(ceil($total/$this->perPage), 1))
			{
				/** @var \PageError404 $objHandler */
				$objHandler = new $GLOBALS['TL_PTY']['error_404']();
				$objHandler->generate($objPage->id);
			}

			$offset = ($page - 1) * $this->perPage;
			$limit = min($this->perPage + $offset, $total);

			$objPagination = new \Pagination($total, $this->perPage, \Config::get('maxPaginationLinks'), $id);
			$this->Template->pagination = $objPagination->generate("\n  ");
		}	

		$intPreachmentCount = 0;
		$strMonth = '';	
		$strDay = '';	

		for ($iPreachment = $offset; $iPreachment < $limit; $iPreachment++)
		{
			$arrPrechments[$iPreachment]['year'] = \Date::parse('Y', $arrPrechments[$iPreachment]['date']);
			$arrPrechments[$iPreachment]['month'] = \Date::parse('F', $arrPrechments[$iPreachment]['date']);
		}

		for ($iPreachment = $offset; $iPreachment < $limit; $iPreachment++)
		{
			// PW: Info über Predigten am gleichen Tag			
			$arrPrechments[$iPreachment]['dayPattern'] = true;
			if ($iPreachment > 0)
			{
				if ($arrPrechments[$iPreachment]['date'] != $arrPrechments[$iPreachment - 1]['date'])
				{
					$arrPrechments[$iPreachment]['dayPattern'] = !($arrPrechments[$iPreachment - 1]['dayPattern']);
				}
				else
				{
					$arrPrechments[$iPreachment]['dayPattern'] = ($arrPrechments[$iPreachment - 1]['dayPattern']);
				}
			}

			// PW: Info über letztes Event im Monat
			$arrPrechments[$iPreachment]['lastEventThisMonth'] = false;
			if ($iPreachment < $limit)
			{
				if ($arrPrechments[$iPreachment]['month'] != $arrPrechments[$iPreachment + 1]['month'])
					$arrPrechments[$iPreachment]['lastPreachmentThisMonth'] = true;
			}



			$preachment = $arrPrechments[$iPreachment];
			$preachment['dateFormated'] = \Date::parse($objPage->dateFormat, $preachment['date']);
			$preachment['sonntag'] = '';
			// PW: CSS Klasse für verschiedene Tage
			$preachment['dayPattern'] = ($preachment['dayPattern'] ? 'oddday' : 'evenday');
			// PW: CSS Klasse für letztes Event im Monat
			$preachment['lastPreachmentThisMonth'] = ($preachment['lastPreachmentThisMonth'] ? 'lastPreachmentThisMonth' : '');
			// Tag im Kirchenjahr
			if (class_exists('\Losungen\LosungenModel'))
			{			
				$preachment['sonntag'] = \Losungen\LosungenModel::findOneByDatum($preachment['date'])->sonntag;
			}

			// Month header
			$preachment['newMonth'] = false;
			if ($strMonth != $preachment['month'])
			{
				$preachment['newMonth'] = true;
				$strMonth = $preachment['month'];
			}
			
			// Day header
			$preachment['newDay'] = false;
			if ($strDay != $preachment['dateFormated'])
			{
				$preachment['newDay'] = true;
				$strDay = $preachment['dateFormated'];
			}

			$strTemplate = 'mod_preachment';
			if ($this->preachmentTpl != '') {
				$strTemplate = $this->preachmentTpl;
			}
			$objTemplate = new \FrontendTemplate($strTemplate);
			$objTemplate->setData($preachment);
			$objTemplate->class = ((($intPreachmentCount % 2) == 0) ? ' even' : ' odd') . (($intPreachmentCount == 0) ? ' first' : '') . (($intPreachmentCount == $limit-1) ? ' last' : '');


			$strPreachments .= $objTemplate->parse();

			$strMonth = $preachment['month'];
			++$intPreachmentCount;
		}

		$this->Template->preachments = $strPreachments;
	}
}
