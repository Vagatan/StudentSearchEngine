<?php

namespace StudentsSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class StudentGroupController extends Controller {

    /**
     * @Route("/groups", name="student_groups")
     * @Template
     */
    public function showAllGroupsAction() {
        $groupRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:StudentGroup");
        $groups = $groupRepo->findAll();
        return ["groups" => $groups];
    }

    /**
     * @Route("/addToStorage/{studentId}", name="student_add_to_storage")
     */
    public function addToStorageAction(Request $request, $studentId) {


        if (!empty($request->getSession()->get("student_group"))) {
            $studentsInGroup = $request->getSession()->get("student_group");
            if (in_array($studentId, $studentsInGroup)) {
                $request->getSession()
                        ->getFlashBag()
                        ->add("student_exist", "Wybierz innego studenta");
                return $this->redirect($request->headers->get("referer"));
            }
            $studentsInGroup[] = $studentId;
            $request->getSession()->set("student_group", $studentsInGroup);
        } else {
            $studentsInGroup[] = $studentId;
            $request->getSession()->set("student_group", $studentsInGroup);
        }
        return $this->redirect($request->headers->get("referer"));
    }

    /**
     * @Route("/add_to_group/{groupId}", name="add_to_group")
     * @Template
     */
    public function addFromStorageToGroupAction(Request $request, $groupId) {

        $studentRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Student");
        $groupRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:StudentGroup");
        $addedGroup = $groupRepo->find($groupId);
        foreach ($request->getSession()->get("student_group") as $studentId) {

            $student = $studentRepo->find($studentId);
            $student->addGroup($addedGroup);
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);

//                    $request->getSession()
//                            ->getFlashBag()
//                            ->add("student_in_group", "Wybrany student jest już w tej grupie");
//                    return $this->redirect($request->headers->get("referer"));
        }
        $em->flush();
        $request->getSession()->clear();
        return $this->redirect($request->headers->get("referer"));
    }

    /**
     * @Route("/clear_storage", name="clear")
     */
    public function clearStorageAction(Request $request) {
        $request->getSession()->clear();
        return $this->redirect($request->headers->get("referer"));
    }

}
