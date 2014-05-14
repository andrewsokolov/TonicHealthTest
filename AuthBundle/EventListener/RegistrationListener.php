<?php

namespace Auth\AuthBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Event\FilterUserResponseEvent;

class RegistrationListener implements EventSubscriberInterface
{
    private $router;
    private $em;
    private $user_manager;
    private $parameters;

    public function __construct(UrlGeneratorInterface $router, EntityManager $em, UserManager $user_manager, array $parameters)
    {
        $this->router = $router;
        $this->em = $em;
        $this->user_manager = $user_manager;
        $this->parameters = $parameters;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_COMPLETED => 'onRegistrationComplete',
        );
    }

    public function onRegistrationComplete(FilterUserResponseEvent $event)
    {
        do {
            $referal = substr(md5(rand()), 0, 6);
        } while (!is_null($this->user_manager->findUserBy(array('referal'=>$referal))));

       /** @var \Auth\AuthBundle\Entity\User  $user */
        $user = $event->getUser();
        $user->setReferal($referal);

        if ($event->getRequest()->cookies->has($this->parameters['referal.cookie.name'])){

            $referal_id = $event->getRequest()->cookies->get($this->parameters['referal.cookie.name']);

            $user_referal = $this->em->getRepository('Auth\AuthBundle\Entity\UserReferal')->find($referal_id);

            if ($user_referal){

                $user->addUserReferal($user_referal);

                $event->getResponse()->headers->clearCookie($this->parameters['referal.cookie.name']);
            }
        }

        $this->user_manager->updateUser($user);

    }
}