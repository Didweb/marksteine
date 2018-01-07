<?php
/**
 * Class EraController | AppBundle/Controller/EraController.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\EraType;
use AppBundle\Entity\Era;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("era")
*/
class EraController extends Controller
{
    const LIMIT_PAGINATION = 5;

    /**
      * List Era
      *
      * @Route("/list/{page}", name="era_list")
      * @Method({"GET", "POST"})
      * @param integer $page The current page passed via URL
      */
    public function listEraAction($page = 1)
    {
        $era  = new Era();
        $em   = $this->getDoctrine()->getManager();
        $eras = $em->getRepository('AppBundle:Era')->getAllEras($page, self::LIMIT_PAGINATION);

        $totalEras = $eras->count();
        $iterator  = $eras->getIterator();

        $maxPages = ceil($totalEras / self::LIMIT_PAGINATION);
        $thisPage = $page;

        $form = $this->createForm(EraType::class, $era);
        return $this->render('admin/era/listEra.html.twig', array(
                                            'eras'      => $iterator,
                                            'maxPages'  => $maxPages,
                                            'thisPage'  => $thisPage,
                                            'totalEras' => $totalEras,
                                            'form'      => $form->createView()));
    }


    /**
     * Delete Era
     * @Route("/delete-era", name="era_delete")
     * @Method("GET")
     */
    public function deleteEra(Request $request)
    {
        $em = $this->getDoctrine()->getmanager();
        $era = $em->getRepository('AppBundle:Era')->findOneById($request->get('id'));
        if (!$era) {
            $result = '{"result":"error", "message": "This era does not exist."}';
        } else {
            $em->remove($era);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }


    /**
     * Edit Era
     * @Route("/edit-era", name="era_edit")
     * @Method({"GET", "POST"})
     */
    public function editEra(Request $request)
    {
        $em   = $this->getDoctrine()->getManager();
        $era = $em->getRepository('AppBundle:Era')->findOneById($request->get('id'));
        $form = $this->createForm(EraType::class, $era);

        return $this->render('admin/era/dialogEditEra.html.twig', array(
                                            'form_edit'      => $form->createView()));
    }


    /**
     * Edit Era
     * @Route("/edit-era-action", name="era_edit_action")
     * @Method({"GET", "POST"})
     */
    public function editActEra(Request $request)
    {
        $id   = $request->get('id');
        $name   = $request->get('name');
        $start  = $request->get('start');
        $end    = $request->get('end');

        $em   = $this->getDoctrine()->getManager();
        $era = $em->getRepository('AppBundle:Era')->findOneById($id);
        $era->setName($name);
        $era->setStart($start);
        $era->setEnd($end);


        if ($end <= $start) {
            $result = '{"result":"error", "message": "Start is greater than end or equal. It\'s not possible."}';
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($era);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }


    /**
     * Add Era
     * @Route("/add-era", name="era_add")
     * @Method({"GET", "POST"})
     */
    public function addEra(Request $request)
    {
        $era = new Era();
        $start = $request->get('start');
        $end = $request->get('end');

        $era->setName($request->get('name'));
        $era->setStart($start);
        $era->setEnd($end);

        $validator = $this->get('validator');
        $errors = $validator->validate($era);

        if (count($errors) > 0) {
            $message = "";
            foreach ($errors as $violation) {
                  $message = $violation->getMessage();
            }
            $result = '{"result":"error", "message": "'.$message.'"}';
        } elseif ($end <= $start) {
            $result = '{"result":"error", "message": "Start is greater than end or equal. It\'s not possible."}';
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($era);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }
}
