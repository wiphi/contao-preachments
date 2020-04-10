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
 * Table tl_preachments
 */
$GLOBALS['TL_DCA']['tl_preachments'] = array
(

	// Config
	'config' => array
	(
		'dataContainer'               => 'Table',
		'enableVersioning'            => true,
		'sql' => array
		(
			'keys' => array
			(
				'id' => 'primary'
			)
		)
	),

	// List
	'list' => array
	(
		'sorting' => array
		(
            'mode' => 2,
            'flag' => 11,
            'fields' => array('date', 'title'),
            'panelLayout' => 'filter;sort,search,limit',
            'disableGrouping' => false,
		),
		'label' => array
		(
            'fields' => array('date', 'title', 'speaker'),
            //'showColumns' => true,
            'format' => '%s %s (%s)'        
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'                => 'act=select',
				'class'               => 'header_edit_all',
				'attributes'          => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations' => array
		(
			'edit' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_preachments']['edit'],
				'href'                => 'act=edit',
				'icon'                => 'edit.gif'
			),
			'copy' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_preachments']['copy'],
				'href'                => 'act=copy',
				'icon'                => 'copy.gif'
			),
			'delete' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_preachments']['delete'],
				'href'                => 'act=delete',
				'icon'                => 'delete.gif',
				'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"'
			),
			'toggle' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_preachments']['toggle'],
				'icon'                => 'visible.gif',
				'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
				'button_callback'     => array('tl_preachments', 'toggleIcon')
			),			
			'show' => array
			(
				'label'               => &$GLOBALS['TL_LANG']['tl_preachments']['show'],
				'href'                => 'act=show',
				'icon'                => 'show.gif'
			)
		)
	),

	// Select
	'select' => array
	(
		'buttons_callback' => array()
	),

	// Edit
	'edit' => array
	(
		'buttons_callback' => array()
	),

	// Palettes
	'palettes' => array
	(
		'__selector__'                => array('published'),
		'default' => '{title_legend},title,speaker,date,author;{preachments_legend},description;{file_legend},src;{publish_legend},published'
	),

	// Subpalettes
	'subpalettes' => array
	(
		'published'                   => 'start,stop'
	),

	// Fields
	'fields' => array
	(
		'id' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL auto_increment"
		),
		'tstamp' => array
		(
			'sql'                     => "int(10) unsigned NOT NULL default '0'"
		),
		'title' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_preachments']['title'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('mandatory'=>true, 'maxlength'=>255),
			'sql'                     => "varchar(255) NOT NULL default ''"
		),
        'author' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_preachments']['author'],
			'default'                 => BackendUser::getInstance()->id,
			'exclude'                 => true,
			'search'                  => true,
			'filter'                  => true,
			'sorting'                 => false,
			'flag'                    => 11,
			'inputType'               => 'select',
			'foreignKey'              => 'tl_user.name',
			'eval'                    => array('doNotCopy'=>true, 'chosen'=>true, 'mandatory'=>true, 'includeBlankOption'=>true, 'tl_class'=>'w50'),
			'sql'                     => "int(10) unsigned NOT NULL default '0'",
			'relation'                => array('type'=>'hasOne', 'load'=>'eager')
		),
        'date' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_preachments']['date'],
            'exclude' => false,
            //'search' => true,
            'sorting' => true,
            'filter' => true,
            'flag' => 8,            
            'inputType' => 'text',
            'default' => \Date::parse(\Config::get('dateFormat')),
            'eval' => array(
                'rgxp' => 'date',                
                'mandatory' => true,
                'doNotCopy' => true, 
                'datepicker' => true, 
                'tl_class' => 'w50 wizard'),
            'sql' => "varchar(10) NOT NULL"      
        ),
        'speaker' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_preachments']['speaker'],
            'exclude' => false,
            'search' => true,
            'sorting' => true,
            'filter' => true,
            'flag' => 1,            
            'inputType' => 'text',
            'eval' => array(
                'mandatory' => true,
                'unique' => false,
                'maxlength' => 100,
                'tl_class' => 'w50'
            ),
            'sql' => "varchar(100) NOT NULL default ''"            
        ),
        'description' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_preachments']['description'],
            'exclude' => true,
            'search' => true,
            'sorting' => false,
            'filter' => false,
            'inputType' => 'textarea',
            'eval' => array(
                'mandatory' => false,
                'unique' => false,
                //'maxlength' => 255,
                'allowHtml' => true,
                'rte' => 'tinyMCE'
            ),
            'sql' => "text NULL"            
        ),
        'src' => array(
            'label' => &$GLOBALS['TL_LANG']['tl_preachments']['src'],
            'exclude' => false,
            'search' => true,
            'sorting' => false,
            'filter' => false,
            'inputType' => 'fileTree',
            'eval' => array(
                'mandatory' => true,
                'unique' => false,
                'files' => true,
                'filesOnly' => true,
				'fieldType' => 'radio',
                'extensions' => 'pdf,mp3,ogg,wav,wma,mp4,m4v,mov,wmv,webm,ogv', 
                'rgxp' => 'folderalias',
                'tl_class' => ''
            ),
            'sql' => "binary(16) NULL"            
        ),
		'published' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_preachments']['published'],
			'exclude'                 => true,
			'filter'                  => true,
			'flag'                    => 1,
			'inputType'               => 'checkbox',
			'eval'                    => array('submitOnChange'=>true, 'doNotCopy'=>true),
			'sql'                     => "char(1) NOT NULL default ''"
		),
		'start' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_preachments']['start'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		),
		'stop' => array
		(
			'label'                   => &$GLOBALS['TL_LANG']['tl_preachments']['stop'],
			'exclude'                 => true,
			'inputType'               => 'text',
			'eval'                    => array('rgxp'=>'datim', 'datepicker'=>true, 'tl_class'=>'w50 wizard'),
			'sql'                     => "varchar(10) NOT NULL default ''"
		)			        		
	)
);

