<?php

namespace ApiBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use AppBundle\Entity\Chat;
use AppBundle\Repository\ChatRepository;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints;

/**
 * Class UserController
 * @package ApiBundle\Controller
 */
class ChatController extends AbstractApiController
{

    /**
     * @param Request $request
     * @param $limit
     * @param $offset
     * @return JsonResponse
     */
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

    /**
     * @return JsonResponse
     */
    public function deleteAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var ChatRepository $chatRepo */
        $chatRepo = $em->getRepository('AppBundle:Chat');
        $result = $chatRepo->dropAll();
        return $this->json(['status' => $result]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
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

    /**
     * @param Request $request
     * @param $chatId
     * @return JsonResponse
     */
    public function createMessageAction(Request $request, $chatId)
    {
        $request->request->add(['chatId'=>$chatId]);
        $rules = [
            'from' => new Constraints\NotBlank(),
            'text' => new Constraints\NotBlank(),
            'chatId' => new Constraints\NotBlank(),
        ];
        $errors = $this->validate($request, $rules);

        if (count($errors)) {
            return $this->badRequest($errors);
        }

        //TODO rewrite to get from user hash in headers.(Create base authorize)
        $userId = $request->get('from');
        $text = $request->get('text');
        $chatId = $request->get('chatId');

        $em = $this->getDoctrine()->getManager();
        /** @var ChatRepository $chatR */
        $chatR = $em->getRepository('AppBundle:Chat');
        /** @var Chat $chat */
        $chat = $chatR->find($chatId);
        if (!$chat) {
            return $this->badRequest('Chat does not exist');
        }
        /** @var UserRepository $userR */
        $userR = $em->getRepository('AppBundle:User');
        /** @var User $user */
        $user = $userR->find($userId);
        if (!$user) {
            return $this->badRequest('User does not exist');
        }

        $messengerService = $this->get('messenger.service');
        /** @var Message $message */
        $message = $messengerService->createMessage($user, $chat, $text);

        return $this->json(["messageId" => $message->getId()]);
    }

    /**
     * @param Request $request
     * @param $id
     * @param int $limit
     * @param int $offset
     * @return JsonResponse
     */
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
        if (!$chat) {
            return $this->badRequest('Chat does not exist');
        }

        /** @var MessageRepository $messageR */
        $messageR = $em->getRepository('AppBundle:Message');
        $mess = $messageR->getAllMessages($chat, $limit, $offset);

        return $this->json($mess);
    }
}