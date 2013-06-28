<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Downloadarchive Zip
 * Copyright (C) 2012 Holger Teichert
 *
 * Extension for:
 * Contao Open Source CMS
 * Copyright (C) 2005-2012 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 *
 * @copyright  Holger Teichert 2012
 * @author     Holger Teichert <post@complanar.de>
 * @package    downloadarchive_zip
 * @license    LGPL
 */

$GLOBALS['TL_DCA']['tl_downloadarchiv']['fields']['dirSRC']['eval']['fieldType'] = 'checkbox';
$GLOBALS['TL_DCA']['tl_downloadarchiv']['fields']['dirSRC']['eval']['files'] = true;
$GLOBALS['TL_DCA']['tl_downloadarchiv']['config']['onsubmit_callback'] = array(array('tl_downloadarchive', 'loadFiles'));
/**
 * Class tl_downloadarchive
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Holger Teichert 2012
 * @author     Holger Teichert <post@complanar.de>
 * @package    downloadarchive_zip
 */
class tl_downloadarchive extends tl_downloadarchiv {
  
  /**
   * Add the selected files
   * @param array
   * @return string
   */
  public function loadFiles(DataContainer $dc) {
    $objPS = $this->Database->prepare("SELECT * FROM tl_downloadarchiv WHERE id=?")
            ->limit(1)
            ->execute($dc->id);
    
    $objPSI = $this->Database->prepare("SELECT * FROM tl_downloadarchivitems WHERE pid=?")
             ->execute($dc->id);
    
    if($objPS->loadDirectory==1 && $objPSI->numRows==0)
    {
      $arrDirectories = deserialize($objPS->dirSRC, true);
      $loadSubdir = $objPS->loadSubdir == 1 ? true : false;
      $this->extension = $objPS->extension != "" ? explode(',',$objPS->extension) : array();
      
      $this->i = 0;
      
      $arrFiles = array();
      foreach ($arrDirectories as $file) {
        if (is_file(TL_ROOT.'/'.$file)) {
          $objFile = new File('/'.$file);
          $key = $objPS->prefix != "" ? $objPS->prefix . " " . str_pad(++$this->i,3,'0',STR_PAD_LEFT) : $objFile->filename;
          $arrFiles[$key] = $file;
          $objFile->close();
          continue;
        }
        if (is_dir(TL_ROOT.'/'.$file)) {
          $arrFiles = array_merge($arrFiles, $this->getFiles($file, $objPS->prefix, $loadSubdir));
        }
      }
      ksort($arrFiles);
      
      $j = 0;
      foreach($arrFiles as $key=>$value)
      {
        $arrValues = array(
          'pid'       => $dc->id,
          'sorting'   => ++$j * 64,
          'tstamp'    => time(),
          'title'     => str_replace('_',' ',$key),
          'singleSRC' => $value,
          'published' => ($objPS->publishAll == 1 ? 1 : 0) 
        );
        
        $objPSIW = $this->Database->prepare("INSERT INTO tl_downloadarchivitems %s")
                      ->set($arrValues)
                      ->execute();
      }
    }
  }
}
