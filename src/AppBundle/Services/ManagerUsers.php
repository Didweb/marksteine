<?php
/**
 * Class ManagerUsers | AppBundle/Services/ManagerUsers.php
 *
 * @package AppBundle
 * @author Eduard Pinuaga <info@did-web.com>
 */

  namespace AppBundle\Services;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Manager users
*/
class ManagerUsers
{
    private $isUserManager =  false;
    private $em;
    private $container;

    public function __construct(EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->em = $entityManager;
        $this->container =  $container;
    }


    public function changeRole($destinyRole, $currentRole, $user_id, $userManager_id)
    {
        $userManager = $this->em->getRepository('AppBundle:User')->findOneById($userManager_id);
        $this->controlManager($userManager);

        if ($this->isUserManager && $userManager->getId() <> $user_id) {
            $user = $this->em->getRepository('AppBundle:User')->findOneById($user_id);
            if (count($user->getCollaborators()) > 0
                && ($destinyRole == 0  ||  $destinyRole == 1) ) {
                return '{"result":"error", "message": "The user has collaborators under his charge."}';
            }

            $currentNameRole = $this->container->getParameter('role'.$currentRole);
            $user->removeRole($currentNameRole);

            $this->em->persist($user);

            $nameRole = $this->container->getParameter('role'.$destinyRole);
            $user->addRole($nameRole);
            $manager = $user->getManager();
            $user->setmanager(null);
            $this->em->persist($user);
            $this->em->flush();

            if ($manager) {
                $manager->removeCollaborator($user);
                $this->em->persist($manager);
                $this->em->flush();
            }

            $result = '{"result":"ok", "message": "The users status has been changed."}';
        } else {
            $result = '{"result":"error", "message": "The user does not have permission."}';
        }

        return $result;
    }


    public function changeCollaboratorRole($destinyRole, $currentRole, $user_id, $userManager_id)
    {
        $userManager = $this->em->getRepository('AppBundle:User')->findOneById($userManager_id);
        $this->controlManager($userManager);

        if ($this->isUserManager && $userManager->getId() <> $user_id) {
            $user = $this->em->getRepository('AppBundle:User')->findOneById($user_id);

            if (count($user->getCollaborators()) > 0
                && ($destinyRole == 0  ||  $destinyRole == 1) ) {
                return '{"result":"error", "message": "The user has collaborators under his charge x."}';
            }

            $currentNameRole = $this->container->getParameter('role'.$currentRole);

            $user->removeRole($currentNameRole);

            $this->em->persist($user);

            $nameRole = $this->container->getParameter('role'.$destinyRole);
            $user->addRole($nameRole);
            $user->setManager($userManager);
            $this->em->persist($user);
            $this->em->flush();

            if ($userManager) {
                $userManager->addCollaborator($user);
                $this->em->persist($userManager);
                $this->em->flush();
            }


            $result = '{"result":"ok", "message": "The users status has been changed xxx"}';
        } else {
            $result = '{"result":"error", "message": "The user does not have permission."}';
        }

        return $result;
    }


    public function controlManager(User $userManager)
    {
        if (in_array("ROLE_MANAGER", $userManager->getRoles())
            || in_array("ROLE_ADMIN", $userManager->getRoles())
            || in_array("ROLE_SUPER_ADMIN", $userManager->getRoles())) {
            $this->isUserManager = true;
        }
    }


    public function getIsUserManager()
    {
        return $this->isUserManager;
    }
}
