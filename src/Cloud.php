<?php

/**
 * Файл из репозитория Yandex-Translate-PHP-SDK
 * @link https://github.com/itpanda-llc/yandex-translate-php-sdk
 */

namespace Panda\Yandex\TranslateSdk;

/**
 * Class Cloud
 * @package Panda\Yandex\TranslateSdk
 * Аутентификация / Выполнение задачи/запроса
 */
class Cloud extends Request
{
    /**
     * Наименование параметра "OAuth-токен"
     * @link https://cloud.yandex.ru/docs/iam/operations/iam-token/create
     */
    const YANDEX_PASSPORT_OAUTH_TOKEN = 'yandexPassportOauthToken';

    /**
     * Наименование параметра "Идентификатор каталога"
     * @link https://cloud.yandex.ru/docs/translate/api-ref/Translation/detectLanguage
     * @link https://cloud.yandex.ru/docs/translate/api-ref/Translation/listLanguages
     * @link https://cloud.yandex.ru/docs/translate/api-ref/Translation/translate
     */
    const FOLDER_ID = 'folderId';

    /**
     * Наименование параметра "Bearer" в заголовке "Authorization"
     * @link https://cloud.yandex.ru/docs/iam/concepts/authorization/iam-token
     */
    const BEARER = 'Bearer';

    /**
     * Наименование параметра "Api-Key" в заголовке "Authorization"
     * @link https://cloud.yandex.ru/docs/iam/concepts/authorization/api-key
     */
    const API_KEY = 'Api-Key';

    /**
     * @var array Заголовки web-запроса
     */
    private $headers = [];

    /**
     * @var array Параметры задачи/запроса
     */
    private $task = [];

    /**
     * Cloud constructor.
     * @param string|null $reason OAuth-токен / IAM-токен
     * @param string|null $folderId ID каталога
     */
    public function __construct($reason = null, $folderId = null)
    {
        if (!is_null($reason))
            if (!is_null($folderId)) {
                if (strlen($folderId) > Limit::FOLDER_ID_LENGTH)
                    throw new Exception\ClientException(Message::LENGTH_ERROR);

                $this->addAuthHeader(self::BEARER,
                    $this->getIamToken($reason))
                    ->task[self::FOLDER_ID] = $folderId;
            } else
                $this->addAuthHeader(self::BEARER, $reason);
    }

    /**
     * @param string $apiKey API-ключ
     * @return static
     */
    public static function createApi($apiKey)
    {
        return (new self)->addAuthHeader(self::API_KEY, $apiKey);
    }

    /**
     * @param string $oAuthToken OAuth-токен
     * @return string IAM-токен
     */
    private function getIamToken($oAuthToken)
    {
        $response = $this->send(Url::TOKENS,
            json_encode([self::YANDEX_PASSPORT_OAUTH_TOKEN => $oAuthToken]),
            ['Content-Type: application/json']);

        return (string) json_decode($response)->iamToken;
    }

    /**
     * @param string $authType Тип аутентификации
     * @param string $reason IAM-токен / API-ключ
     * @return $this
     */
    private function addAuthHeader($authType, $reason)
    {
        $this->headers[] = sprintf("Authorization: %s %s",
            $authType,
            $reason);

        return $this;
    }

    /**
     * @param Task $task Параметры задачи/запроса
     * @return string Результат web-запроса
     */
    public function request(Task $task)
    {
        $task->addParam($this->task);

        return $this->send($task->getUrl(),
            $task->getParam(),
            array_merge($this->headers, $task->headers));
    }
}
