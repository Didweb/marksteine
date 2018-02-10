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

/**
* @Route("admin")
*/
class AdminController extends Controller
{
   /**
     * Index Admin_Aplication
     *
     * @Route("/", name="admin_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

        return $this->render('AppBundle::admin/index.html.twig');
    }
}
