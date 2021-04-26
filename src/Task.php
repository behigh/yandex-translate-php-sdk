<?php

/**
 * Файл из репозитория Yandex-Translate-PHP-SDK
 * @link https://github.com/itpanda-llc/yandex-translate-php-sdk
 */

namespace Panda\Yandex\TranslateSdk;

/**
 * Class Kit
 * @package Panda\Yandex\TranslateSdk
 * Задача / Запрос
 */
abstract class Task
{
    /**
     * @var string[] Заголовки web-запроса
     */
    public $headers = ['Content-Type: application/json'];

    /**
     * @var array Параметры задачи/запроса
     */
    protected $task = [];

    /**
     * @param array $param Параметры задачи/запроса
     */
    public function addParam(array $param)
    {
        $this->task += $param;
    }

    /**
     * @return string URL-адрес
     */
    abstract public function getUrl();

    /**
     * @return string|null Параметры задачи/запроса
     */
    public function getParam()
    {
        return ($this->task !== [])
            ? json_encode($this->task)
            : null;
    }
}
