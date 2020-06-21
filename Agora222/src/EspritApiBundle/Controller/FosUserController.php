<?php

namespace EspritApiBundle\Controller;

use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class FosUserController extends Controller
{
    public function loginAction(Request $request)
    {
        $_username = $request->get('name');
        $_password = $request->get('password');

        $factory = $this->get('security.encoder_factory');
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('username'=>$_username));
        if(!$user){
            return new JsonResponse("Username or Password not valid.");
        }

        /// Start verification
        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $_password, $salt)) {
            return new JsonResponse("Username or Password not valid.");
        }

        //Handle getting or creating the user entity likely with a posted form
        // The third parameter "main" can change according to the name of your firewall in security.yml
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);

        // If the firewall name is not main, then the set value would be instead:
        // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
        $this->get('session')->set('_security_main', serialize($token));

        // Fire the login event manually
        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        //$serializer = new Serializer([new ObjectNormalizer()]);
        //$formatted = $serializer->normalize();

        return new JsonResponse($user->getRoles()[0]);
    }
}
