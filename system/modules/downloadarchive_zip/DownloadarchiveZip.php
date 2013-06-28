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
 * Class DownloadarchiveZip
 * Download complete downloadarchives as zip files
 *
 * @package downloadarchive_zip
 */
class DownloadarchiveZip extends Frontend
{
  /**
   * Download-archives
   * @var string
   */
  protected $arrDownloadarchives = array();
  
  /**
   * Instantiate class
   * @param array
   */
  public function __construct($arrDownloadarchives) {
    $this->arrDownloadarchives = $arrDownloadarchives;
    parent::__construct();
  }
  
  /**
   * Generate archive zip file and return filename if successful or null otherwise
   * @return mixed
   */
  public function generate() {
    $files = $this->Database->prepare("SELECT * FROM tl_downloadarchivitems 
      WHERE pid IN (". implode(',', $this->arrDownloadarchives) .") 
      AND published=? ORDER BY singleSRC")
      ->execute("1");
      
    $checksum = '';
    $arrFiles = array();
    while ($files->next()) {
      /**
       * Continue if
       * - the file does not exist or
       * - the file is only visible to guest but there ist a FE user logged in or
       * - the file is protected and there is neither a FE nor a BE user looged in
       */
      if(!file_exists($files->singleSRC) || ($files->guests && FE_USER_LOGGED_IN) || ($files->protected == 1 && !FE_USER_LOGGED_IN && !BE_USER_LOGGED_IN))
      {
        continue;
      }
      
      // Get all groups of the current front end user
      if (FE_USER_LOGGED_IN)
      {
        $this->import('FrontendUser', 'FEUser');
      }
      
      /**
       * Continue if
       * - the file is protected and the FE user is not member of one of the file's groups
       * unless there is a BE user logged in
       */
      if ($files->protected == 1 && count(array_intersect($this->FEUser->groups, deserialize($files->groups, true))) < 1 && !BE_USER_LOGGED_IN)
      {
        continue;
      }
      
      $arrFiles[] = $files->singleSRC;
      $f = new File($files->singleSRC);
      $checksum .= $files->singleSRC . $f->filesize . $f->mtime;
      unset ($f);
    }

    // Are there any files to zip? If not we return null
    if (empty($arrFiles)) {
      return null;
    }
    
    $checksum = md5($checksum);
    $strFilename = (strlen(strval($strFilename)) > 0)? utf8_romanize(strval($strFilename)) : 'archive';
    $zipFilename = 'system/html/downloadarchive_'.$checksum.'.zip';
    
    // If the archive file not already exists we create it
    if (!file_exists(TL_ROOT . '/' . $zipFilename)) {
      // If the archive file does not exist we create it
      $zipArchive = new ZipWriter($zipFilename);
      foreach ($arrFiles as $file) {
        // Zip Archives do not support utf8-encodes filenames so we decode them 
        // and strip the Contao upload path at the beginning.
        $zipArchive->addFile($file, utf8_decode(substr($file, utf8_strlen($GLOBALS['TL_CONFIG']['uploadPath']) + 1)));
      }
      $zipArchive->close();
      unset($zipArchive);
    }
    
    return $zipFilename;
  }

  /**
   * Generate the Zip Archive (if not already exists) and send it to the browser
   * @param string
   * @return void
   */
  public function send($strFilename = '')
  {
    $zipFilename = $this->generate(); 
    // If the archive file is created we 
    if (is_string($zipFilename) && file_exists(TL_ROOT . '/' . $zipFilename)) {
      $this->sendFileToBrowser($zipFilename, $strFilename . '.zip');
    } else {
      $this->redirect($this->getReferer());
    }
  }
  
  /**
   * Send a file to the browser so the "save as" dialogue opens
   * Code mostly copied from system/libraries/Controller.php
   * 
   * @param string
   * @param string
   * @return void
   */
  protected function sendFileToBrowser($strFile, $strAlternateFilename = '')
  {
    // Make sure there are no attempts to hack the file system
    if (preg_match('@^\.+@i', $strFile) || preg_match('@\.+/@i', $strFile) || preg_match('@(://)+@i', $strFile))
    {
      header('HTTP/1.1 404 Not Found');
      die('Invalid file name');
    }

    // Check whether the file exists
    if (!file_exists(TL_ROOT . '/' . $strFile))
    {
      header('HTTP/1.1 404 Not Found');
      die('File not found');
    }

    $objFile = new File($strFile);
    $arrAllowedTypes = trimsplit(',', strtolower($GLOBALS['TL_CONFIG']['allowedDownload']));

    if (!in_array($objFile->extension, $arrAllowedTypes))
    {
      header('HTTP/1.1 403 Forbidden');
      die(sprintf('File type "%s" is not allowed', $objFile->extension));
    }

    // Make sure no output buffer is active
    // @see http://ch2.php.net/manual/en/function.fpassthru.php#74080
    while (@ob_end_clean());

    // Prevent session locking (see #2804)
    session_write_close();

    // Open the "save as …" dialogue
    header('Content-Type: ' . $objFile->mime);
    header('Content-Transfer-Encoding: binary');
    header('Content-Disposition: attachment; filename="' . (empty($strAlternateFilename)? $objFile->basename : $strAlternateFilename) . '"');
    header('Content-Length: ' . $objFile->filesize);
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');
    header('Connection: close');

    $resFile = fopen(TL_ROOT . '/' . $strFile, 'rb');
    fpassthru($resFile);
    fclose($resFile);

    // HOOK: post download callback
    if (isset($GLOBALS['TL_HOOKS']['postDownload']) && is_array($GLOBALS['TL_HOOKS']['postDownload']))
    {
      foreach ($GLOBALS['TL_HOOKS']['postDownload'] as $callback)
      {
        $this->import($callback[0]);
        $this->$callback[0]->$callback[1]($strFile);
      }
    }

    // Stop script
    exit;
  }
}
?>