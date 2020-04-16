<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuthenticationSuccessSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::AUTHENTICATION_FAILURE => 'onAuthenticationSuccessResponse',
        ];
    }

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $user = $this->em->getRepository(User::class)->findOneBy(array(
            'username' =>  $event->getException()->getToken()->getUsername()
        ));

        if($user){
            $user->setLastConnection(new \DateTime());
            $this->em->flush();
        }

        $message = $event->getException()->getMessage();
        if (empty($message)) {
            return;
        }
       
        $response = $event->getResponse();
        $response->setMessage($message);
        $event->setResponse($response);
    }
}