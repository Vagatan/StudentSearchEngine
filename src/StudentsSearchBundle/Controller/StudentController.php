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

            $students = $em->getRepository('StudentsSearchBundle:Student')->findByName($studentName);


            return $this->render("StudentsSearchBundle:Student:showAll.html.twig", ['students' => $students]);
        }

        return $this->render("StudentsSearchBundle:Student:newStudent.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/form")
     */
    public function formTestAction() {
        $student = new Student();
        $form = $this->createForm('StudentsSearchBundle\Form\Type\StudentType', $student);
        return $this->render("StudentsSearchBundle:Student:newStudent.html.twig", ["form" => $form->createView()]);
    }

    /**
     * @Route("/main", name="show_all")
     * @Template
     */
    public function studentMainAction() {
        $studentRepo = $this->getDoctrine()->getManager()->getRepository('StudentsSearchBundle:Student');

        $students = $studentRepo->findAll();

        return ["students" => $students];
    }

    

}
