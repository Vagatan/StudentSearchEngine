<?php

namespace StudentsSearchBundle\Repository;

/**
 * StudentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByName($names){
       $query = $this->getEntityManager()->createQuery("
               SELECT student 
               FROM StudentsSearchBundle:Student student
               WHERE student.name LIKE :name
               ORDER BY student.name
               ")
               ->setParameter('name', $names."%")
               ->getResult();
       return $query;
   }
}