class tl_preachments extends Backend
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
	 * Check permissions to edit table tl_news
	 */
	public function checkPermission()
	{
		// not implemented
		return;
	}	

	/**
	 * Return the "toggle visibility" button
	 *
	 * @param array  $row
	 * @param string $href
	 * @param string $label
	 * @param string $title
	 * @param string $icon
	 * @param string $attributes
	 *
	 * @return string
	 */
	public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
	{
		if (strlen(Input::get('tid')))
		{
			$this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
			$this->redirect($this->getReferer());
		}

		// Check permissions AFTER checking the tid, so hacking attempts are logged
		if (!$this->User->hasAccess('tl_preachments::published', 'alexf'))
		{
			return '';
		}

		$href .= '&amp;tid='.$row['id'].'&amp;state='.($row['published'] ? '' : 1);

		if (!$row['published'])
		{
			$icon = 'invisible.gif';
		}

		return '<a href="'.$this->addToUrl($href).'" title="'.specialchars($title).'"'.$attributes.'>'.Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"').'</a> ';
	}


	/**
	 * Disable/enable a user group
	 *
	 * @param integer       $intId
	 * @param boolean       $blnVisible
	 * @param DataContainer $dc
	 */
	public function toggleVisibility($intId, $blnVisible, DataContainer $dc=null)
	{
		// Set the ID and action
		Input::setGet('id', $intId);
		Input::setGet('act', 'toggle');

		if ($dc)
		{
			$dc->id = $intId; // see #8043
		}

		$this->checkPermission();

		// Check the field access
		if (!$this->User->hasAccess('tl_preachments::published', 'alexf'))
		{
			$this->log('Not enough permissions to publish/unpublish news item ID "'.$intId.'"', __METHOD__, TL_ERROR);
			$this->redirect('contao/main.php?act=error');
		}

		$objVersions = new Versions('tl_preachments', $intId);
		$objVersions->initialize();

		// Trigger the save_callback
		if (is_array($GLOBALS['TL_DCA']['tl_preachments']['fields']['published']['save_callback']))
		{
			foreach ($GLOBALS['TL_DCA']['tl_preachments']['fields']['published']['save_callback'] as $callback)
			{
				if (is_array($callback))
				{
					$this->import($callback[0]);
					$blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, ($dc ?: $this));
				}
				elseif (is_callable($callback))
				{
					$blnVisible = $callback($blnVisible, ($dc ?: $this));
				}
			}
		}

		// Update the database
		$this->Database->prepare("UPDATE tl_preachments SET tstamp=". time() .", published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")
					   ->execute($intId);

		$objVersions->create();
	}
}
