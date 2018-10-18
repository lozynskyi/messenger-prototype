<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\FOSRestController;

class DefaultController extends FOSRestController
{
    /**
     * @return JsonResponse
     */
    public function pingAction()
    {
        return $this->json([
            'message' => 'pong',
        ]);
    }
}
