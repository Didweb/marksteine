<?php
/**
 * Class ProfileController | AppBundle/Controller/ProfileController.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
* @Route("profile")
*/
class ProfileController extends Controller
{
   /**
     * Index Profile
     *
     * @Route("/", name="profile_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {
        return $this->render('profile/index.html.twig');
    }

    /**
     * Remove avatar
     * @Route("/remove-avatar/{idUser}", name="remove_avatar")
     * @Method("GET")
     */
    public function removeAvatar(Request $request, $idUser)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:User');
        $user = $repository->findOneById($idUser);

        if ($user && $user->getAvatar() != null) {
            $path = realpath('../web/avatars/'.$user->getAvatar());
            if ($path == '') {
                $path = 'web/avatars/'.$user->getAvatar();
            }
            unlink($path);
            $user->setAvatar(null);
            $em->persist($user);
            $em->flush();
        }

        return $this->redirectToRoute('profile_edit');
    }


    /**
      * Edit Profile
      *
      * @Route("/edit", name="profile_edit")
      * @Method({"GET", "POST"})
      */
    public function editProfileAction(Request $request)
    {
        $user = $this->getUser();
        $editForm = $this->createForm('AppBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Set name Avatar and save image
            if ($user->getFile() !== null) {
                  $file = $user->getFile();
                  $ext  = $file->guessExtension();
                  $file_name = time()."_".strtolower($user->getUsername()).".".$ext;
                  $path = realpath('avatars');
                if ($path == '') {
                      $path = '../web/avatars/';
                }
                  $file->move($path, $file_name);
                  $user->setAvatar($file_name);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_edit');
        }

        return $this->render('profile/edit.html.twig', array(
                             'edit_form' => $editForm->createView(),
                             'idUser' => $user->getId()
                           ));
    }
}
