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


    /**
      * List Country
      *
      * @Route("/list", name="country_list")
      * @Method({"GET", "POST"})
      */
    public function listCountryAction()
    {
        $country = new Country();
        $em = $this->getDoctrine()->getManager();
        $countries = $em->getRepository('AppBundle:Country')->findBy(array(), array('name' => 'ASC'));
        $form = $this->createForm(CountriesType::class, $country);
        return $this->render('admin/country/list.html.twig', array(
                                            'countries' => $countries,
                                            'form' => $form->createView()));
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
