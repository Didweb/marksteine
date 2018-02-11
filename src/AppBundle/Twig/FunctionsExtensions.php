<?php
/**
 * Class FuncktionsExtensions | AppBundle/Twig/FuncktionsExtensions.php
 *
 * @package AppBundle
 * @author Eduard Pinuaga <info@did-web.com>
 */

  namespace AppBundle\Twig;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
*
*/
class FunctionsExtensions extends \Twig_Extension
{
  protected $container;
  public function __construct(ContainerInterface $container) {
   $this->container = $container;
   }
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array( 'UserRole' => new \Twig_SimpleFunction('UserRole', array($this, 'UserRole')));
    }

    public function UserRole($role)
    {
      //  $container->getParameter('color_role_user');
        $result = 'VOID';
        switch ($role) {
            case 'ROLE_USER':
                $result = array("color" => $this->container->getParameter('color_role_user'),
                                "name" => 'Role: User');
                break;
            case 'ROLE_COLLABORATOR':
                $result = array("color" => $this->container->getParameter('color_role_collaborator'),
                                "name" => 'Role: Collaborator');
                break;
            case 'ROLE_MANAGER':
                $result = array("color" => $this->container->getParameter('color_role_manager'),
                                "name" => 'Role: Manager');
                break;
            case 'ROLE_ADMIN':
                $result = array("color" => $this->container->getParameter('color_role_admin'),
                                "name" => 'Role: Admin');
                break;
            case 'ROLE_SUPER_ADMIN':
                $result = array("color" => $this->container->getParameter('color_role_super_admin'),
                                "name" => 'Role: Super Admin');
                break;
          }

        return $result;
    }

    public function getName()
    {
        return 'my_functions';
    }
}
