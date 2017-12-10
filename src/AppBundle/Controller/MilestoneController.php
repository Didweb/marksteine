<?php
/**
 * Class MilestoneController | AppBundle/Controller/MilestoneController.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
* @Route("")
*/
class MilestoneController extends Controller
{
   /**
     * Index Aplication
     *
     * @Route("/", name="app_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

        return $this->render('milestone/index.html.twig');
    }
}
