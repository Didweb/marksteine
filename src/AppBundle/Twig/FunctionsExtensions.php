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

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
      return array(
            'UserRole'  => new \Twig_Filter_Method($this, 'UserRole'),
        );
    }

    public function UserRole($role)
    {
      //  $container->getParameter('color_role_user');
        $result = 'VOID';
        switch ($role) {
            case 'ROLE_USER':
                $result = array("color" => $this->container->getParameter('color_role_user'),
                                "name" => 'Role: User',
                                "level" => 1);
                break;
            case 'ROLE_COLLABORATOR':
                $result = array("color" => $this->container->getParameter('color_role_collaborator'),
                                "name" => 'Role: Collaborator',
                                "level" => 2);
                break;
            case 'ROLE_MANAGER':
                $result = array("color" => $this->container->getParameter('color_role_manager'),
                                "name" => 'Role: Manager',
                                "level" => 3);
                break;
            case 'ROLE_ADMIN':
                $result = array("color" => $this->container->getParameter('color_role_admin'),
                                "name" => 'Role: Admin',
                                "level" => 4);
                break;
            case 'ROLE_SUPER_ADMIN':
                $result = array("color" => $this->container->getParameter('color_role_super_admin'),
                                "name" => 'Role: Super Admin',
                                "level" => 5);
                break;
        }
        return $result;
    }

    public function getName()
    {
        return 'my_functions';
    }
}
