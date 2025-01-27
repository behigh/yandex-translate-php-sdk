<?php

/**
 * Файл из репозитория Yandex-Translate-PHP-SDK
 * @link https://github.com/itpanda-llc/yandex-translate-php-sdk
 */

namespace Panda\Yandex\TranslateSdk;

/**
 * Class Detect
 * @package Panda\Yandex\TranslateSdk
 * Определение языка текста
 */
class Detect extends Task
{
    /**
     * Наименования параметра "Текст, язык которого требуется определить"
     * @link https://cloud.yandex.ru/docs/translate/api-ref/Translation/detectLanguage
     */
    const TEXT = 'text';

    /**
     * Наименование параметра "Список наиболее вероятных языков"
     * @link https://cloud.yandex.ru/docs/translate/api-ref/Translation/detectLanguage
     */
    const LANGUAGE_CODE_HINTS = 'languageCodeHints';

    /**
     * Detect constructor.
     * @param string|null $text Текст, язык которого требуется определить
     */
    public function __construct($text = null)
    {
        if (!is_null($text)) $this->setText($text);
    }

    /**
     * @return string URL-адрес
     */
    public function getUrl()
    {
        return Url::DETECT;
    }

    /**
     * @param string $text Текст, язык которого требуется определить
     * @return $this
     */
    public function setText($text)
    {
        if (mb_strlen($text) > Limit::DETECT_TEXT_LENGTH)
            throw new Exception\ClientException(Message::LENGTH_ERROR);

        $this->task[self::TEXT] = $text;

        return $this;
    }

    /**
     * @param string $codeHint Наиболее вероятный язык
     * @return $this
     */
    public function addHint($codeHint)
    {
        if (mb_strlen($codeHint) > Limit::LANGUAGE_CODE_LENGTH)
            throw new Exception\ClientException(Message::LENGTH_ERROR);

        $codeHintCount = count(isset($this->task[self::LANGUAGE_CODE_HINTS]) ? $this->task[self::LANGUAGE_CODE_HINTS] : []);

        if (++$codeHintCount > Limit::LANGUAGE_CODE_HINTS_COUNT)
            throw new Exception\ClientException(Message::COUNT_ERROR);

        $this->task[self::LANGUAGE_CODE_HINTS][] = $codeHint;

        $this->task[self::LANGUAGE_CODE_HINTS] =
            array_unique($this->task[self::LANGUAGE_CODE_HINTS]);

        return $this;
    }
}
