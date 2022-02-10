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

}
