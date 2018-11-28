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
 * RadioPreselectViewHelper
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RadioPreselectViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @param integer $currentUid
     * @param integer $filterUid
     * @param string $configList
     * @return boolean
     */
    public function render($currentUid, $filterUid, $configList)
    {
        $configList = explode(',', $configList);

        // is a filter set?
        if (intval($filterUid) == $currentUid) {
            return true;
            //===
        }

        // If only one item in the configList is set, we preselect this
        if (
            (count($configList) == 1)
            && ($configList[0] == $currentUid)
            && (!$filterUid)
        ) {
            return true;
            //===
        }

        return false;
        //===
    }

}