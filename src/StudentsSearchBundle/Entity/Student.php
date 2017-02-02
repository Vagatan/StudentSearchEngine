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
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=255)
     */
    private $surname;

    /**
     * 
     * @ORM\ManyToOne(targetEntity="Community", inversedBy="students")
     * @ORM\JoinColumn(name="community_id", referencedColumnName="id")
     */
    private $community;
    /**
     *
     * @ORM\OneToMany(targetEntity="StudentGroup", mappedBy="student")
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
    public function setCommunity(\StudentsSearchBundle\Entity\Community $community = null)
    {
        $this->community = $community;

        return $this;
    }

    /**
     * Get community
     *
     * @return \StudentsSearchBundle\Entity\Community
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * Set group
     *
     * @param \StudentsSearchBundle\Entity\StudentGroup $group
     *
     * @return Student
     */
    public function setGroup(\StudentsSearchBundle\Entity\StudentGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \StudentsSearchBundle\Entity\StudentGroup
     */
    public function getGroup()
    {
        return $this->group;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groups = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add group
     *
     * @param \StudentsSearchBundle\Entity\StudentGroup $group
     *
     * @return Student
     */
    public function addGroup(\StudentsSearchBundle\Entity\StudentGroup $group)
    {
        $this->groups[] = $group;

        return $this;
    }

    /**
     * Remove group
     *
     * @param \StudentsSearchBundle\Entity\StudentGroup $group
     */
    public function removeGroup(\StudentsSearchBundle\Entity\StudentGroup $group)
    {
        $this->groups->removeElement($group);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroups()
    {
        return $this->groups;
    }
}
