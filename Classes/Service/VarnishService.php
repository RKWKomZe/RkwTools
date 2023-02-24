<?php
namespace RKW\RkwTools\Service;

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

use Opsone\Varnish\Controller\VarnishController;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * VarnishService
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since TYPO3 9.5. This extension is going to be replaced by a new shop
 */
class VarnishService implements \TYPO3\CMS\Core\SingletonInterface
{

    /**
     * @var \TYPO3\CMS\Core\Log\Logger|null
     */
    protected ?Logger $logger = null;


    /**
     * Clears the varnish cache of the given pid
     *
     * @param int $pid Page-id
     * @return void
     */
    public function clearCacheOfToolsEvent(int $pid): void
    {

        $varnishController = GeneralUtility::makeInstance(VarnishController::class);
        $varnishController->clearCache(intval($pid));

        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Deleted Varnish for pid %s', $pid));
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger(): Logger
    {

        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }

        return $this->logger;
    }

}
