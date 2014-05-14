<?php

namespace Auth\AuthBundle\EventListener;

use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use FOS\UserBundle\Doctrine\UserManager;
use Doctrine\ORM\EntityManager;
use Auth\AuthBundle\Entity\UserReferal;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Cookie;

class ReferalListener
{
    protected $em;
    protected $router;
    protected $user_manager;
    protected $user_referal;
    protected $parameters;

    public function __construct(EntityManager $em, Router $router, UserManager $user_manager, array $parameters)
    {
        $this->em         = $em;
        $this->router     = $router;
        $this->parameters = $parameters;
        $this->user_manager = $user_manager;
    }

    /**
     * Save referal for user
     *
     * @param \Symfony\Component\HttpKernel\Event\GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if ($event->getRequestType() == HttpKernelInterface::MASTER_REQUEST) {
            if ($request->query->has($this->parameters['referal.param.name'])) {

                $referal = $request->query->get($this->parameters['referal.param.name']);

                if (!is_null($this->user_manager->findUserBy(array('referal'=>$referal)))){

                    $this->user_referal = new UserReferal();
                    $this->user_referal->setIp($request->getClientIp())
                        ->setReferal($referal)
                        ->setReferer($request->headers->get('referer'))
                        ->setDate(new \DateTime());

                    $this->em->persist($this->user_referal);
                    $this->em->flush();
                }

                $request->query->remove($this->parameters['referal.param.name']);

                $event->setResponse(new RedirectResponse($this->router->generate($request->get('_route'), $request->query->all()), 301));
            }
        }
    }

    /**
     * Set cookie with referal_id for user
     *
     * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        $response = $event->getResponse();

        if ($event->getRequestType() == HttpKernelInterface::MASTER_REQUEST) {
            if ($this->user_referal) {

                $response->headers->setCookie(
                    new Cookie(
                        $this->parameters['referal.cookie.name'],
                        $this->user_referal->getId(),
                        time() + 3600 * 24 * 365,
                        '/'
                    )
                );

            }
        }
    }
}