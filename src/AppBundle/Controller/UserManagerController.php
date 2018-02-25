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
      * List Managers
      *
      * @Route("/list-managers", name="user_manager_list_managers")
      * @Method({"GET", "POST"})
      */
    public function listManagersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $managers = $em->getRepository('AppBundle:User')->getAllManagers();
        $list = array();
        foreach ($managers as $manager) {
            if ($manager->getId() != $this->getUser()->getId()
                && $manager->getRoles()[0] != 'ROLE_USER' && $manager->getRoles()[0] != 'ROLE_COLLABORATOR' ) {
                $color = $this->getParameter('color_'.strtolower($manager->getRoles()[0]));
                $list[] = array('idUser' => $manager->getId(),
                                'name'   => $manager->getUsername(),
                                'avatar' => $manager->getAvatar(),
                                'roles'  => $manager->getRoles(),
                                'colorRole' => $color
                                );
            }
        }
        return new JsonResponse($list);
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

        if ($request->get('user_manager') != null) {
            $result = $manager_user
                            ->changeCollaboratorRole(
                                $request->get('destineRole'),
                                $request->get('currentRole'),
                                $request->get('userObjective'),
                                $request->get('user_manager')
                            );
        } else {
            $result = $manager_user
                            ->changeRole(
                                $request->get('destineRole'),
                                $request->get('currentRole'),
                                $request->get('userObjective'),
                                $this->getUser()
                            );
        }


        $result  = json_decode($result);
        $typeAlert = 'success';
        if ($result->result == 'error') {
            $typeAlert = 'error';
        }
        $request->getSession()->getFlashBag()->add($typeAlert, $result->message);
        return new JsonResponse($result);
    }
}
