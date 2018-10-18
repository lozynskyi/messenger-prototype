<?php

namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\{
    Constraints, Validation
};


/**
 * Class AbstractApiController
 * @package ApiBundle\Controller
 */
abstract class AbstractApiController extends FOSRestController
{
    /**
     * @param null $message
     * @return JsonResponse
     */
    public function error($message = null)
    {
        $data = [
            'error' => $message ?? 'Internal Server Error',
        ];
        if (is_array($message)) {
            $data = $message;
        }

        return $this->json($data, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param null $message
     * @return JsonResponse
     */
    public function badRequest($message = null)
    {
        $data = [
            'error' => $message ?? 'Bad Request',
        ];
        if (is_array($message)) {
            $data = $message;
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param null $message
     * @return JsonResponse
     */
    public function notImplemented($message = null)
    {
        $data = [
            'error' => $message ?? 'Not Implemented',
        ];
        if (is_array($message)) {
            $data = $message;
        }

        return $this->json($data, Response::HTTP_NOT_IMPLEMENTED);
    }



    protected function validate(Request $request, array $rules = [])
    {
        $paramsBag = $request->request->all();
        $constraint = new Constraints\Collection($rules);
        $validator = Validation::createValidator();
        $violations = $validator->validate($paramsBag, $constraint);

        $errors = [];
        /** @var \Symfony\Component\Validator\ConstraintViolation $violation */
        foreach ($violations as $violation) {
            $key = str_replace(['[', ']'], '', $violation->getPropertyPath());
            $errors['error'][$key] = $violation->getMessage();
        }
        $violations = $errors;

        return $violations;
    }
}
