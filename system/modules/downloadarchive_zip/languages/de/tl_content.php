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
 * Fields
 */
$GLOBALS['TL_LANG']['tl_content']['downloadarchiv'] = array('Downloadarchiv', 'Wählen Sie eins der Downloadarchive aus.');
$GLOBALS['TL_LANG']['tl_content']['downloadShowMeta']     = array('Metadaten Anzeigen?', 'Sollen Upload-Datum und Größe der Dateien angezeigt werden?');
$GLOBALS['TL_LANG']['tl_content']['downloadHideDate']     = array('Datum ausblenden', 'Die Anzeige des Upload-Datums ausblenden.');
$GLOBALS['TL_LANG']['tl_content']['downloadNumberOfItems'] = array('Gesamtzahl der Dateien', 'Hier können Sie die Gesamtzahl der Dateien festlegen. Geben Sie 0 ein, um alle anzuzeigen.');
$GLOBALS['TL_LANG']['tl_content']['downloadZip'] = array('Zip-Archiv anbieten?', 'Mit dieser Optionen können Sie eine Schalfläche bereitstellen, mit der alle enthaltenen Dateien auf einmal als Zip-Archiv heruntergeladen werden können.');

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_content']['downloadarchivSortingOptions']['sorting ASC'] = "Sortierreihenfolge aufsteigend";
$GLOBALS['TL_LANG']['tl_content']['downloadarchivSortingOptions']['sorting DESC'] = "Sortierreihenfolge absteigend";
$GLOBALS['TL_LANG']['tl_content']['downloadarchivSortingOptions']['title ASC'] = "Titel aufsteigend";
$GLOBALS['TL_LANG']['tl_content']['downloadarchivSortingOptions']['title DESC'] = "Title absteigend";
$GLOBALS['TL_LANG']['tl_content']['downloadarchivSortingOptions']['tstamp ASC'] = "Upload-Datum aufsteigend";
$GLOBALS['TL_LANG']['tl_content']['downloadarchivSortingOptions']['tstamp DESC'] = "Upload-Datum absteigend";

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_content']['downloadmeta_legend']  = 'Meta-Angaben';
$GLOBALS['TL_LANG']['tl_content']['downloadarchive_legend'] = 'Archivauswahl';

?>