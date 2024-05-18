<?php

namespace App\Core\Http;

use App\Core\Config;
use App\Core\Container\Container;
use App\Core\Exceptions\NotSendHeaders;
use App\Core\HttpStatusCode;
use App\Core\Interface\ResponseInterface;
use Override;

class Response implements ResponseInterface
{
    protected mixed $data;
    protected ?array $headers = [];
    protected Header $header;
    protected int $responseCode;
    protected ?array $jsonResponse;


    /**
     * @throws NotSendHeaders
     */
    public function __construct(mixed $data, int $responseCode = HttpStatusCode::OK, array $headers = [], bool $jsonResponse = true)
    {
        $this->data = $data;
        $this->responseCode = $responseCode;
        $this->headers = $headers;
        if ($jsonResponse) {
            $this->jsonResponse = Config::getValue('headers.jsonResponse');
        }
        echo $this->response();
    }

    /**
     * @throws NotSendHeaders
     */
    protected function prepareHeaders(): void
    {
        $this->header = Container::call(Header::class);
        $this->headers = $this->jsonResponse;
        foreach ($this->headers as $header => $value) {
            $this->header->setHeader($header, $value);
        }
        $this->setData($this->data);
        $this->setStatusCode($this->responseCode);
        $this->header->send();
    }

    #[Override] public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    #[Override] public function setData($data, $key = null): static
    {
        if ($key !== null)
            $this->data[$key] = $data;
        else
            $this->data = $data;
        return $this;
    }

    #[Override] public function getStatusCode(): int
    {
        return http_response_code();
    }

    /**
     * @throws NotSendHeaders
     */
    public function response(): false|string
    {
        $this->prepareHeaders();
        return json_encode([
            'code' => $this->getStatusCode(),
            'headers' => $this->header->getHeaders(),
            'response' => $this->data
        ]);
    }
}