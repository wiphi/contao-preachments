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
 * Class Prechments
 *
 * @copyright  &#40;c&#41; Philipp Winkel 2017
 * @author     Philipp Winkel
 * @package    Devtools
 */
abstract class Preachments extends \Module
{
	/**
	 * Generate the module
	 */
	protected function getAllPreachments($arrCriteria = array())
	{
		$arrRetun = array();
		$objPreachments = \PreachmentsModel::findAllPublished($arrCriteria);
		while($objPreachments->next())
		{
			$arrPreachment = $objPreachments->row();
			$arrPreachment['file'] = \FilesModel::findById($arrPreachment['src']);
			$arrPreachment['dateFormated'] = \Date::parse(\Config::get('dateFormat'), $arrPreachment['date']);
			$arrRetun[] = $arrPreachment;			
		}
		return $arrRetun;
	}
}
