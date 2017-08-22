<?php
namespace MessageApi\Application\Route;

use Symfony\Component\HttpFoundation\Request;
use Silex\Application;

class Message {

    private $app;
    private $apiService;

    public function __construct(Application $app, \MessageApi\Domain\Message\ApiService $apiService) {
        $this->app = $app;
        $this->apiService = $apiService;
    }

    public function create() {
        $this->createGetMessage();
        $this->createGetArchivedMessage();
        $this->createPostShowMessage();
        $this->createPostArchiveMessage();
        $this->createPostReadMessage();
    }

    private function createGetMessage() {
        $apiService = $this->apiService;
        $this->app->get('/message', function (Application $app, Request $request) use ($apiService) {
            $page = $request->query->get('page', 1);
            $limit = $request->query->get('limit', 10);
            return $app->json($apiService->list($page, $limit));
        });
    }

    private function createGetArchivedMessage() {
        $apiService = $this->apiService;
        $this->app->get('/message/archived', function (Application $app, Request $request) use ($apiService) {
            $page = $request->query->get('page', 1);
            $limit = $request->query->get('limit', 10);
            return $app->json($apiService->listArchived($page, $limit));
        });
    }

    private function createPostShowMessage() {
        $apiService = $this->apiService;
        $this->app->get('/message/{uid}', function (Application $app, $uid) use ($apiService) {
            return $app->json($apiService->show($uid));
        });
    }

    private function createPostArchiveMessage() {
        $apiService = $this->apiService;
        $this->app->post('/message/{uid}/archive', function (Application $app, $uid) use ($apiService) {
            return $app->json($apiService->archive($uid));
        });
    }

    private function createPostReadMessage() {
        $apiService = $this->apiService;
        $this->app->post('/message/{uid}/read', function (Application $app, $uid) use ($apiService) {
            return $app->json($apiService->read($uid));
        });
    }
}
