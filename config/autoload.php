<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'PhilippWinkel',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'PhilippWinkel\Preachments'          => 'system/modules/preachments/classes/Preachments.php',

	// Models
	'PhilippWinkel\PreachmentsModel'     => 'system/modules/preachments/models/PreachmentsModel.php',

	// Modules
	'PhilippWinkel\ModulePreachmentList' => 'system/modules/preachments/modules/ModulePreachmentList.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'mod_preachment'     => 'system/modules/preachments/templates',
	'mod_preachmentlist' => 'system/modules/preachments/templates',
));
