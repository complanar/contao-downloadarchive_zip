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


/**
 * Class ModuleDownloadarchiveZip
 * Front end module "downloadarchive_zip".
 *  
 * @package downloadarchive_zip
 */
class ModuleDownloadarchiveZip extends ModuleDownloadArchiv
{
  protected $downloadIcon = 'system/modules/downloadarchive_zip/html/download.png';
  protected $infoIcon = 'system/modules/downloadarchive_zip/html/dialog-info.png';
  /**
   * Template
   * @var string
   */
  protected $strTemplate = 'mod_downloadarchive_zip';

  /**
   * Generate Module
   * @return mixed
   */
  public function generate()
  {
    // Send zipfile to the browser
    if (strlen($this->Input->get('downloadZip')) && $this->Input->get('downloadZip') == $this->id)
    {
      $objDownload = new DownloadarchiveZip(deserialize($this->downloadarchiv, true));
      $objDownload->send($this->getArchiveDownloadName());
    }

    return parent::generate();
  }


  /**
   * Generate content element
   * @return void
   */
  protected function compile()
  {
    parent::compile();
    if(is_array($this->Template->arrFiles) && count($this->Template->arrFiles)) {
      global $objPage;
      // We reformat the filesize numbers and the date-format
      if (is_array($this->Template->arrFiles)) {
        $arrFiles = $this->Template->arrFiles;
        foreach ($arrFiles as $key => $row) {
          $strFile = urldecode(substr($row['href'], strpos($row['href'], 'file=') + 5));
          $objFile = new File($strFile);
          $arrFiles[$key]['filesize'] = $this->getReadableSize($objFile->filesize);
          $arrFiles[$key]['ctimeformated'] = $this->parseDate($objPage->dateFormat, $objFile->ctime);
          // Clean the RTE output
          if ($objPage->outputFormat == 'xhtml')
          {
            $arrFiles[$key]['description'] = $this->String->toXhtml($row['description']);
          } 
          else 
          {
            $arrFiles[$key]['description'] = $this->String->toHtml5($row['description']);
          }
        }
        $this->Template->arrFiles = $arrFiles;
      }
      $this->Template->downloadZip = $this->downloadZip ? true : false;
      $this->Template->zipFile = array();
      if ($this->downloadZip) {
        $zipFile = array();
        /**
         * We create the downloadarchive only if it is to bee shown and if 
         * metadata is shown, too, because then we need the filesize. Otherwise 
         * it is better to do this later because we can not know now if anybody 
         * will download it, so it might be that we do not need the archive 
         * file at all.
         */
        if ($this->downloadShowMeta) {
          $objDownload = new DownloadarchiveZip(deserialize($this->downloadarchiv, true));
          $zipFilename = $objDownload->generate();
          $objDownloadfile = new File($zipFilename);
          $zipFile['filesize'] = $this->getReadableSize($objDownloadfile->filesize, 1);
          $zipFile['ctime'] = $objDownloadfile->ctime;
          $zipFile['ctimeformated'] = $this->parseDate($objPage->dateFormat, $objDownloadfile->ctime);
        }
        $zipFile['href'] = $this->Environment->request . (stristr($this->Environment->request,'?') ? '&' : '?') . 'downloadZip=' . $this->urlEncode($this->id);
        $this->Template->zipFile = $zipFile;
        $this->Template->zipText = $GLOBALS['TL_LANG']['downloadarchive_zip']['downloadZip'];
      }
      // Download Icon
      $downloadIcon = array();
      if (($imgSize = @getimagesize(TL_ROOT . '/' . $this->downloadIcon)) !== false)
      {
        $downloadIcon['iconSize'] = ' ' . $imgSize[3];
      }
      $downloadIcon['src'] = $this->downloadIcon;
      $this->Template->downloadIcon = $downloadIcon;
      
      // Info icon
      $infoIcon = array();
      if (($imgSize = @getimagesize(TL_ROOT . '/' . $this->infoIcon)) !== false)
      {
        $infoIcon['iconSize'] = ' ' . $imgSize[3];
      }
      $infoIcon['src'] = $this->infoIcon;
      $this->Template->infoIcon = $infoIcon;
    }
  }
  
  protected function getArchiveDownloadName() {
    return !empty($this->headline)? $this->headline : $GLOBALS['TL_LANG']['CTE']['downloadarchiv'][0];
  }
  
  protected function formatFilesize($bytes) {
    $units = array ('Bytes', 'kB', 'MB', 'GB', 'TB');
    for ($i = 0; $bytes >= 1024; $i++) {
      $bytes = $bytes / 1024;
    }
    
    $numberFormatted = number_format($bytes, 1, 
      $GLOBALS['TL_LANG']['MSC']['decimalSeparator'], 
      $GLOBALS['TL_LANG']['MSC']['thousandsSeparator']).' '.$units[$i];
    
    var_dump($numberFormatted);
    return $numberFormatted; 
  }
}

?>