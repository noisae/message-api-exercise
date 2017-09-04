<?php
namespace MessageApi\Application\Route;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;
use MessageApi\Domain\MessageApi;
use MessageApi\Application\Route\RouteInterface;

class MessageRoute implements RouteInterface {

    /**
     * @var Application
     */
    private $app;
    /**
     * @var MessageApi
     */
    private $exposeApiService;


    /**
     * @param Application $app
     * @param MessageApi $exposeApiService
     */
    public function __construct(Application $app, MessageApi $exposeApiService) {
        $this->app = $app;
        $this->exposeApiService = $exposeApiService;
    }

    public function register() {
        $this->registerGetMessage();
        $this->registerGetArchivedMessage();
        $this->registerGetShowMessage();
        $this->registerPostArchiveMessage();
        $this->registerPostReadMessage();
    }

    private function registerGetMessage() {
        $exposeApiService = $this->exposeApiService;
        $this->app->get('/message', function (Application $app, Request $request) use ($exposeApiService) {
            $page = $request->query->get('page', 1);
            $limit = $request->query->get('limit', 10);
            return $app->json($exposeApiService->list($page, $limit));
        });
    }

    private function registerGetArchivedMessage() {
        $exposeApiService = $this->exposeApiService;
        $this->app->get('/message/archived', function (Application $app, Request $request) use ($exposeApiService) {
            $page = $request->query->get('page', 1);
            $limit = $request->query->get('limit', 10);
            return $app->json($exposeApiService->listArchived($page, $limit));
        });
    }

    private function registerGetShowMessage() {
        $exposeApiService = $this->exposeApiService;
        $this->app->get('/message/{uid}', function (Application $app, $uid) use ($exposeApiService) {
            return $app->json($exposeApiService->show($uid));
        });
    }

    private function registerPostArchiveMessage() {
        $exposeApiService = $this->exposeApiService;
        $this->app->post('/message/{uid}/archive', function (Application $app, $uid) use ($exposeApiService) {
            return $app->json($exposeApiService->archive($uid));
        });
    }

    private function registerPostReadMessage() {
        $exposeApiService = $this->exposeApiService;
        $this->app->post('/message/{uid}/read', function (Application $app, $uid) use ($exposeApiService) {
            return $app->json($exposeApiService->read($uid));
        });
    }
}
