<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2018 Leo Feyer
 *
 * @package Hofff_leads-encryption
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Hofff\Contao\LeadsEncryption;


/**
 * Hook implementations
 *
 * @copyright  Hofff.com 2016-2018
 * @author     Cliff Parnitzky <cliff@hofff.com>
 */
class LeadsEncryptionHooks
{
  /**
   * Encrypt data, transmitted via form, before storing into database
   */
  public function modifyLeadsDataOnStore($arrPost, $arrForm, $arrFiles, $intLead, $objFields, &$arrSet)
  {
    if ($this->isEncryptLeadsDataActive($objFields->pid))
    {
      $arrSet['value'] = \Encryption::encrypt($arrSet['value']);
      $arrSet['label'] = \Encryption::encrypt($arrSet['label']);
    }
  }
  
  /**
   * Encrypt post data after stored to database
   */
  public function storeLeadsData($arrPost, $arrForm, $arrFiles, $intLead, $objFields)
  {
    if ($this->isEncryptLeadsDataActive($objFields->pid))
    {
      foreach($arrPost as $key=>$value)
      {
        $arrPost[$key] = \Encryption::encrypt($value);
      }
      \Database::getInstance()->prepare("UPDATE tl_lead SET post_data = ? WHERE id = ?")->execute(array(serialize($arrPost), $intLead));
    }
  }
  
  /**
   * Decrypt data for export
   */
  public function getLeadsExportRow ($arrField, $arrData, $objConfig, $varValue)
  {
    if ($this->isEncryptLeadsDataActive($objConfig->pid))
    {
      if ($arrField['id'])
      {
        $varValue = \Leads\Exporter\Utils\Row::transformValue(\Encryption::decrypt($arrData[$arrField['id']]['value']), $arrField);
      }
    }
    
    return $varValue;
  }
  
  private function isEncryptLeadsDataActive($intFormId)
  {
    $objForm = \Database::getInstance()->prepare("SELECT encryptLeadsData FROM tl_form WHERE id = ?")->execute($intFormId);
    return $objForm->next() && $objForm->encryptLeadsData;
  }
}
