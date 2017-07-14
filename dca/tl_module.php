<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Add palettes to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['palettes']['preachmentlist']   = '{title_legend},name,headline,type;{config_legend},perPage,numberOfItems;{template_legend:hide},customTpl,preachmentTpl;{expert_legend:hide},guests,cssID,space;';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['preachmentTpl'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['preachmentTpl'],
	'default'                 => 'mod_preachment',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options_callback'        => array('tl_module_preachmentlist', 'getPreachmentTemplates'),
	'eval'                    => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_module_preachmentlist extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


	/**
	 * Return all newsletter templates as array
	 *
	 * @return array
	 */
	public function getPreachmentTemplates()
	{
		return $this->getTemplateGroup('mod_preachment');
	}    
}