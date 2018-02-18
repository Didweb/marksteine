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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
* @Route("admin/user-manager")
*/
class UserManagerController extends Controller
{
    const LIMIT_PAGINATION = 20;

   /**
     * Index UserManager
     *
     * @Route("/list/{filter}/{page}", name="user_manager_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction($page = 1, $filter = 'ALL')
    {

        $em = $this->getDoctrine()->getManager();

        $allUsers = $em->getRepository('AppBundle:User')->getAllUsers($filter, $page, self::LIMIT_PAGINATION);

        $totalUsers = $allUsers->count();
        $iterator = $allUsers->getIterator();

        $maxPages = ceil($totalUsers / self::LIMIT_PAGINATION);
        $thisPage = $page;

        return $this->render('AppBundle::admin/usermanager/userManagerIndex.html.twig', array(
                                            'allUsers'  => $iterator,
                                            'maxPages'  => $maxPages,
                                            'thisPage'  => $thisPage,
                                            'totalUsers'=> $totalUsers,
                                            'filter'    => $filter));
    }

    /**
      * Change User role
      *
      * @Route("/change-role", name="user_manager_change_role")
      * @Method({"GET", "POST"})
      */
    public function changeRoleAction(Request $request)
    {
        $manager_user = $this->container->get('app.manager_users');
        $result = $manager_user
                        ->changeRole(
                            $request->get('destineRole'),
                            $request->get('currentRole'),
                            $request->get('userIdObjective'),
                            $this->getUser()
                        );


        $result  = json_decode($result);
        $typeAlert = 'success';
        if ($result->result == 'error') {
            $typeAlert = 'error';
        }
        $request->getSession()->getFlashBag()->add($typeAlert, $result->message);
        return new JsonResponse($result);
    }
}
