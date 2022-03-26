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

    /**
     * @param Chapter $chapter
     *
     * @return void
     */
    public function editChapter(Chapter $chapter): void;

    /**
     * @param Chapter $chapter
     *
     * @return object
     */
    public function delete(Chapter $chapter): object;

    /**
     * @param Chapter $chapter
     * 
     * @return array
     */
    public function show(Chapter $chapter):array;

}
