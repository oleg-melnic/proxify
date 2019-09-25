<?php

namespace App\Crud\Helper;

use App\Crud\Exception\DeletionFailed;

trait DeleteTrait
{
    /**
     * @param int $identity
     * @throws DeletionFailed
     * @return bool
     */
    public function delete($identity)
    {
        if (!is_array($identity)) {
            $identity = [$identity];
        } else {
            trigger_error('Пакетное удаление запрещено.');
        }

        foreach ($identity as $itemIdentity) {
            try {
                $entity = $this->find($itemIdentity);

                $this->em->remove($entity);
                $this->em->flush();
            } catch (\Exception $exception) {
                throw new DeletionFailed(
                    sprintf('Объект с id "%s" не был удален', $itemIdentity),
                    $exception->getCode(),
                    $exception
                );
            }
        }

        return true;
    }
}
