<?php

namespace App\Controller;

use App\Event\TestEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TestController extends AbstractController
{
    /**
     * @Route("/api/test/event", name="api_test_event", methods={"GET"})
     */
    public function testEvent(Request $request, EventDispatcherInterface $eventDispatcher): Response
    {
        $message = $request->query->get('message', 'Сообщение не передано');

        $event = new TestEvent($message);
        $eventDispatcher->dispatch($event, TestEvent::class);

        return $this->json([
            'message' => $message,
        ]);
    }
}