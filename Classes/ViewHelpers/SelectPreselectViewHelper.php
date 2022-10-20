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
 * SelectPreselectViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SelectPreselectViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('filterUid', 'int', 'The filter uid.', true);
        $this->registerArgument('configList', 'array', 'The array of options.', true);
    }


    /**
     * @return boolean
     */
    public function render(): bool
    {
        /** @var int $filterUid */
        $filterUid = $this->arguments['filterUid'];

        /** @var array $configList */
        $configList = $this->arguments['configList'];
        $configList = explode(',', $configList);

        // is a filter set?
        if (intval($filterUid)) {
            return intval($filterUid);
            //===
        }

        // If only one item in the configList is set, we preselect this
        if (count($configList) == 1) {
            return $configList[0];
            //===
        }

        return 0;
        //===
    }

}
