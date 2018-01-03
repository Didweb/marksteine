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
        $em = $this->getDoctrine()->getManager();
        $countrys = $em->getRepository('AppBundle:Country')->findAll();

        return $this->render('admin/country/list.html.twig', array('countrys' => $countrys));
    }
}
