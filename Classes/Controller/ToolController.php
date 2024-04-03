<?php
namespace RKW\RkwTools\Controller;
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

use \RKW\RkwBasics\Domain\Model\Department;
use \RKW\RkwBasics\Domain\Model\Category;
use RKW\RkwBasics\Domain\Repository\CategoryRepository;
use RKW\RkwBasics\Domain\Repository\DepartmentRepository;
use \RKW\RkwProjects\Domain\Model\Projects;
use RKW\RkwProjects\Domain\Repository\ProjectsRepository;
use RKW\RkwTools\Domain\Repository\ToolRepository;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Class ToolController
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since TYPO3 9.5. This extension is going to be replaced by a new shop
 */
class ToolController extends \Madj2k\AjaxApi\Controller\AjaxAbstractController
{
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface<\RKW\RkwTools\Domain\Model\Tool>|null
     */
    protected ?QueryResultInterface $toolList = null;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface<\RKW\RkwBasics\Domain\Model\Department>|null
     */
    protected ?QueryResultInterface $departmentList = null;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface<\RKW\RkwBasics\Domain\Model\Category>|null
     */
    protected ?QueryResultInterface $categoryList = null;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\QueryResultInterface<\RKW\RkwProjects\Domain\Model\Projects>|null
     */
    protected ?QueryResultInterface $projectsList = null;


    /**
     * @var int
     */
    protected int $fullResultCount = 0;


    /**
     * @var string
     */
    protected string $cacheIdentifier = '';


    /**
     * @var \RKW\RkwTools\Domain\Repository\ToolRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected ToolRepository $toolRepository;


    /**
     * @var \RKW\RkwBasics\Domain\Repository\DepartmentRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected DepartmentRepository $departmentRepository;


    /**
     * @var \RKW\RkwBasics\Domain\Repository\CategoryRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected CategoryRepository $categoryRepository;


    /**
     * @var \RKW\RkwProjects\Domain\Repository\ProjectsRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected ProjectsRepository $projectsRepository;


    /**
     * @var \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface|null
     */
    protected ?FrontendInterface $cacheManager = null;


    /**
     * @var \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer|null
     */
    protected ?ContentObjectRenderer $cObj = null;


