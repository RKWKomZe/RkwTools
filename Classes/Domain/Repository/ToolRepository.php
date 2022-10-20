<?php

namespace RKW\RkwTools\Domain\Repository;

use \RKW\RkwBasics\Domain\Model\Department;
use \RKW\RkwProjects\Domain\Model\Projects;
use \RKW\RkwBasics\Domain\Model\Category;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use \TYPO3\CMS\Extbase\Persistence\QueryInterface;
use \TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;

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
 * Class ToolRepository
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ToolRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{
    /**
     * Get tools with criteria from flexForm / plugin element filter options
     *
     * @param \RKW\RkwBasics\Domain\Model\Department $departmentFilter
     * @param \RKW\RkwBasics\Domain\Model\Category $categoryFilter
     * @param \RKW\RkwProjects\Domain\Model\Projects $projectsFilter
     * @param integer $pageNumber
     * @param array $typoScriptSettings
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByFilterAndConfiguration(Department $departmentFilter = null, Category $categoryFilter = null, Projects $projectsFilter = null, $pageNumber = 0, $typoScriptSettings)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $constraints = array();

        // If tools are pre-selected
        if (array_filter(GeneralUtility::trimExplode(',', $typoScriptSettings['toolList']))) {
            // simple fetch the defined tools
            $constraints[] = $query->in('uid', GeneralUtility::trimExplode(',', $typoScriptSettings['toolList']));
        } else {

            // department (from FE-filter, otherwise filter via flexForm settings)
            if ($departmentFilter instanceof Department) {
                $constraints[] = $query->equals('department', $departmentFilter->getUid());
            } else {
                if ($typoScriptSettings['departmentList']) {
                    $constraints[] = $query->in('department', GeneralUtility::trimExplode(',', $typoScriptSettings['departmentList']));
                }
            }

            // category (from FE-filter, otherwise filter via flexForm settings)
            // we always have to check, if the category itself is set, or it's parent
            // -> If a parent-category is selected for a tool, all the subcategories are searched with it
            if ($categoryFilter instanceof Category) {
                $constraints[] =
                    $query->logicalOr(
                        $query->contains('sysCategory', $categoryFilter),
                        $query->contains('sysCategory', $categoryFilter->getParent())
                    );
            } elseif (
                $categoryFilter instanceof ObjectStorage
                || is_array($categoryFilter)
            ) {
                $constraintsCategory = array();
                foreach ($categoryFilter as $category) {
                    $constraintsCategory[] =
                        $query->logicalOr(
                            $query->contains('sysCategory', $category),
                            $query->contains('sysCategory', $category->getParent())
                        );
                }
                $constraints[] = $query->logicalOr($constraintsCategory);
            } else {
                if (array_filter(GeneralUtility::trimExplode(',', $typoScriptSettings['sysCategoryList']))) {
                    /** @var \RKW\RkwBasics\Domain\Repository\CategoryRepository $sysCategoryRepository */
                    $sysCategoryRepository = GeneralUtility::makeInstance('RKW\\RkwBasics\\Domain\\Repository\\CategoryRepository');
                    $sysCategoryUidList = $sysCategoryRepository->findAllOrRecursiveBySelection(GeneralUtility::trimExplode(',', $typoScriptSettings['sysCategoryList']));
                    //$constraints[] = $query->in('sysCategory', $sysCategoryUidList);
                    // We want to compare a multi value array with a multi value database string. This does not work with $query->in()
                    if ($sysCategoryUidList) {
                        $constraintsCategory = array();
                        foreach ($sysCategoryUidList as $category) {
                            $constraintsCategory[] =
                                $query->logicalOr(
                                    $query->contains('sysCategory', $category),
                                    $query->contains('sysCategory', $category->getParent())
                                );
                        }
                        $constraints[] = $query->logicalOr($constraintsCategory);
                    }
                }
            }

            // projects (from FE-filter, otherwise filter via flexForm settings)
            if ($projectsFilter instanceof Projects) {
                $constraints[] = $query->contains('projects', $projectsFilter);
            } else {
                // We want to compare a multi value array with a multi value database string. This does not work with $query->in()
                if (array_filter(GeneralUtility::trimExplode(',', $typoScriptSettings['projectsList']))) {
                    $projectsList = array_filter(GeneralUtility::trimExplode(',', $typoScriptSettings['projectsList']));
                    $constraintsProjects = array();
                    foreach ($projectsList as $projects) {
                        $constraintsProjects[] = $query->contains('projects', $projects);
                    }
                    $constraints[] = $query->logicalOr($constraintsProjects);
                }
            }
        }

        // NOW: construct final query!
        if ($constraints) {
            $query->matching($query->logicalAnd($constraints));
        }

        /**
         * @todo not working with TYPO3 8.7 and above
         * @see https://stackoverflow.com/questions/56148787/typo3-9-5-custom-flexform-ordering-wrong-backquotes-in-sql
         */
        $currentVersion = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
        if ($currentVersion < 8000000) {

            // order by tool list orderings if is set, otherwise by crdate
            if ($typoScriptSettings['toolList']) {
                $query->setOrderings($this->orderByKey('uid', GeneralUtility::trimExplode(',', $typoScriptSettings['toolList'])));
            } else {
                $query->setOrderings(
                    array(
                        'crdate' => QueryInterface::ORDER_DESCENDING,
                    )
                );
            }
        } else {
            $query->setOrderings(
                array(
                    'crdate' => QueryInterface::ORDER_DESCENDING,
                )
            );
        }



        if ($pageNumber) {
            if ($pageNumber <= 1) {
                $query->setOffset(0);
            } else {
                $query->setOffset((intval($pageNumber) - 1) * intval($typoScriptSettings['itemsPerPage']));
            }
            $query->setLimit(intval($typoScriptSettings['itemsPerPage']));
        }

        return $query->execute();
        //====
    }


    /**
     * @param $key
     * @param $uidlist
     * @return array
     */
    protected function orderByKey($key, $uidlist)
    {
        $order = array();
        foreach ($uidlist as $uid) {
            $order["$key={$uid}"] = QueryInterface::ORDER_DESCENDING;
        }

        return $order;
        //===
    }
}
