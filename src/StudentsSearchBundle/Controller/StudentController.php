<?php

namespace StudentsSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller {

    /**
     * Ugly function which search students
     * 
     * @Route("/search", name="student_search")
     * 
     * @return Response
     */
    public function searchAjaxAction(Request $request) {

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
                $studentDistrict = $student["district"];
                $findDistrict = $districtRepo->find($studentDistrict);
                $students = $studentRepo->findByDistrict($studentName, $findDistrict);
                return $this->render("StudentsSearchBundle:Student:newSearch.html.twig", ["students" => $students, "form" => $form->createView()]);
            }
            if (isset($student["county"])) {
                $studentCounty = $student["county"];
                $findCounty = $countyRepo->find($studentCounty);
                $students = $studentRepo->findByDistrict($studentName, $findCounty);
                return $this->render("StudentsSearchBundle:Student:newSearch.html.twig", ["students" => $students, "form" => $form->createView()]);
            }
            if (isset($student["community"])) {
                $studentCommunity = $student["community"];                
                $findCommunity = $communityRepo->find($studentCommunity);
                $students = $studentRepo->findByDistrict($studentName, $findCommunity);
                return $this->render("StudentsSearchBundle:Student:newSearch.html.twig", ["students" => $students, "form" => $form->createView()]);
            }
            $students = $studentRepo->findByName($studentName);
            return $this->render("StudentsSearchBundle:Student:newSearch.html.twig", ["students" => $students, "form" => $form->createView()]);
        }
        return $this->render("StudentsSearchBundle:Student:newSearch.html.twig", ["form" => $form->createView()]);
    }

}
