<?php

declare(strict_types=1);

use App\UI\Http\Action;
use App\Application\Router\StaticRouteGroup as Group;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;

return static function (App $app): void {
    $app->get('/', Action\HomeAction::class);

    $app->group('/V1/transaction', new Group(static function (RouteCollectorProxy $group): void {
        $group->post('/transfer-from-user', Action\V1\Transaction\TransferFromUserAction::class);
    }));
};
