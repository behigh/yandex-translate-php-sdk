<?php

/**
 * Файл из репозитория Yandex-Translate-PHP-SDK
 * @link https://github.com/itpanda-llc/yandex-translate-php-sdk
 */

namespace Panda\Yandex\TranslateSdk;

/**
 * Class Request
 * @package Panda\Yandex\TranslateSdk
 * Web-запрос
 */
class Request
{
    /**
     * @param string $url URL-адрес
     * @param string|null $data Параметры
     * @param array $headers Заголовки
     * @return string Результат
     */
    protected function send($url, $data, array $headers)
    {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($headers !== [])
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (!is_null($data))
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        if (($response = curl_exec($ch)) === false)
            throw new Exception\ClientException(curl_error($ch));

        curl_close($ch);

        return $response;
    }
}
