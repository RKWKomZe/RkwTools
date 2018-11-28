<?php

namespace RKW\RkwTools\ViewHelpers;
/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * SortOfResourceViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SortOfResourceViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @param mixed $typolink
     * @return string
     */
    public function render($typolink)
    {
        // internal file
        if (substr($typolink, 0, 5) === "file:") {
            return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('viewhelper.file', 'rkwTools');
            //===
        }

        // external link
        if (
            substr($typolink, 0, 3) === "www"
            || substr($typolink, 0, 4) === "http"
            || substr($typolink, 0, 5) === "https"
        ) {
            return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('viewhelper.externalPage', 'rkwTools');
            //===
        }

        // internal page
        if (is_numeric($typolink)) {
            return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('viewhelper.internalPage', 'rkwTools');
            //===
        }

        // other
        return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate('viewhelper.other', 'rkwTools');
        //===
    }

}