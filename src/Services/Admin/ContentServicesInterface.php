<?php
namespace App\Services\Admin;

use App\Entity\Content;
use Symfony\Component\Form\FormInterface;

interface ContentServicesInterface
{

    /**
     * @param FormInterface $form
     * @param Content $content
     *
     * @return void
     */
    public function store(FormInterface $form, Content $content);

    /**
     * @return array|null
     */
    public function all(): ?array;

    /**
     * @param Content $content
     *
     * @return object
     */
    public function delete(Content $content): object;

}
