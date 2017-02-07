<?php

namespace StudentsSearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Student
 *
 * @ORM\Table(name="student")
 * @ORM\Entity(repositoryClass="StudentsSearchBundle\Repository\StudentRepository")
 */
class Student {

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
     * 
     * @ORM\ManyToOne(targetEntity="District", inversedBy="students")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id")
     */
    private $district;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="County", inversedBy="students")
     * @ORM\JoinColumn(name="county_id", referencedColumnName="id")
     */
    private $county;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Community", inversedBy="students")
     * @ORM\JoinColumn(name="community_id", referencedColumnName="id")
     */
    private $community;

    /**
     *
     * @ORM\ManyToMany(targetEntity="StudentGroup", inversedBy="students")
     * @ORM\JoinTable(name="students_groups")
     */
    private $groups;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Student
     */
    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Student
     */
    public function setSurname($surname) {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname() {
        return $this->surname;
    }

    /**
     * Set community
     *
     * @param \StudentsSearchBundle\Entity\Community $community
     *
     * @return Student
     */
    public function setCommunity(\StudentsSearchBundle\Entity\Community $community = null) {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return \StudentsSearchBundle\Entity\Community
     */
    public function getCommunity() {
        return $this->community;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add group
     *
     * @param \StudentsSearchBundle\Entity\StudentGroup $group
     *
     * @return Student
     */
    public function addGroup(\StudentsSearchBundle\Entity\StudentGroup $group) {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \StudentsSearchBundle\Entity\StudentGroup $group
     */
    public function removeGroup(\StudentsSearchBundle\Entity\StudentGroup $group) {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups() {
        return $this->groups;
    }

    /**
     * Set district
     *
     * @param \StudentsSearchBundle\Entity\Community $district
     *
     * @return Student
     */
    public function setDistrict(\StudentsSearchBundle\Entity\Community $district = null) {
        $this->district = $district;

        return $this;
    }

    /**
     * Get district
     *
     * @return \StudentsSearchBundle\Entity\Community
     */
    public function getDistrict() {
        return $this->district;
    }

    /**
     * Set county
     *
     * @param \StudentsSearchBundle\Entity\Community $county
     *
     * @return Student
     */
    public function setCounty(\StudentsSearchBundle\Entity\Community $county = null) {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return \StudentsSearchBundle\Entity\Community
     */
    public function getCounty() {
        return $this->county;
    }

}
