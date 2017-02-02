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
     * @ORM\ManyToOne(targetEntity="County", inversedBy="communities")
     * @ORM\JoinColumn(name="county_id", referencedColumnName="id")
     */
    private $county;


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
}
