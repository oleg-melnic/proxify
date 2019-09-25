<?php

namespace App\Crud;

interface DeleteInterface
{
    /**
     * Удаление сущности, поддерживает массив id
     *
     * @param int|array $identity ключ может быть составным
     * @throw \S0mWeb\WTL\Crud\Exception\DeletionFailed
     *
     * @return bool
     */
    public function delete($identity);
}
