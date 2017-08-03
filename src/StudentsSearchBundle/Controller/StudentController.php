<?php

namespace StudentsSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller {

    /**
     * Searching students by selected criteria
     * 
     * @Route("/", name="student_search")
     * 
     * @return Response
     */
    public function searchAjaxAction(Request $request) {
        $form = $this->createForm("StudentsSearchBundle\Form\Type\StudentType");
        $studentRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Student");
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $studentName = $student["name"];
            if (isset($student["community"])) {
                $studentCommunity = $student["community"];
                $students = $studentRepo->findByCommunity($studentName, $studentCommunity);
            } else if (isset($student["county"])) {
                $studentCounty = $student["county"];
                $students = $studentRepo->findByCounty($studentName, $studentCounty);
            } else if (isset($student["district"])) {
                $studentDistrict = $student["district"];
                $students = $studentRepo->findByDistrict($studentName, $studentDistrict);
            } else {
                $students = $studentRepo->findByName($studentName);
            }return $this->render("StudentsSearchBundle:Student:newSearch.html.twig", ["students" => $students, "form" => $form->createView()]);
        }
        return $this->render("StudentsSearchBundle:Student:newSearch.html.twig", ["form" => $form->createView()]);
    }

    /**
     * Receiving AJAX and sending to form county listy for selected district
     * 
     * @Route("/county", name="select_county")
     * @return JsonResponse
     */
    public function selectCountyAjaxAction(Request $request) {
        $countyRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:County");
        if ($request->isXmlHttpRequest()) {
            if ($request->request->get("district_id")) {
                $data = $request->request->get("district_id");
                $counties = $countyRepo->findBy(["district" => $data]);
                $countiesFromDistrict = [];
                foreach ($counties as $county) {
                    $countiesFromDistrict[] = ["id" => $county->getId(), "name" => $county->getName()];
                }
                return new JsonResponse(["counties" => $countiesFromDistrict]);
            }
        }
    }

    /**
     * Receiving AJAX and sending to form community list for selected county
     * 
     * @Route("/community", name="select_community")
     * @return JsonResponse
     */
    public function selectCommunityAjaxAction(Request $request) {
        $communityRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Community");
        if ($request->isXmlHttpRequest()) {
            if ($request->request->get("county_id")) {
                $countyData = $request->request->get("county_id");
                $communities = $communityRepo->findBy(["county" => $countyData]);
                $communitiesFromCounty = [];
                foreach ($communities as $community) {
                    $communitiesFromCounty[] = ["id" => $community->getId(), "name" => $community->getName()];
                }
                return new JsonResponse(["community" => $communitiesFromCounty]);
            }
        }
    }

}
