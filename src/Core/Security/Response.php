<?php

namespace App\Core\Security;

use App\Core\Exceptions\NotSendHeaders;
use App\Core\Interface\ResponseInterface;
use Override;

class Response implements ResponseInterface
{
    protected mixed $data;
    protected array $headers;

    #[Override] public function setHeader(string $header, mixed $value): static
    {
        $this->headers[$header] = $value;
        return $this;
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

    #[Override] public function getHeader(): array
    {
        return headers_list();
    }

    #[Override] public function send(): void
    {
        if (!empty($this->headers)) {
            if (headers_sent()) {
                throw new NotSendHeaders('Headers now be send!');
            }
            foreach ($this->headers as $key => $header) {
                header("$key: $header");
            }
        }
    }

    #[Override] public function getStatusCode(): int
    {
        return http_response_code();
    }

    public function response(): false|string
    {
        $data = $this->data;
//        $data['size'] = json_decode($data['size']);
        return json_encode([
            'code' => $this->getStatusCode(),
            'headers' => $this->getHeader(),
            'response' => $data
        ]);
    }
}