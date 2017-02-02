<?php

namespace StudentsSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DistrictController extends Controller {

    /**
    * 
    * @Route("/district")
     * @Template
    */
    public function showAllAction() {
        $em = $this->getDoctrine()->getManager();

        $districts = $em->getRepository('StudentsSearchBundle:District')->findAll();

        return ["districts" => $districts];
    }

}
