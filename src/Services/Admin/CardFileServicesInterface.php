<?php
namespace App\Services\Admin;

use App\Entity\CardFile;

interface CardFileServicesInterface
{

    /**
     * @param CardFile $cardFile
     *
     * @return void
     */
    public function deleteFile(CardFile $cardFile): void;

}
