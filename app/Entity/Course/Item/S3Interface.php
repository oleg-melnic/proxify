<?php

namespace App\Entity\Course\Item;

interface S3Interface
{
    /**
     * @return string
     */
    public function getFileName();
}
