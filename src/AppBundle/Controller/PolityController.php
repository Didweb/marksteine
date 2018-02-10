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
use AppBundle\Entity\Country;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("admin/polity")
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
        return $this->render('AppBundle::admin/polity/listPolity.html.twig', array(
                                            'polities' => $iterator,
                                            'maxPages'  => $maxPages,
                                            'thisPage'  => $thisPage,
                                            'totalPolities' => $totalPolities,
                                            'form'      => $form->createView()));
    }

    /**
     * Edit Polity
     * @Route("/edit-polity", name="polity_edit")
     * @Method({"GET", "POST"})
     */
    public function editPolity(Request $request)
    {
        $em   = $this->getDoctrine()->getManager();
        $polity = $em->getRepository('AppBundle:Polity')->findOneById($request->get('id'));
        $form = $this->createForm(PolityType::class, $polity);

        return $this->render('AppBundle::admin/polity/dialogEditPolity.html.twig', array(
                                            'form_edit'      => $form->createView()));
    }



    /**
     * Edit Polity
     * @Route("/edit-polity-action", name="polity_edit_action")
     * @Method({"GET", "POST"})
     */
    public function editActPolity(Request $request)
    {
        $id          = $request->get('id');
        $name        = $request->get('name');
        $description = $request->get('description');
        $dayStart    = $request->get('dayStart');
        $dayEnd      = $request->get('dayEnd');
        $monthStart  = $request->get('monthStart');
        $monthEnd    = $request->get('monthEnd');
        $yearStart   = $request->get('yearStart');
        $yearEnd     = $request->get('yearEnd');

        $em   = $this->getDoctrine()->getManager();
        $polity = $em->getRepository('AppBundle:Polity')->findOneById($id);

        if ($polity) {
              $polity->setName($name);
              $polity->setDescription($description);
              $polity->setDayStart($dayStart);
              $polity->setDayEnd($dayEnd);
              $polity->setMonthStart($monthStart);
              $polity->setMonthEnd($monthEnd);
              $polity->setYearStart($yearStart);
              $polity->setYearEnd($yearEnd);

              $checkDate = $this->get('app.check_date');
              $checkDate->init($dayStart.'-'.$monthStart.'-'.$yearStart, $dayEnd.'-'.$monthEnd.'-'.$yearEnd);

            if ($checkDate->correctInterval() == false) {
                        $result = '{"result":"error", "message": "Is the date range correct? No"}';
            } else {
                $countries = $request->get('countries');

                $polityCountries =  $polity->getCountrys();

                foreach ($polityCountries as $polityCountry) {
                    $countryChecked = $em->getRepository('AppBundle:Country')->findOneById($polityCountry);

                    $polity->removeCountry($countryChecked);
                }

                foreach ($countries as $country) {
                        $countryChecked = $em->getRepository('AppBundle:Country')->findOneById($country);
                        $polity->addCountry($countryChecked);
                }



                $em->persist($polity);
                $em->flush();
                $result = '{"result":"ok"}';
            }
        } else {
            $result = '{"result":"error", "message": "It is not an instance. [Polity]" }';
        }

        return new JsonResponse($result);
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



        $checkDate = $this->get('app.check_date');
        $checkDate->init($dayStart.'-'.$monthStart.'-'.$yearStart, $dayEnd.'-'.$monthEnd.'-'.$yearEnd);


        $polity = new Polity();
        $polity->setName($name);
        $polity->setDescription($description);
        $polity->setDayStart($dayStart);
        $polity->setMonthStart($monthStart);
        $polity->setYearStart($yearStart);
        $polity->setDayEnd($dayEnd);
        $polity->setMonthEnd($monthEnd);
        $polity->setYearEnd($yearEnd);

        $validator = $this->get('validator');
        $errors = $validator->validate($polity);

        if (count($errors) > 0) {
            $message = "";
            foreach ($errors as $violation) {
                  $message = $violation->getMessage();
            }
            $result = '{"result":"error", "message": "'.$message.'"}';
        } elseif ($checkDate->correctInterval() == false) {
            $result = '{"result":"error", "message": "Is the date range correct? No"}';
        } else {
            $em = $this->getDoctrine()->getManager();

            $countries = $request->get('countries');
            foreach ($countries as $country) {
                $countryChecked = $em->getRepository('AppBundle:Country')->findOneById($country);
                $polity->addCountry($countryChecked);
            }


            $em->persist($polity);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }
}
