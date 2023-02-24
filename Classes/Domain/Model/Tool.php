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

use RKW\RkwBasics\Domain\Model\Category;
use RKW\RkwBasics\Domain\Model\Department;
use RKW\RkwProjects\Domain\Model\Projects;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Class Tool
 *
 * @author Maximilian Fäßler <maximilian@faesslerweb.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwTools
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated since TYPO3 9.5. This extension is going to be replaced by a new shop
 */
class Tool extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var int
     */
    protected int $crdate = 0;


    /**
     * @var int
     */
    protected int $tstamp = 0;


    /**
     * @var string
     */
    protected string $name = '';


    /**
     * @var string
     */
    protected string $description = '';


    /**
     * @var \RKW\RkwTools\Domain\Model\ToolType|null
     */
    protected ?ToolType $type = null;


    /**
     * @var string
     */
    protected string $link = '';


    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?FileReference $image = null;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\Category>|null
     */
    protected ?ObjectStorage $sysCategory = null;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\Category>|null
     */
    protected ?ObjectStorage $sysCategoryParent = null;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwProjects\Domain\Model\Projects>|null
     */
    protected ?ObjectStorage $projects = null;


    /**
     * @var \RKW\RkwBasics\Domain\Model\Department|null
     */
    protected ?Department $department = null;


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
     * @return int
     */
    public function getCrdate(): int
    {
        return $this->crdate;
    }


    /**
     * Returns the tstamp
     *
     * @return int
     */
    public function getTstamp(): int
    {
        return $this->tstamp;
    }


    /**
     * Returns the name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * Returns the description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    /**
     * Returns the type
     *
     * @return \RKW\RkwTools\Domain\Model\ToolType
     */
    public function getType():? ToolType
    {
        return $this->type;
    }


    /**
     * Sets the type
     *
     * @param \RKW\RkwTools\Domain\Model\ToolType $type
     * @return void
     */
    public function setType(ToolType $type): void
    {
        $this->type = $type;
    }


    /**
     * Returns the link
     *
     * @return string $link
     */
    public function getLink(): string
    {
        return $this->link;
    }


    /**
     * Sets the link
     *
     * @param string $link
     * @return void
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }


    /**
     * Returns the image
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getImage():? FileReference
    {
        return $this->image;
    }


    /**
     * Sets the image
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $image
     * @return void
     */
    public function setImage(FileReference $image): void
    {
        $this->image = $image;
    }


    /**
     * Adds a sysCategory
     *
     * @param \RKW\RkwBasics\Domain\Model\Category $sysCategory
     * @return void
     */
    public function addSysCategory(Category $sysCategory): void
    {
        $this->sysCategory->attach($sysCategory);
    }


    /**
     * Removes a sysCategory
     *
     * @param \RKW\RkwBasics\Domain\Model\Category $sysCategoryToRemove The Question to be removed
     * @return void
     */
    public function removeSysCategory(Category $sysCategoryToRemove): void
    {
        $this->sysCategory->detach($sysCategoryToRemove);
    }


    /**
     * Returns the sysCategory
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\Category> $sysCategory
     */
    public function getSysCategory(): ObjectStorage
    {
        return $this->sysCategory;
    }


    /**
     * Sets the sysCategory
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwBasics\Domain\Model\Category> $sysCategory
     * @return void
     */
    public function setSysCategory(ObjectStorage $sysCategory): void
    {
        $this->sysCategory = $sysCategory;
    }


    /**
     * Returns the department
     *
     * @return \RKW\RkwBasics\Domain\Model\Department department
     */
    public function getDepartment():? Department
    {
        return $this->department;
    }


    /**
     * Sets the department
     *
     * @param \RKW\RkwBasics\Domain\Model\Department $department
     * @return void
     */
    public function setDepartment(Department $department): void
    {
        $this->department = $department;
    }


    /**
     * Adds a projects
     *
     * @param \RKW\RkwProjects\Domain\Model\Projects $projects
     * @return void
     */
    public function addProjects(Projects $projects): void
    {
        $this->projects->attach($projects);
    }


    /**
     * Removes a projects
     *
     * @param \RKW\RkwProjects\Domain\Model\Projects $projectsToRemove The Question to be removed
     * @return void
     */
    public function removeProjects(Projects $projectsToRemove): void
    {
        $this->projects->detach($projectsToRemove);
    }


    /**
     * Returns the projects
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwProjects\Domain\Model\Projects> $projects
     */
    public function getProjects(): ObjectStorage
    {
        return $this->projects;
    }


    /**
     * Sets the projects
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwProjects\Domain\Model\Projects> $projects
     * @return void
     */
    public function setProjects(ObjectStorage $projects): void
    {
        $this->projects = $projects;
    }
}
