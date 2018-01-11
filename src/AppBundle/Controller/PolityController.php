<?php
/**
 * Class PolityController | AppBundle/Controller/PolityController.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\PolityType;
use AppBundle\Entity\Polity;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("polity")
*/
class PolityController extends Controller
{
    const LIMIT_PAGINATION = 5;

    /**
      * List Polity
      *
      * @Route("/list/{page}", name="polity_list")
      * @Method({"GET", "POST"})
      * @param integer $page The current page passed via URL
      */
    public function listPolityAction($page = 1)
    {
        $polity = new Polity();
        $em = $this->getDoctrine()->getManager();
        $polities = $em->getRepository('AppBundle:Polity')->getAllPolities($page, self::LIMIT_PAGINATION);

        $totalPolities = $polities->count();
        $iterator = $polities->getIterator();

        $maxPages = ceil($totalPolities / self::LIMIT_PAGINATION);
        $thisPage = $page;

        $form = $this->createForm(PolityType::class, $polity);
        return $this->render('admin/polity/listPolity.html.twig', array(
                                            'polities' => $iterator,
                                            'maxPages'  => $maxPages,
                                            'thisPage'  => $thisPage,
                                            'totalPolities' => $totalPolities,
                                            'form'      => $form->createView()));
    }


    /**
     * Delete Polity
     * @Route("/delete-polity", name="polity_delete")
     * @Method("GET")
     */
    public function deletePolity(Request $request)
    {
        $em = $this->getDoctrine()->getmanager();
        $polity = $em->getRepository('AppBundle:Polity')->findOneById($request->get('id'));
        if (!$polity) {
            $result = '{"result":"error", "message": "This polity does not exist."}';
        } else {
            $em->remove($polity);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }


    /**
     * Add Polity
     * @Route("/add-polity", name="polity_add")
     * @Method({"GET", "POST"})
     */
    public function addPolity(Request $request)
    {
        $name         = $request->get('name');
        $description  = $request->get('description');
        $dayStart     = $request->get('dayStart');
        $monthStart   = $request->get('monthStart');
        $yearStart    = $request->get('yearStart');
        $dayEnd       = $request->get('dayEnd');
        $monthEnd     = $request->get('monthEnd');
        $yearEnd      = $request->get('yearEnd');

        $polity = new Polity();


        $validator = $this->get('validator');
        $errors = $validator->validate($polity);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            $result = '{"result":"error", "message": "This Polity is already added."}';
        } else {
                $polity->setName($name);
                $polity->setDescription($description);
                $polity->setDayStart($dayStart);
                $polity->setMonthStart($monthStart);
                $polity->setYearStart($yearStart);
                $polity->setDayEnd($dayEnd);
                $polity->setMonthEnd($monthEnd);
                $polity->setYearEnd($yearEnd);

                $em = $this->getDoctrine()->getManager();
                $em->persist($polity);
                $em->flush();
                $result = '{"result":"ok"}';

        }
        return new JsonResponse($result);
    }
}
