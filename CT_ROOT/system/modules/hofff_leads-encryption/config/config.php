<?php

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['modifyLeadsDataOnStore'][] = array('Hofff\Contao\LeadsEncryption\LeadsEncryptionHooks', 'modifyLeadsDataOnStore');
$GLOBALS['TL_HOOKS']['getLeadsExportRow'][]      = array('Hofff\Contao\LeadsEncryption\LeadsEncryptionHooks', 'getLeadsExportRow');
