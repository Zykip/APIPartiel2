<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AuthenticationFailureSubscriber implements EventSubscriberInterface
{
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        return [
            Events::AUTHENTICATION_FAILURE => 'onAuthenticationFailureResponse',
        ];
    }

    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $user = $this->em->getRepository(User::class)->findOneBy(array(
            'username' =>  $event->getException()->getToken()->getUsername()
        ));

        if($user){
            $old = $user->getFailedAuth();
            $user->setFailedAuth($old+1);
            $this->em->flush();
        }

        $message = $event->getException()->getMessage();
        if (empty($message)) {
            return;
        }
        /** @var JWTAuthenticationFailureResponse $response */
        $response = $event->getResponse();
        $response->setMessage($message);
        $event->setResponse($response);
    }
}