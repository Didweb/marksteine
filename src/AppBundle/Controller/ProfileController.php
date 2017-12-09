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
     * Index Aplication
     *
     * @Route("/", name="profile_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

        return $this->render('profile/index.html.twig');
    }
}
