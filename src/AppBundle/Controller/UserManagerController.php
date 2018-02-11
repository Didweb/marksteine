<?php
/**
 * Class UserManagerController | AppBundle/Controller/UserManagerController.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
* @Route("admin/user-manager")
*/
class UserManagerController extends Controller
{
    const LIMIT_PAGINATION = 10;

   /**
     * Index UserManager
     *
     * @Route("/list", name="user_manager_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction($page = 1)
    {

        $em = $this->getDoctrine()->getManager();
        $allUsers = $em->getRepository('AppBundle:User')->getAllUsers($page, self::LIMIT_PAGINATION);

        $totalUsers = $allUsers->count();
        $iterator = $allUsers->getIterator();

        $maxPages = ceil($totalUsers / self::LIMIT_PAGINATION);
        $thisPage = $page;

        return $this->render('AppBundle::admin/usermanager/userManagerIndex.html.twig', array(
                                            'allUsers'     => $iterator,
                                            'maxPages'  => $maxPages,
                                            'thisPage'  => $thisPage,
                                            'totalUsers'=> $totalUsers,));
    }


}
