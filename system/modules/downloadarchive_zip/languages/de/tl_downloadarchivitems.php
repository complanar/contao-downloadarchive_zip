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
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['title'] = array('Titel', 'Der Titel wird als Linktext angezeigt. Er sollte die Datei möglichst kurz beschreiben.<br />(z.B. Preisliste Produkt1)');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['description'] = array('Beschreibung', 'Mit der Beschreibung können Sie genauere Informationen zur Datei angeben. Der Inhalt kann, je nach Template, passend zu einer Datei angezeigt werden.');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['singleSRC'] = array('Datei', 'Wählen Sie die Datei aus, die heruntergeladen werden soll.');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['protected']   = array('Element schützen', 'Das Element nur bestimmten Gruppen anzeigen.');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['guests']      = array('Nur Gästen anzeigen', 'Das Element nur Gästen zeigen.');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['groups']      = array('Erlaubte Mitgliedergruppen', 'Hier können Sie festlegen, welche Mitgliedergruppen das Element sehen können.');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['addImage']     = array('Ein Bild einfügen', 'Wenn Sie diese Option wählen, wird dem Beitrag ein Bild hinzugefügt.');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['useImage']     = array('Bildlink', 'Soll das Bild mit einem Link versehen werden?');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['published']     = array('Veröffentlicht', 'Solange Sie diese Option nicht wählen, ist das Downloadelement für die Besucher Ihrer Webseite nicht sichtbar.');

/**
 * Reference
 */
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['deleteConfirm'] = 'Möchten Sie die Datei ID %s wirklich aus dem Download-Archiv entfernen?\n(Die Datei wird dabei NICHT vom Server gelöscht)';
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['useImageReference']['0'] = 'kein';
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['useImageReference']['1'] = 'Großansicht';
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['useImageReference']['2'] = 'Downloadlink';


/**
 * Buttons
 */
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['new']    = array('Neue Datei', 'Erstellen Sie eine neue Datei.');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['edit']   = array('Datei bearbeiten', 'Bearbeiten Sie die Datei ID %s');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['copy']   = array('Datei kopieren', 'Kopieren Sie die Datei ID %s');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['cut']   = array('Datei verschieben', 'Kopieren Sie die Datei ID %s');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['delete'] = array('Datei löschen', 'Entfernen Sie die Datei ID %s');
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['show']   = array('Dateidetails anzeigen', 'Zeigen Sie die Details zur Datei ID %s');

/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['title_legend']      = 'Titel & Beschreibung';
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['file_legend']       = 'Datei';
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['image_legend']      = 'Foto anzeigen';
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['protection_legend'] = 'Dateifreigabe';
$GLOBALS['TL_LANG']['tl_downloadarchivitems']['publish_legend']    = 'Veröffentlichung';
?>