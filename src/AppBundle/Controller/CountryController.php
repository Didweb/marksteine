<?php
/**
 * Class CountryController | AppBundle/Controller/CountryController.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\CountriesType;
use AppBundle\Entity\Country;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("country")
*/
class CountryController extends Controller
{
    const LIMIT_PAGINATION = 5;

    /**
      * List Country
      *
      * @Route("/list/{page}", name="country_list")
      * @Method({"GET", "POST"})
      * @param integer $page The current page passed via URL
      */
    public function listCountryAction($page = 1)
    {
        $country = new Country();
        $em = $this->getDoctrine()->getManager();
        $countries = $em->getRepository('AppBundle:Country')->getAllCountries($page, self::LIMIT_PAGINATION);

        $totalCountries = $countries->count();
        $iterator = $countries->getIterator();

        $maxPages = ceil($totalCountries / self::LIMIT_PAGINATION);
        $thisPage = $page;

        $form = $this->createForm(CountriesType::class, $country);
        return $this->render('admin/country/list.html.twig', array(
                                            'countries' => $iterator,
                                            'maxPages'  => $maxPages,
                                            'thisPage'  => $thisPage,
                                            'form'      => $form->createView()));
    }


    /**
     * Delete Country
     * @Route("/delete-country", name="country_delete")
     * @Method("GET")
     */
    public function deleteCountry(Request $request)
    {
        $em = $this->getDoctrine()->getmanager();
        $country = $em->getRepository('AppBundle:Country')->findOneById($request->get('id'));
        if (!$country) {
            $result = '{"result":"error", "message": "This country is already added."}';
        } else {
            $em->remove($country);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }


    /**
     * Add Country
     * @Route("/add-country", name="country_add")
     * @Method({"GET", "POST"})
     */
    public function addCountry(Request $request)
    {
        $country = new Country();
        $country->setName($request->get('name'));

        $validator = $this->get('validator');
        $errors = $validator->validate($country);

        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            $result = '{"result":"error", "message": "This country is already added."}';
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($country);
            $em->flush();
            $result = '{"result":"ok"}';
        }
        return new JsonResponse($result);
    }
}