    /**
     * action initialize
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    public function initializeAction()
    {
        $this->cacheManager = GeneralUtility::makeInstance(CacheManager::class)->getCache('rkw_tools');
        // @extensionScannerIgnoreLine
        $this->cObj = $this->configurationManager->getContentObject();
    }


    /**
     * action list
     *
     * @param \RKW\RkwBasics\Domain\Model\Department|null $department
     * @param \RKW\RkwBasics\Domain\Model\Category|null $category
     * @param \RKW\RkwProjects\Domain\Model\Projects|null $projects
     * @param int $pageNumber
     * @param int $ttContentUid
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation("projects")
     */
    public function listAction(
        Department $department = null,
        Category $category = null,
        Projects $projects = null,
        int $pageNumber = 0,
        int $ttContentUid = 0
    ): void {

        $pageNumber++;

        // for secure after @TYPO3\CMS\Extbase\Annotation\IgnoreValidation
        if (!$projects instanceof Projects) {
            $projects = null;
        }

        // Attention: Following line doesn't work in ajax-context (return PID instead of plugins content element uid)
        if (!$ttContentUid) {
            $ttContentUid = $this->ajaxHelper->getContentUid();
        }

        // Current state: No caching if someone is filtering via frontend form
        $this->cacheIdentifier = intval($GLOBALS['TSFE']->id) . '_' . $ttContentUid . '_rkwtools_'
            . strtolower($this->request->getPluginName()) . '_' . intval($pageNumber);

        if (
            \TYPO3\CMS\Core\Core\Environment::getContext()->isProduction()
            && $this->cacheManager->has($this->cacheIdentifier . '_tool')
            && $this->cacheManager->has($this->cacheIdentifier . '_count')
            && $this->cacheManager->has($this->cacheIdentifier . '_department')
            && $this->cacheManager->has($this->cacheIdentifier . '_category')
            && $this->cacheManager->has($this->cacheIdentifier . '_projects')
            && !$department
            && !$category
            && !$projects
            && !$this->settings['noCache']
        ) {
            // Cache exists
            $this->toolList = $this->cacheManager->get($this->cacheIdentifier . '_tool');
            $this->fullResultCount = $this->cacheManager->get($this->cacheIdentifier . '_count');
            $this->departmentList = $this->cacheManager->get($this->cacheIdentifier . '_department');
            $this->categoryList = $this->cacheManager->get($this->cacheIdentifier . '_category');
            $this->projectsList = $this->cacheManager->get($this->cacheIdentifier . '_projects');

        } else {
            $this->toolList = $this->toolRepository->findByFilterAndConfiguration(
                $department,
                $this->categoryRepository->findOneWithAllRecursiveChildren($category),
                $projects,
                $pageNumber,
                $this->settings
            );

            $this->fullResultCount = count($this->toolRepository->findByFilterAndConfiguration(
                $department,
                $this->categoryRepository->findOneWithAllRecursiveChildren($category),
                $projects,
                0,
                $this->settings
            ));

            $this->departmentList = $this->departmentRepository->findAllByVisibility();

            $this->categoryList = $this->categoryRepository->findAllOrRecursiveBySelection(
                array_map('trim', explode(',', $this->settings['sysCategoryList'])),
                false,
                true
            );

            $this->projectsList = $this->projectsRepository->findByVisibilityAndSelection(
                array_map('trim', explode(',', $this->settings['projectsList']))
            );

            // cache it for the next time!
            $this->cacheResults();
        }

        $showMoreLink = ($pageNumber * $this->settings['itemsPerPage']) < $this->fullResultCount;

        // 4. Set replacements for view
        $replacements = [
            'selectedDepartment' => $department,
            'selectedCategory'   => $category,
            'selectedProjects'   => $projects,
            'pageNumber'         => $pageNumber,
            'showMoreLink'       => $showMoreLink,
            'toolList'           => $this->toolList,
            'departmentList'     => $this->departmentList,
            'categoryList'       => $this->categoryList,
            'projectsList'       => $this->projectsList,
        ];


        $this->view->assignMultiple($replacements);
    }


    /**
     * cacheResults
     * to relieve the list function
     *
     * @return void
     */
    protected function cacheResults()
    {
        if (count($this->toolList) > 0) {
            $cacheTtl = $this->settings['cache']['ttl'] ? $this->settings['cache']['ttl'] : 86400;
            // Tools
            $this->cacheManager->set(
                $this->cacheIdentifier . '_tool',
                $this->toolList,
                array(
                    'tx_rkwtools',
                    'tx_rkwtools' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview',
                    'tx_rkwtools_overview' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()) . '_' . intval($GLOBALS['TSFE']->id),
                ),
                $cacheTtl
            );

            // Full result count
            $this->cacheManager->set(
                $this->cacheIdentifier . '_count',
                $this->fullResultCount,
                array(
                    'tx_rkwtools',
                    'tx_rkwtools' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview',
                    'tx_rkwtools_overview' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()) . '_' . intval($GLOBALS['TSFE']->id),
                ),
                $cacheTtl
            );

            // Department
            $this->cacheManager->set(
                $this->cacheIdentifier . '_department',
                $this->departmentList,
                array(
                    'tx_rkwtools',
                    'tx_rkwtools' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview',
                    'tx_rkwtools_overview' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()) . '_' . intval($GLOBALS['TSFE']->id),
                ),
                $cacheTtl
            );

            // Department
            $this->cacheManager->set(
                $this->cacheIdentifier . '_category',
                $this->categoryList,
                array(
                    'tx_rkwtools',
                    'tx_rkwtools' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview',
                    'tx_rkwtools_overview' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()) . '_' . intval($GLOBALS['TSFE']->id),
                ),
                $cacheTtl
            );

            // Projects
            $this->cacheManager->set(
                $this->cacheIdentifier . '_projects',
                $this->projectsList,
                array(
                    'tx_rkwtools',
                    'tx_rkwtools' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview',
                    'tx_rkwtools_overview' . intval($GLOBALS['TSFE']->id),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()),
                    'tx_rkwtools_overview' . strtolower($this->request->getPluginName()) . '_' . intval($GLOBALS['TSFE']->id),
                ),
                $cacheTtl
            );
        }
    }
}
