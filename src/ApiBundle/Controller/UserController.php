<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints;

/**
 * Class UserController
 * @package ApiBundle\Controller
 */
class UserController extends AbstractApiController
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function registerAction(Request $request)
    {
        //validate incoming fields.
        $rules = [
            'gender' => new Constraints\Choice(['choices' => ['male', 'female']]),
            'username' => new Constraints\Length(['min' => 3, 'max' => 254]),
            'password' => new Constraints\NotBlank(),
            'email' => [
                new Constraints\Email(),
                new Constraints\Length(['min' => 6, 'max' => 254])
            ],
        ];
        $errors = $this->validate($request, $rules);
        if (count($errors)) {
            return $this->badRequest($errors);
        }
        $email = $request->get('email');
        $password = $request->get('password');
        $gender = $request->get('gender');
        $username = $request->get('username');

        $em = $this->getDoctrine()->getManager();
        $userRepo = $em->getRepository('AppBundle:User');
        if ($userRepo->isExist($email)) {
            return $this->json(['error' => 'Already registered'], Response::HTTP_BAD_REQUEST);
        }
        $userService = $this->get('user.service');
        $userService->create($email, $password, $gender, $username, $age, $request);

        return $this->json(['lol']);
    }

    public function loginAction(Request $request)
    {
        return $this->notImplemented();
    }

}