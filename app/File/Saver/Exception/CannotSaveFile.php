<?php

namespace App\File\Saver\Exception;

/**
 * Class CannotSaveFile
 * Ошибка возникающая в случае, если файл не удалось сохранить
 */
class CannotSaveFile extends \InvalidArgumentException implements ExceptionInterface
{
}
