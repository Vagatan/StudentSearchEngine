<?php

namespace StudentsSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StudentController extends Controller {

    /**
     * @Route("/students_search", name="students")
     * @Template
     */
    public function showAllAction() {
        
    }

}
