<?php

/**
 * Table tl_lead
 */
$GLOBALS['TL_DCA']['tl_lead']['list']['label']['label_callback'] = array('tl_lead_hofff_leads_encryption', 'getLabel');

/**
 * Class tl_lead_hofff_leads_encryption
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Hofff.com 2016-2016
 * @author     Cliff Parnitzky <cliff@hofff.com>
 * @package    Core
 */
class tl_lead_hofff_leads_encryption extends tl_lead
{
  /**
   * Import the back end user object
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Generate label for this record.
   *
   * @param array
   * @param string
   *
   * @return string
   */
  public function getLabel($row, $label)
  {
    $objForm = \FormModel::findById($row['master_id']);

    if ($objForm != null && $objForm->encryptLeadsData)
    {
      $arrTokens = array(
          'created' => \Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], $row['created'])
      );

      $objData = \Database::getInstance()->prepare("SELECT * FROM tl_lead_data WHERE pid=?")->execute($row['id']);

      while ($objData->next()) {
          Haste\Util\StringUtil::flatten(deserialize(\Encryption::decrypt($objData->value)), $objData->name, $arrTokens);
      }

      return \Haste\Util\StringUtil::recursiveReplaceTokensAndTags($objForm->leadLabel, $arrTokens);
    }
    
    return parent::getLabel($row, $label);
  }
} 