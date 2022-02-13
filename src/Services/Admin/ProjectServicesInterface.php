<?php
namespace App\Services\Admin;

use App\Entity\Project;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

interface ProjectServicesInterface
{

    /**
     * @return array
     */
    public function listProjects(): array;

    /**
     * @param Request $request
     * @param Project $project
     *
     * @return object
     */
    public function store(FormInterface $form, Project $project);

    /**
     * @param Project $project
     *
     * @return object
     */
    public function delete(Project $project): object;

}
