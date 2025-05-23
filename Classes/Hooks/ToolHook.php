<?php
namespace RKW\RkwTools\Hooks;

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

use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\TypoScript\TemplateService;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Utility\RootlineUtility;

/**
 * Class ToolHook
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since TYPO3 9.5. This extension is going to be replaced by a new shop
 */
class ToolHook
{
    /**
     * Signal name for use in ext_localconf.php
     *
     * @const string
     */
    const SIGNAL_CLEAR_PAGE_VARNISH = 'afterImportClearVarnishCachePage';


    /**
     * processDatamap_postProcessFieldArray
     * For deleting caches after change content element
     *
     * @param string $status
     * @param string $table
     * @param string $id may be a string if handling new records!
     * @param array $fieldArray
     * @param object $reference
     * @return void
     */
    public function processDatamap_postProcessFieldArray(
        string $status,
        string $table,
        string $id,
        array &$fieldArray,
        object &$reference
    ): void {

        try {
            /** @var \TYPO3\CMS\Core\Cache\CacheManager $cacheManager */
            $cacheManager = GeneralUtility::makeInstance(CacheManager::class);

            // 1.) clear extension page cache when plugin filter is changed
            if (
                ($table == 'tt_content')
                && (intval($id) == $id)
                && ($record = BackendUtility::getRecord('tt_content', intval($id)))
            ) {

                // if list_type starts with "rkwreleated". The function strpos delivers 0 on success
                if (
                    (isset($record['list_type']))
                    && (strpos($record['list_type'], 'rkwtools') === 0)
                ) {

                    // clear extension cache of current page
                    $cacheManager->flushCachesByTag('tx_rkwtools' . intval($record['pid']));
                    $this->getLogger()->log(
                        \TYPO3\CMS\Core\Log\LogLevel::INFO,
                        sprintf(
                            'Cleared extension cache by tag for page %s. Triggered by element with uid %s in table "%s".',
                            intval($record['pid']),
                            $id,
                            $table
                        ))
                    ;
                }
            }


            // 2.) clear extension cache of current page and all caches of defined pages on any change of tools- table
            if (
                ($table == 'tx_rkwtools_domain_model_tool')
                && (intval($id) == $id)
                && ($record = BackendUtility::getRecord('tx_rkwtools_domain_model_tool', intval($id)))
            ) {

                // clear extension cache of all pages
                $cacheManager->flushCachesByTag('tx_rkwtools');
                $this->getLogger()->log(
                    \TYPO3\CMS\Core\Log\LogLevel::INFO,
                    sprintf(
                        'Cleared complete extension cache by tag. Triggered by element with uid %s in table "%s".',
                        $id,
                        $table
                    )
                );

                // clear cache of defined pages
                $config = $this->getTsForPage(intval($record['pid']));
                if (
                    (isset($config['clearCachePageList']))
                    && ($pidList = GeneralUtility::trimExplode(',', $config['clearCachePageList'], true))
                ) {
                    foreach ($pidList as $pid) {

                        // clear extension cache
                        // @todo if we clear all caches above, we don't need to clear the cache for one page again
                        // $cacheManager->flushCachesByTag('tx_rkwtools' . $pid);
                        // $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Cleared extension cache by tag for page %s. Trigged by clearCachePageList.', intval($pid)));

                        // clear page cache
                        // @todo Do we really need this? No plugin of this extension is cached in page-cache!
                        // GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Service\\CacheService')->clearPageCache($pid);
                        // $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Cleared page cache by tag for page %s. Trigged by clearCachePageList.', $pid));

                        // trigger cleaning of varnish cache
                        GeneralUtility::makeInstance(Dispatcher::class)->dispatch(
                            __CLASS__,
                            self::SIGNAL_CLEAR_PAGE_VARNISH,
                            [intval($pid)]
                        );
                        $this->getLogger()->log(
                            \TYPO3\CMS\Core\Log\LogLevel::INFO,
                            sprintf(
                                'Cleared varnish cache for page %s. Triggered by clearCachePageList.',
                                $pid
                            )
                        );
                    }
                }
            }


        } catch (\Exception $e) {
            $this->getLogger()->log(
                \TYPO3\CMS\Core\Log\LogLevel::ERROR,
                sprintf('Cannot clear cache. Reason: %s', $e->getMessage())
            );
        }

    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger(): Logger
    {
        return GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }


    /**
     * Return TS-Settings for given pid
     *
     * @param int $pageId
     * @return array
     * @throws \Exception
     */
    private function getTsForPage(int $pageId): array
    {
        /** @var \TYPO3\CMS\Core\TypoScript\TemplateService $template */
        $template = GeneralUtility::makeInstance(TemplateService::class);
        $template->tt_track = 0;

        /** @var array $rootLine */
        $rootLine = GeneralUtility::makeInstance(RootlineUtility::class, intval($pageId))->get();
        $template->runThroughTemplates($rootLine, 0);
        $template->generateConfig();

        return $template->setup['module.']['tx_rkwtools.']['settings.'];
    }
}
