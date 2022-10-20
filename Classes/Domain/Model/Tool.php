<?php

namespace RKW\RkwTools\Domain\Model;
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
 * Class Tool
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tool extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * crdate
     *
     * @var int
     */
    protected $crdate;

    /**
     * tstamp
     *
     * @var int
     */
    protected $tstamp;

    /**
     * name
     *
     * @var string
     */
    protected $name;

    /**
     * description
     *
     * @var string
     */
    protected $description;

    /**
     * type
     *
     * @var \RKW\RkwTools\Domain\Model\ToolType
     */
    protected $type;

    /**
     * link
     *
     * @var string
     */
    protected $link;

    /**
     * image
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $image;

    /**
     * sysCategory
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\Category>
     */
    protected $sysCategory;

    /**
     * projects
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwProjects\Domain\Model\Projects>
     */
    protected $projects;

    /**
     * department
     *
     * @var \RKW\RkwBasics\Domain\Model\Department
     */
    protected $department;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->sysCategoryParent = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->sysCategory = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->projects = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the crdate
     *
     * @return int $crdate
     */
    public function getCrdate()
    {
        return $this->crdate;
    }

    /**
     * Returns the tstamp
     *
     * @return int $tstamp
     */
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Returns the type
     *
     * @return \RKW\RkwTools\Domain\Model\ToolType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param \RKW\RkwTools\Domain\Model\ToolType $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the link
     *
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Sets the link
     *
     * @param string $link
     * @return void
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $image)
    {
        $this->image = $image;
    }

    /**
     * Adds a sysCategory
     *
     * @param \RKW\RkwBasics\Domain\Model\Category $sysCategory
     * @return void
     */
    public function addSysCategory(\RKW\RkwBasics\Domain\Model\Category $sysCategory)
    {
        $this->sysCategory->attach($sysCategory);
    }

    /**
     * Removes a sysCategory
     *
     * @param \RKW\RkwBasics\Domain\Model\Category $sysCategoryToRemove The Question to be removed
     * @return void
     */
    public function removeSysCategory(\RKW\RkwBasics\Domain\Model\Category $sysCategoryToRemove)
    {
        $this->sysCategory->detach($sysCategoryToRemove);
    }

    /**
     * Returns the sysCategory
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\Category> $sysCategory
     */
    public function getSysCategory()
    {
        return $this->sysCategory;
    }

    /**
     * Sets the sysCategory
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\Category> $sysCategory
     * @return void
     */
    public function setSysCategory(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $sysCategory)
    {
        $this->sysCategory = $sysCategory;
    }

    /**
     * Returns the department
     *
     * @return \RKW\RkwBasics\Domain\Model\Department department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Sets the department
     *
     * @param string $department
     * @return void
     */
    public function setDepartment($department)
    {
        $this->department = $department;
    }

    /**
     * Adds a projects
     *
     * @param \RKW\RkwProjects\Domain\Model\Projects $projects
     * @return void
     */
    public function addProjects(\RKW\RkwProjects\Domain\Model\Projects $projects)
    {
        $this->projects->attach($projects);
    }

    /**
     * Removes a projects
     *
     * @param \RKW\RkwProjects\Domain\Model\Projects $projectsToRemove The Question to be removed
     * @return void
     */
    public function removeProjects(\RKW\RkwProjects\Domain\Model\Projects $projectsToRemove)
    {
        $this->projects->detach($projectsToRemove);
    }

    /**
     * Returns the projects
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwProjects\Domain\Model\Projects> $projects
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * Sets the projects
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwProjects\Domain\Model\Projects> $projects
     * @return void
     */
    public function setProjects(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $projects)
    {
        $this->projects = $projects;
    }
}
