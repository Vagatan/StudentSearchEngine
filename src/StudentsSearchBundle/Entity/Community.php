<?php

namespace StudentsSearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Community/Gmina
 *
 * @ORM\Table(name="community")
 * @ORM\Entity(repositoryClass="StudentsSearchBundle\Repository\CommunityRepository")
 */
class Community
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
     * @ORM\ManyToOne(targetEntity="District", inversedBy="communities")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     */
    private $district;
    
    /**
     * @ORM\ManyToOne(targetEntity="County", inversedBy="communities")
     * @ORM\JoinColumn(name="county_id", referencedColumnName="id")
     */
    private $county;
    
    
    
    /**
     * @ORM\OneToMany(targetEntity="Student", mappedBy="community")
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
     * @return Community
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
     * Set county
     *
     * @param \StudentsSearchBundle\Entity\County $county
     *
     * @return Community
     */
    public function setCounty(\StudentsSearchBundle\Entity\County $county = null)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return \StudentsSearchBundle\Entity\County
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set district
     *
     * @param \StudentsSearchBundle\Entity\District $district
     *
     * @return Community
     */
    public function setDistrict(\StudentsSearchBundle\Entity\District $district = null)
    {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return \StudentsSearchBundle\Entity\District
     */
    public function getDistrict()
    {
        return $this->district;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->students = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add student
     *
     * @param \StudentsSearchBundle\Entity\Student $student
     *
     * @return Community
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
