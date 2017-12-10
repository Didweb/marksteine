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


          $file= $user->getFile();

          $ext=$file->guessExtension();
          $file_name=time().".".$ext;
          $file->move("avatars", $file_name);

          $user->setAvatar($file_name);

          $this->getDoctrine()->getManager()->flush();

          return $this->redirectToRoute('profile_edit');
      }

      return $this->render('profile/edit.html.twig', array(
          'edit_form' => $editForm->createView()
      ));

    }
}
