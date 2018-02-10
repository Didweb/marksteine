<?php
/**
 * Class TypeController | AppBundle/Controller/TypeController.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\TyMilestoneType;
use AppBundle\Entity\Type;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("admin/type")
*/
class TypeController extends Controller
{
    const LIMIT_PAGINATION = 10;

    /**
      * List Type
      *
      * @Route("/list/{page}", name="type_list")
      * @Method({"GET", "POST"})
      * @param integer $page The current page passed via URL
      */
    public function listTypeAction($page = 1)
    {
        $type = new Type();
        $em = $this->getDoctrine()->getManager();
        $types = $em->getRepository('AppBundle:Type')->getAllTypes($page, self::LIMIT_PAGINATION);

        $totalTypes = $types->count();
        $iterator = $types->getIterator();

        $maxPages = ceil($totalTypes / self::LIMIT_PAGINATION);
        $thisPage = $page;

        $form = $this->createForm(TyMilestoneType::class, $type);
        return $this->render('AppBundle::admin/type/listType.html.twig', array(
                                            'types'     => $iterator,
                                            'maxPages'  => $maxPages,
                                            'thisPage'  => $thisPage,
                                            'totalTypes'=> $totalTypes,
                                            'form'      => $form->createView()));
    }


    /**
     * Delete Type
     * @Route("/delete-type", name="type_delete")
     * @Method("GET")
     */
    public function deleteType(Request $request)
    {
        $em = $this->getDoctrine()->getmanager();
        $type = $em->getRepository('AppBundle:Type')->findOneById($request->get('id'));
        if (!$type) {
            $result = '{"result":"error", "message": "This type does not exist."}';
        } else {
            $em->remove($type);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }


    /**
     * Edit Type
     * @Route("/edit-type", name="type_edit")
     * @Method({"GET", "POST"})
     */
    public function editType(Request $request)
    {
        $em   = $this->getDoctrine()->getManager();
        $type = $em->getRepository('AppBundle:Type')->findOneById($request->get('id'));
        $form = $this->createForm(TyMilestoneType::class, $type);

        return $this->render('AppBundle::admin/type/dialogEditType.html.twig', array(
                                            'form_edit'      => $form->createView()));
    }


    /**
     * Edit Era
     * @Route("/edit-type-action", name="type_edit_action")
     * @Method({"GET", "POST"})
     */
    public function editActType(Request $request)
    {
        $id   = $request->get('id');
        $name   = $request->get('name');
        $color  = $request->get('color');

        $em   = $this->getDoctrine()->getManager();
        $type = $em->getRepository('AppBundle:Type')->findOneById($id);
        $type->setName($name);
        $type->setColor($color);
        if ($request->get('color')=="") {
            $result = '{"result":"error", "message": "The color field is required."}';
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }


    /**
     * Add Type
     * @Route("/add-type", name="type_add")
     * @Method({"GET", "POST"})
     */
    public function addType(Request $request)
    {
        $type = new Type();
        $type->setName($request->get('name'));
        $type->setColor($request->get('color'));

        $validator = $this->get('validator');
        $errors = $validator->validate($type);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            if ($request->get('color')=="") {
                $result = '{"result":"error", "message": "The color field is required."}';
            } else {
                $result = '{"result":"error", "message": "This type is already added."}';
            }
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($type);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }
}
