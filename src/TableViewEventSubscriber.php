<?php

declare(strict_types=1);


namespace DeviantLab\TabulatorBundle;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ViewEvent;

#[AsEventListener]
final class TableViewEventSubscriber extends AbstractController
{
    public function __invoke(ViewEvent $event): void
    {
        $table = $event->getControllerResult();
        if (!$table instanceof Table) {
            return;
        }

        $request = $event->getRequest();

        if (!$request->isXmlHttpRequest()) {
            $response = $this->render('tabulator/index.html.twig', [
                'table' => $table,
            ]);
            $event->setResponse($response);
            return;
        }

        if ($request->getPreferredFormat() === 'json') {
            $response = new JsonResponse($table->getDataLoader()());
            $event->setResponse($response);
            return;
        }

        $response = $this->renderBlock('tabulator/index.html.twig', 'content', [
            'table' => $table,
        ]);
        $event->setResponse($response);
    }
}
