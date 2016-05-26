<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package Hofff_leads-encryption
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

namespace Hofff\Contao\LeadsEncryption;


/**
 * Hook implementations
 *
 * @copyright  Hofff.com 2016-2016
 * @author     Cliff Parnitzky <cliff@hofff.com>
 */
class LeadsEncryptionHooks
{
  /**
   * Encrypt data, transmitted viaaa form, before storing into database
   */
  public function modifyLeadsDataOnStore($arrPost, $arrForm, $arrFiles, $intLead, $objFields, &$arrSet)
  {
    $objForm = \FormModel::findById($objFields->pid);
    
    if ($objForm != null && $objForm->encryptLeadsData)
    {
      $arrSet['value'] = \Encryption::encrypt($arrSet['value']);
      $arrSet['label'] = \Encryption::encrypt($arrSet['label']);
    }
  }
  
  /**
   * Decrypt data for export
   */
  public function getLeadsExportRow ($arrField, $arrData, $objConfig, $varValue)
  {
    $objForm = \FormModel::findById($objConfig->pid);

    if ($objForm != null && $objForm->encryptLeadsData)
    {
      if ($arrField['id'])
      {
        $varValue = \Encryption::decrypt($arrData[$arrField['id']]['value']);
      }
    }
    
    return $varValue;
  }
}
