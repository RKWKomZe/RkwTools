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
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since TYPO3 9.5. This extension is going to be replaced by a new shop
 */
class RadioPreselectViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Initialize arguments
     *
     * @return void
     */
    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('currentUid', 'int', 'The current uid.', true);
        $this->registerArgument('filterUid', 'int', 'The filter uid.', true);
        $this->registerArgument('configList', 'array', 'The array of options.', true);

        trigger_error(__CLASS__ . ' is deprecated and will be removed soon', E_USER_DEPRECATED);
    }


    /**
     * @return bool
     */
    public function render(): bool
    {

        /** @var int $currentUid */
        $currentUid = $this->arguments['currentUid'];

        /** @var int $filterUid */
        $filterUid = $this->arguments['filterUid'];

        /** @var string $configList */
        $configList = $this->arguments['configList'];
        $configList = explode(',', $configList);

        // is a filter set?
        if ($filterUid == $currentUid) {
            return true;
        }

        // If only one item in the configList is set, we preselect this
        if (
            (count($configList) == 1)
            && ($configList[0] == $currentUid)
            && (!$filterUid)
        ) {
            return true;
        }

        return false;
    }

}
