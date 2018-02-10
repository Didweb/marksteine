<?php
/**
 * Class AdminController | AppBundle/Controller/AdminController.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\MilestoneType;
use AppBundle\Entity\Milestone;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("admin")
*/
class AdminController extends Controller
{
    const LIMIT_PAGINATION = 10;

   /**
     * Index Admin_Aplication
     *
     * @Route("/", name="admin_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $countries = $em->getRepository('AppBundle:Country')->getCountCountries();

        $eras = $em->getRepository('AppBundle:Era')->getCountEras();
        $polities = $em->getRepository('AppBundle:Polity')->getCountPolities();
        $types = $em->getRepository('AppBundle:Type')->getCountTypeMilestones();

        return $this->render('AppBundle::admin/index.html.twig', array(
                                            'countries' => $countries,
                                            'eras'      => $eras,
                                            'polities'  => $polities,
                                            'types'     => $types,
                                              ));
    }


    /**
      * List Milestones
      *
      * @Route("/milestone/list/{page}", name="milestone_list")
      * @Method({"GET", "POST"})
      * @param integer $page The current page passed via URL
      */
    public function listMilestoneAction($page = 1)
    {
        $milestone = new Milestone();
        $em = $this->getDoctrine()->getManager();
        $milestones = $em->getRepository('AppBundle:Milestone')->getAllMilestones($page, self::LIMIT_PAGINATION);

        $totalMilestones = $milestones->count();
        $iterator = $milestones->getIterator();

        $maxPages = ceil($totalMilestones / self::LIMIT_PAGINATION);
        $thisPage = $page;

        $form = $this->createForm(MilestoneType::class, $milestone);
        return $this->render('AppBundle::admin/milestone/listMilestone.html.twig', array(
                                            'milestones'      => $iterator,
                                            'maxPages'        => $maxPages,
                                            'thisPage'        => $thisPage,
                                            'totalMilestones' => $totalMilestones,
                                            'form'            => $form->createView()));
    }


    /**
     * Delete Type
     * @Route("/milestone/delete-milestone", name="milestone_delete")
     * @Method("GET")
     */
    public function deleteMilestone(Request $request)
    {
        $em = $this->getDoctrine()->getmanager();
        $milestone = $em->getRepository('AppBundle:Milestone')->findOneById($request->get('id'));
        if (!$milestone) {
            $result = '{"result":"error", "message": "This Milestone does not exist."}';
        } else {
            $em->remove($milestone);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }


    /**
     * Edit milestone
     * @Route("/milestone/edit-milestone", name="milestone_edit")
     * @Method({"GET", "POST"})
     */
    public function editType(Request $request)
    {
        $em   = $this->getDoctrine()->getManager();
        $milestone = $em->getRepository('AppBundle:Milestone')->findOneById($request->get('id'));
        $form = $this->createForm(MilestoneType::class, $milestone);

        return $this->render('AppBundle::admin/milestone/dialogEditMilestone.html.twig', array(
                                            'form_edit'      => $form->createView()));
    }


    /**
     * Edit Milestone
     * @Route("/milestone/edit-milestone-action", name="milestone_edit_action")
     * @Method({"GET", "POST"})
     */
    public function editActMilestone(Request $request)
    {
        $id           = $request->get('id');
        $title        = $request->get('title');
        $description  = $request->get('description');
        $day          = $request->get('day');
        $month        = $request->get('month');
        $year         = $request->get('year');

        $em = $this->getDoctrine()->getManager();
        $milestone = $em->getRepository('AppBundle:Milestone')->findOneById($id);
        $milestone->setTitle($title);
        $milestone->setDescription($description);
        $milestone->setDay($day);
        $milestone->setMonth($month);
        $milestone->setYear($year);

        $em->persist($milestone);
        $em->flush();
        $result = '{"result":"ok"}';

        return new JsonResponse($result);
    }


    /**
     * Add Milestone
     * @Route("/milestone/add-milestone", name="milestone_add")
     * @Method({"GET", "POST"})
     */
    public function addMilestone(Request $request)
    {

        $title        = $request->get('title');
        $description  = $request->get('description');
        $day          = $request->get('day');
        $month        = $request->get('month');
        $year         = $request->get('year');

        $milestone = new Milestone();
        $milestone->setTitle($title);
        $milestone->setDescription($description);
        $milestone->setDay($day);
        $milestone->setMonth($month);
        $milestone->setYear($year);

        $validator = $this->get('validator');
        $errors = $validator->validate($milestone);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            $result = '{"result":"error", "message": "This Milestone is already added."}';
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($milestone);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }
}
