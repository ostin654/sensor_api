<?php

namespace App\Actions;

use Psr\Http\Message\ResponseInterface;

trait JsonTrait
{
    private function json(array $data, int $status = 200): ResponseInterface
    {
        $this->response->getBody()->write(\json_encode($data));

        return $this->response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($status);
    }
}
