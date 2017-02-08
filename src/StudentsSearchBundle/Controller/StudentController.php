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
     * @Route("/all", name="show_all")
     * @Template
     */
    public function studentMainAction() {
        $studentRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Student");

        $students = $studentRepo->findAll();

        return ["students" => $students];
    }

    /**
     * @Route("/search", name="county_list")
     * 
     * @return Response
     */
    public function countyAjaxAction(Request $request) {

        $form = $this->createForm("StudentsSearchBundle\Form\Type\StudentType");
        $studentRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Student");
        $districtRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:District");
        $countyRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:County");
        $communityRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Community");
        if ($request->isXmlHttpRequest()) {
            if ($request->request->get("district_id")) {
                $data = $request->request->get("district_id");
                $counties = $countyRepo->findBy(["district" => $data]);
                $count = [];
                foreach ($counties as $county) {
                    $count[] = ["id" => $county->getId(), "name" => $county->getName()];
                }
                return new JsonResponse(["counties" => $count]);
            }
            if ($request->request->get("county_id")) {
                $countyData = $request->request->get("county_id");
                $communities = $communityRepo->findBy(["county" => $countyData]);
                $comm = [];
                foreach ($communities as $community) {
                    $comm[] = ["id" => $community->getId(), "name" => $community->getName()];
                }
                return new JsonResponse(["community" => $comm]);
            }
        }
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $student = $form->getData();
            $studentName = $student["name"];
            if (isset($student["district"])) {
                $studentName = $student["name"];
                $studentDistrict = $student["district"];
                $findDistrict = $districtRepo->find($studentDistrict);
                $students = $studentRepo->findByDistrict($studentName, $findDistrict);

                return $this->render("StudentsSearchBundle:Student:showAll.html.twig", ["students" => $students, "form" => $form->createView()]);
            }
            if (isset($student["county"])) {
                $studentName = $student["name"];
                $studentDistrict = $student["district"];
                $studentCounty = $student["county"];
                $findDistrict = $districtRepo->find($studentDistrict);
                $findCounty = $countyRepo->find($studentCounty);
                $students = $studentRepo->findByDistrict($studentName, $findDistrict, $findCounty);

                return $this->render("StudentsSearchBundle:Student:showAll.html.twig", ["students" => $students, "form" => $form->createView()]);
            }
            if (isset($student["community"])) {
                $studentName = $student["name"];
                $studentDistrict = $student["district"];
                $studentCounty = $student["county"];
                $studentCommunity = $student["community"];
                $findDistrict = $districtRepo->find($studentDistrict);
                $findCounty = $countyRepo->find($studentCounty);
                $findCommunity = $communityRepo->find($studentCommunity);
                $students = $studentRepo->findByDistrict($studentName, $findDistrict, $findCounty, $findCommunity);

                return $this->render("StudentsSearchBundle:Student:showAll.html.twig", ["students" => $students, "form" => $form->createView()]);
            }

            $students = $studentRepo->findByName($studentName);
            return $this->render("StudentsSearchBundle:Student:showAll.html.twig", ["students" => $students, "form" => $form->createView()]);
        }
        return $this->render("StudentsSearchBundle:Student:newStudent.html.twig", ["form" => $form->createView()]);
    }

}
