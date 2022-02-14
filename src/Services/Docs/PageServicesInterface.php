<?php
namespace App\Services\Docs;

use App\Entity\Page;

interface PageServicesInterface
{

    /**
     * @param Page $page
     * @param object $instance
     *
     * @return void
     */
    public function createPage(Page $page, object $instance): void;

    /**
     * @param Page $page
     *
     * @return void
     */
    public function edit(Page $page): void;

    /**
     * @param Page $page
     *
     * @return object
     */
    public function delete(Page $page): object;

}
