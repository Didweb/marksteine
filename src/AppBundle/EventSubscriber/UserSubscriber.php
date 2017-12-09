<?php

  namespace AppBundle\EventSubscriber;

  use AppBundle\Entity\Person;
  use FOS\UserBundle\Event\UserEvent;
  use FOS\UserBundle\FOSUserEvents;
  use Symfony\Component\DependencyInjection\ContainerInterface;
  use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    protected $container;
    public function __construct(ContainerInterface $container) // this is @service_container
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(
            //FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationCompleted'
        );
    }

    public function onRegistrationCompleted(AppBundle\EventSubscriber\FilterUserResponseEvent  $event)
    {
      return;
    }
}
