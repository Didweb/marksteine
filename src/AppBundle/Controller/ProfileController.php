<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
    public function editProfileAction()
    {
        return $this->render('profile/edit.html.twig');
    }
}
