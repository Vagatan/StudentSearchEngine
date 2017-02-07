<?php

namespace StudentsSearchBundle\Controller;

use StudentsSearchBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller {

    /**
     * @Route("/search_test", name="student_finder")
     * 
     */
    public function selectAction(Request $request) {

        $form = $this->createFormBuilder()
                //->setAction("search")
                ->add("name", TextType::class, ["label" => "Nazwisko"])
                ->add("district", EntityType::class, ["label" => "District", "class" => "StudentsSearchBundle:District", "choice_label" => "name"])
                ->add("county", EntityType::class, ["label" => "County", "class" => "StudentsSearchBundle:County", "choice_label" => "name"])
                //->add("community", EntityType::class, ["label" => "Community", "class" => "StudentsSearchBundle:Community", "choice_label" => "name"])
                ->add("Szukaj", SubmitType::class)
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $studentName = $form->get("name")->getData();

            $students = $em->getRepository("StudentsSearchBundle:Student")->findByName($studentName);


            return $this->render("StudentsSearchBundle:Student:showAll.html.twig", ["students" => $students]);
        }

        return $this->render("StudentsSearchBundle:Student:newStudent.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/form")
     */
    public function formTestAction() {
        $student = new Student();
        $form = $this->createForm("StudentsSearchBundle\Form\Type\StudentType", $student);
        return $this->render("StudentsSearchBundle:Student:newStudent.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/main", name="show_all")
     * @Template
     */
    public function studentMainAction() {
        $studentRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Student");

        $students = $studentRepo->findAll();

        return ["students" => $students];
    }

    /**
     * @Route("/county", name="county_list")
     */
    public function countyAjaxAction(Request $request) {

        $form = $this->createForm("StudentsSearchBundle\Form\Type\StudentType");
        if ($request->isXmlHttpRequest()) {
            if ($request->request->get("district_id")) {
                $data = $request->request->get("district_id");
                $repoCounty = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:County");    
                $counties = $repoCounty->findBy(["district" => $data]);
                $count = [];
                foreach ($counties as $county) {
                    $count[] = ["id" => $county->getId(), "name" => $county->getName()];
                }
                return new JsonResponse(["counties" => $count]);
            }
            if ($request->request->get("county_id")) {
                $countyData = $request->request->get("county_id");
                $repoCommunity = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Community");
                $communities = $repoCommunity->findBy(["county" => $countyData]);
                $comm = [];
                foreach ($communities as $community) {
                    $comm[] = ["id" => $community->getId(), "name" => $community->getName()];
                }
                return new JsonResponse(["community" => $comm]);
            }
        } return $this->render("StudentsSearchBundle:Student:newStudent.html.twig", ["form" => $form->createView()]);
    }

}
