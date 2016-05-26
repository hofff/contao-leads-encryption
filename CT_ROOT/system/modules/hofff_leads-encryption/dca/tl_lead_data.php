<?php

/**
 * Table tl_lead_data
 */
$GLOBALS['TL_DCA']['tl_lead_data']['config']['onload_callback'][] = array('tl_lead_data_hofff_leads_encryption', 'modifyPaletteAndFields');

/**
 * Class tl_lead_data_hofff_leads_encryption
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Hofff.com 2016-2016
 * @author     Cliff Parnitzky <cliff@hofff.com>
 * @package    Core
 */
class tl_lead_data_hofff_leads_encryption extends tl_lead_data
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
    $objForm = \Database::getInstance()->prepare("SELECT * FROM tl_form f JOIN tl_form_field ff ON f.id = ff.pid JOIN tl_lead_data ld ON ff.id = ld.field_id WHERE ld.pid = ?")
                                       ->execute((int) $dc->id);
      
    if ($objForm->numRows && $objForm->encryptLeadsData)
    {
      $GLOBALS['TL_DCA']['tl_lead_data']['fields']['value']['eval']['encrypt'] = true;
      $GLOBALS['TL_DCA']['tl_lead_data']['fields']['label']['eval']['encrypt'] = true;
    }
  }
} 