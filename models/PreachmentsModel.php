<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace PhilippWinkel;


/**
 * Reads and writes calendars
 *
 * @property integer $id
 * @property integer $tstamp
 * @property string  $title
 * @property integer $jumpTo
 * @property boolean $protected
 * @property string  $groups
 * @property boolean $allowComments
 * @property string  $notify
 * @property string  $sortOrder
 * @property integer $perPage
 * @property boolean $moderate
 * @property boolean $bbcode
 * @property boolean $requireLogin
 * @property boolean $disableCaptcha
 *
 * @method static \PreachmentModel|null findById($id, $opt=array())
 * @method static \PreachmentModel|null findByPk($id, $opt=array())
 * @method static \PreachmentModel|null findByIdOrAlias($val, $opt=array())
 * @method static \PreachmentModel|null findOneBy($col, $val, $opt=array())
 * @method static \PreachmentModel|null findOneByTstamp($val, $opt=array())
 * @method static \PreachmentModel|null findOneByTitle($val, $opt=array())
 * @method static \PreachmentModel|null findOneByJumpTo($val, $opt=array())
 * @method static \PreachmentModel|null findOneByProtected($val, $opt=array())
 * @method static \PreachmentModel|null findOneByGroups($val, $opt=array())
 * @method static \PreachmentModel|null findOneByAllowComments($val, $opt=array())
 * @method static \PreachmentModel|null findOneByNotify($val, $opt=array())
 * @method static \PreachmentModel|null findOneBySortOrder($val, $opt=array())
 * @method static \PreachmentModel|null findOneByPerPage($val, $opt=array())
 * @method static \PreachmentModel|null findOneByModerate($val, $opt=array())
 * @method static \PreachmentModel|null findOneByBbcode($val, $opt=array())
 * @method static \PreachmentModel|null findOneByRequireLogin($val, $opt=array())
 * @method static \PreachmentModel|null findOneByDisableCaptcha($val, $opt=array())
 *
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByTstamp($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByTitle($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByJumpTo($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByProtected($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByGroups($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByAllowComments($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByNotify($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findBySortOrder($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByPerPage($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByModerate($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByBbcode($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByRequireLogin($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findByDisableCaptcha($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findMultipleByIds($val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findBy($col, $val, $opt=array())
 * @method static \Model\Collection|\PreachmentModel[]|\PreachmentModel|null findAll($opt=array())
 *
 * @method static integer countById($id, $opt=array())
 * @method static integer countByTstamp($val, $opt=array())
 * @method static integer countByTitle($val, $opt=array())
 * @method static integer countByJumpTo($val, $opt=array())
 * @method static integer countByProtected($val, $opt=array())
 * @method static integer countByGroups($val, $opt=array())
 * @method static integer countByAllowComments($val, $opt=array())
 * @method static integer countByNotify($val, $opt=array())
 * @method static integer countBySortOrder($val, $opt=array())
 * @method static integer countByPerPage($val, $opt=array())
 * @method static integer countByModerate($val, $opt=array())
 * @method static integer countByBbcode($val, $opt=array())
 * @method static integer countByRequireLogin($val, $opt=array())
 * @method static integer countByDisableCaptcha($val, $opt=array())
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class PreachmentsModel extends \Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTable = 'tl_preachments';

	public static function findAllPublished(array $arrOptions=array())
	{
		$t = static::$strTable; 
		$arrColumns = array();

		if (!BE_USER_LOGGED_IN) 
		{ 
			$time = time(); 
			$arrColumns[] = "($t.start = '' OR $t.start < $time) AND ($t.stop = '' OR $t.stop > $time) AND ($t.published = 1)";

			return static::findBy($arrColumns, '', $arrOptions);
		}

		return static::findAll($arrOptions);
	}
}
