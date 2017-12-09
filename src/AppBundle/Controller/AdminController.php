<?php

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
     * Index Aplication
     *
     * @Route("/", name="admin_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

        return $this->render('admin/index.html.twig');
    }
}
