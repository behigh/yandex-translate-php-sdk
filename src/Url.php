<?php

/**
 * Файл из репозитория Yandex-Translate-PHP-SDK
 * @link https://github.com/itpanda-llc/yandex-translate-php-sdk
 */

namespace Panda\Yandex\TranslateSdk;

/**
 * Class Url
 * @package Panda\Yandex\TranslateSdk
 * URL-адреса
 */
class Url
{
    /**
     * Получение IAM-токена для аккаунта на Яндексе
     * @link https://cloud.yandex.ru/docs/iam/operations/iam-token/create
     */
    const TOKENS = 'https://iam.api.cloud.yandex.net/iam/v1/tokens';

    /**
     * Определение языка текста
     * @link https://cloud.yandex.ru/docs/translate/api-ref/Translation/detectLanguage
     */
    const DETECT = 'https://translate.api.cloud.yandex.net/translate/v2/detect';

    /**
     * Получение списка поддерживаемых языков
     * @link https://cloud.yandex.ru/docs/translate/api-ref/Translation/listLanguages
     */
    const LANGUAGES = 'https://translate.api.cloud.yandex.net/translate/v2/languages';

    /**
     * Перевод текста
     * @link https://cloud.yandex.ru/docs/translate/api-ref/Translation/translate
     */
    const TRANSLATE = 'https://translate.api.cloud.yandex.net/translate/v2/translate';
}
