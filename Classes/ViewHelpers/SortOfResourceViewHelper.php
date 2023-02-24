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

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/**
 * SortOfResourceViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since TYPO3 9.5. This extension is going to be replaced by a new shop
 */
class SortOfResourceViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('typolink', 'string', 'The typolink', true);

        trigger_error(__CLASS__ . ' is deprecated and will be removed soon', E_USER_DEPRECATED);
    }


    /**
     * @return string
     * @see: https://docs.typo3.org/m/typo3/reference-typoscript/8.7/en-us/Functions/Typolink/Index.html#resource-references
     */
    public function render(): string
    {

        /** @var string $typolink */
        $typolink = $this->arguments['typolink'];

        // new version of typolink
        if (strpos($typolink, 't3://') === 0) {

            // internal file
            if (substr($typolink, 5, 4) === "file") {
                return LocalizationUtility::translate('viewhelper.file', 'rkwTools');
            }

            // internal page
            if (substr($typolink, 5, 4) === "page") {
                return LocalizationUtility::translate('viewhelper.internalPage', 'rkwTools');
            }

        // old version of typolink
        } else {

            // internal file
            if (substr($typolink, 0, 5) === "file:") {
                return LocalizationUtility::translate('viewhelper.file', 'rkwTools');
            }

            // internal page
            if (is_numeric($typolink)) {
                return LocalizationUtility::translate('viewhelper.internalPage', 'rkwTools');
            }
        }

        // external link
        if (
            substr($typolink, 0, 3) === "www"
            || substr($typolink, 0, 4) === "http"
            || substr($typolink, 0, 5) === "https"
        ) {
            return LocalizationUtility::translate('viewhelper.externalPage', 'rkwTools');
        }

        // other
        return LocalizationUtility::translate('viewhelper.other', 'rkwTools');
    }

}
