<?php

declare(strict_types=1);

namespace App\UI\Http\Action\V1\Transaction;

use App\UI\Http\Action\AbstractAction;
use App\UI\Http\ParamsExtractor;
use App\Wallet\Command\Transaction\TransferFromUser\Command;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TransferFromUserAction extends AbstractAction
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $command = $this->deserialize($request);
        $this->validator->validate($command);

        $this->bus->handle($command);

        return $this->asEmpty();
    }

    private function deserialize(ServerRequestInterface $request): Command
    {
        $paramsExtractor = ParamsExtractor::fromRequest($request);

        return new Command(
            $paramsExtractor->getString('fromUserId'),
            $paramsExtractor->getString('toUserId'),
            $paramsExtractor->getFloat('amount')
        );
    }
}
