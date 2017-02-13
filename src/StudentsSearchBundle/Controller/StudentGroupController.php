<?php

namespace StudentsSearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class StudentGroupController extends Controller {

    /**
     * Showing list of all groups
     * 
     * @Route("/groups", name="all_groups")
     */
    public function showAllAction() {
        $groupRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:StudentGroup");
        $groups = $groupRepo->findAll();
        return $this->render("StudentsSearchBundle:StudentGroup:showAll.html.twig", ["groups" => $groups]);
    }

    /**
     * Sending all groups to menu twig
     * 
     * @Route("/group_menu", name="groups_in_menu")
     */
    public function menuAction() {
        $groupRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:StudentGroup");
        $groups = $groupRepo->findAll();
        return $this->render("StudentsSearchBundle:StudentGroup:menu.html.twig", ["groups" => $groups]);
    }

    /**
     * Showing selected group
     * 
     * @Route("/groups/{groupId}", name="chosen_group")
     */
    public function showChosenGroupAction($groupId) {
        $groupRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:StudentGroup");
        $group = $groupRepo->find($groupId);
        return $this->render("StudentsSearchBundle:StudentGroup:showChosenGroup.html.twig", ["group" => $group]);
    }

    /**
     * Receiving AJAX and adding students to clipboard
     * 
     * @Route("/addToStorage", name="added_to_storage")
     * 
     * @return Response
     */
    public function addToStorageAjaxAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
            $studentId = $request->request->get("studentId");
            if (!empty($request->getSession()->get("student_group"))) {
                $studentsInGroup = $request->getSession()->get("student_group");
                if (in_array($studentId, $studentsInGroup)) {
                    $request->getSession()
                            ->getFlashBag()
                            ->add("student_exist", "Wybierz innego studenta");
                    return new JsonResponse();
                }
                $studentsInGroup[] = $studentId;
                $request->getSession()->set("student_group", $studentsInGroup);
            } else {
                $studentsInGroup[] = $studentId;
                $request->getSession()->set("student_group", $studentsInGroup);
            }
            return new JsonResponse();
        }
    }

    /**
     * Adding students to selected group and removing added ones from clipboard
     * 
     * @Route("/add_to_group/{groupId}", name="add_to_group")
     * @Template
     */
    public function addFromStorageToGroupAction(Request $request, $groupId) {
        $studentRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Student");
        $groupRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:StudentGroup");
        $addedGroup = $groupRepo->find($groupId);
        $session = $request->getSession()->get("student_group");
        foreach ($session as $studentId) {
            $student = $studentRepo->find($studentId);
            if (!$student->getGroups()->contains($addedGroup)) {
                $student->addGroup($addedGroup);
                $em = $this->getDoctrine()->getManager();
                $em->persist($student);
                $em->flush();
                $removeId = array_search($studentId, $session);
                unset($session[$removeId]);
            } else {
                $request->getSession()
                        ->getFlashBag()
                        ->add("student_in_group", $student->getName() . " jest już w tej grupie");                
            }
        } 
        $request->getSession()->set("student_group", $session);
        return $this->redirect($request->headers->get("referer"));
    }

    /**
     * Clearing clipboard by link
     * 
     * @Route("/clear_storage", name="clear")
     */
    public function clearStorageAction(Request $request) {
        $request->getSession()->clear();
        return $this->redirect($request->headers->get("referer"));
    }

    /**
     * Receiving AJAX and clearing clipboard
     * 
     * @Route("/cleartest", name="cleartest")
     */
    public function clearAjaxAction(Request $request) {
        $request->getSession()->clear();
        return new JsonResponse();
    }

    /**
     * Showing all students in clipboard (in button)
     * 
     * @Route("/storage", name="storage_preview")
     */
    public function showStorageAction(Request $request) {
        $studentRepo = $this->getDoctrine()->getManager()->getRepository("StudentsSearchBundle:Student");
        $students = [];
        foreach ($request->getSession()->get("student_group") as $studentId) {
            $students[] = $studentRepo->find($studentId);
        }
        return $this->render("StudentsSearchBundle:StudentGroup:showStorage.html.twig", ["students" => $students]);
    }

}
