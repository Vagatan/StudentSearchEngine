<?php

namespace StudentsSearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * District/Województwo
 *
 * @ORM\Table(name="district")
 * @ORM\Entity(repositoryClass="StudentsSearchBundle\Repository\DistrictRepository")
 */
class District
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @ORM\OneToMany(targetEntity="County", mappedBy="district")
     */
    private $counties;
    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="district")
     */
    private $students;
    


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return District
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->counties = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add county
     *
     * @param \StudentsSearchBundle\Entity\County $county
     *
     * @return District
     */
    public function addCounty(\StudentsSearchBundle\Entity\County $county)
    {
        $this->counties[] = $county;

        return $this;
    }

    /**
     * Remove county
     *
     * @param \StudentsSearchBundle\Entity\County $county
     */
    public function removeCounty(\StudentsSearchBundle\Entity\County $county)
    {
        $this->counties->removeElement($county);
    }

    /**
     * Get counties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCounties()
    {
        return $this->counties;
    }

    /**
     * Add community
     *
     * @param \StudentsSearchBundle\Entity\Community $community
     *
     * @return District
     */
    public function addCommunity(\StudentsSearchBundle\Entity\Community $community)
    {
        $this->communities[] = $community;

        return $this;
    }

    /**
     * Remove community
     *
     * @param \StudentsSearchBundle\Entity\Community $community
     */
    public function removeCommunity(\StudentsSearchBundle\Entity\Community $community)
    {
        $this->communities->removeElement($community);
    }

    /**
     * Get communities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommunities()
    {
        return $this->communities;
    }

    /**
     * Add student
     *
     * @param \StudentsSearchBundle\Entity\Student $student
     *
     * @return District
     */
    public function addStudent(\StudentsSearchBundle\Entity\Student $student)
    {
        $this->students[] = $student;

        return $this;
    }

    /**
     * Remove student
     *
     * @param \StudentsSearchBundle\Entity\Student $student
     */
    public function removeStudent(\StudentsSearchBundle\Entity\Student $student)
    {
        $this->students->removeElement($student);
    }

    /**
     * Get students
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudents()
    {
        return $this->students;
    }
}
