<?php

/**
 * Table tl_form
 */
$GLOBALS['TL_DCA']['tl_form']['config']['onload_callback'][] = array('tl_form_hofff_leads_encryption', 'modifyPaletteAndFields');

$GLOBALS['TL_DCA']['tl_form']['fields']['encryptLeadsData'] = array
(
  'label'                   => &$GLOBALS['TL_LANG']['tl_form']['encryptLeadsData'],
  'exclude'                 => true,
  'inputType'               => 'checkbox',
  'eval'                    => array('tl_class'=>'w50'),
  'sql'                     => "char(1) NOT NULL default ''"
);

/**
 * Class tl_form_hofff_leads_encryption
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Hofff.com 2016-2016
 * @author     Cliff Parnitzky <cliff@hofff.com>
 * @package    Core
 */
class tl_form_hofff_leads_encryption extends tl_form
{
  /**
   * Import the back end user object
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Modify the pallete and fields for this form
   */
  public function modifyPaletteAndFields($dc)
  {
    $objForm = \FormModel::findById((int) $dc->id);

    if ($objForm != null && $objForm->leadEnabled && $objForm->leadMaster == 0)
    {
      $GLOBALS['TL_DCA']['tl_form']['palettes']['default'] = str_replace('leadLabel', 'leadLabel,encryptLeadsData', $GLOBALS['TL_DCA']['tl_form']['palettes']['default']);
    }
  }
} 