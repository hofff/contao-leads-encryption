<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'Hofff',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Hofff\Contao\LeadsEncryption\LeadsEncryptionHooks' => 'system/modules/hofff_leads-encryption/classes/LeadsEncryptionHooks.php',
));
