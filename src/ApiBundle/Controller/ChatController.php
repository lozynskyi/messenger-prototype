<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Chat;
use AppBundle\Repository\ChatRepository;
use AppBundle\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints;

/**
 * Class UserController
 * @package ApiBundle\Controller
 */
class ChatController extends AbstractApiController
{

    public function getAllAction(Request $request, $limit, $offset)
    {
        $request->request->add(['limit'=>$limit, 'offset'=>$offset]);
        //validate incoming fields.
        $rules = [
            'limit' => new Constraints\Range(['min' => 1, 'max' => 100]),
            'offset' => new Constraints\Range(['min' => 0, 'max' => 10000]),
        ];
        $errors = $this->validate($request, $rules);

        if (count($errors)) {
            return $this->badRequest($errors);
        }

        $em = $this->getDoctrine()->getManager();
        /** @var ChatRepository $userRepo */
        $userRepo = $em->getRepository('AppBundle:Chat');
        $chats = $userRepo->getAllChats($limit, $offset);
        return $this->json([$chats]);
    }

    public function deleteAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var ChatRepository $chatRepo */
        $chatRepo = $em->getRepository('AppBundle:Chat');
        $result = $chatRepo->dropAll();
        return $this->json(['status' => $result]);
    }

    public function deleteOneAction(Request $request, $id)
    {
        $request->request->add(['id' => intval($id)]);
        $rules = [
            'id' => new Constraints\NotEqualTo(0)
        ];
        $errors = $this->validate($request, $rules);
        if (count($errors)) {
            return $this->badRequest($errors);
        }

        $em = $this->getDoctrine()->getManager();
        /** @var ChatRepository $chatRepo */
        $chatRepo = $em->getRepository('AppBundle:Chat');
        $result = $chatRepo->dropOne(intval($id));
        return $this->json(['processed' => $result ? true : false]);
    }

    public function createAction(Request $request)
    {
        //validate incoming fields.
        $rules = [
            'topic' => new Constraints\Length(['min' => 3, 'max' => 190]),
        ];
        $errors = $this->validate($request, $rules);

        if (count($errors)) {
            return $this->badRequest($errors);
        }
        $topic = $request->get('topic');

        $chatService = $this->get('messenger.service');
        /** @var Chat $chat */
        $chat = $chatService->createChat($topic, $request);
        return $this->json(['id' => $chat->getId()]);
    }

    public function createMessageAction(Request $request, $id)
    {

    }
    public function getMessagesByChatAction(Request $request, $id, $limit = 100, $offset = 0)
    {
        $request->request->add(['chatId'=>$id, 'limit'=>$limit, 'offset'=>$offset]);
        //validate incoming fields.
        $rules = [
            'limit' => new Constraints\Range(['min' => 1, 'max' => 100]),
            'offset' => new Constraints\Range(['min' => 0, 'max' => 10000]),
            'chatId' => new Constraints\NotBlank(),
        ];
        $errors = $this->validate($request, $rules);

        if (count($errors)) {
            return $this->badRequest($errors);
        }

        $em = $this->getDoctrine()->getManager();
        /** @var MessageRepository $userRepo */
        $chatR = $em->getRepository('AppBundle:Chat');
        /** @var Chat $chat */
        $chat = $chatR->find($id);
        /** @var MessageRepository $userRepo */
        $userRepo = $em->getRepository('AppBundle:Message');

        $mess = $userRepo->getAllMessages($chat, $limit, $offset);
        return $this->json([$mess]);
    }
}