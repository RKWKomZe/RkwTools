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

use \TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * LinkCheckerViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class LinkCheckerViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('parameter', 'string', 'The parameters.', true);
    }


    /**
     * @return bool
     */
    public function render(): bool
    {

        /** @var string $parameter */
        $parameter = $this->arguments['parameter'];

        if (!GeneralUtility::getApplicationContext()->isProduction()) {
            // JUST FOR DEVELOPMENT: Because the LIVE links does not exist in local context, no tools would be shown
            return true;
        }

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        // create uri by typolink helper
        /** @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj */
        $cObj = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\ContentObject\\ContentObjectRenderer');
        $uri = $cObj->typolink_URL(
            [
                'parameter' => $parameter,
            ]
        );

        return (bool)$uri;
    }

}
