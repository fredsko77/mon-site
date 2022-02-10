<?php
namespace App\Services\Docs;

use App\Entity\Chapter;

interface ChapterServicesInterface
{

    /**
     * @param Chapter $chapter
     * @param object $instance
     *
     * @return void
     */
    public function createChapter(Chapter $chapter, object $instance): void;

}
