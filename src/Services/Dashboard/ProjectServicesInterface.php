<?php
namespace App\Services\Dashboard;

use App\Entity\Project;
use App\Entity\ProjectImage;
use App\Entity\ProjectTask;
use Symfony\Component\HttpFoundation\Request;

interface ProjectServicesInterface
{

    /**
     * @return array
     */
    public function listProjects(): array;

    /**
     * @param Project $project
     *
     * @return array
     */
    public function edit(Project $project): array;

    /**
     * @return object
     */
    public function create(Request $request): object;

    /**
     * @param Request $request
     * @param Project $project
     *
     * @return object
     */
    public function store(Request $request, Project $project): object;

    /**
     * @param Project $project
     *
     * @return object
     */
    public function delete(Project $project): object;

    /**
     * @param Project $project
     * @param Request $request
     *
     * @return object
     */
    public function createTask(Project $project, Request $request): object;

    /**
     * @param ProjectTask $task
     * @param Request $request
     *
     * @return object
     */
    public function editTask(ProjectTask $task, Request $request): object;

    /**
     * @param ProjectTask $task
     *
     * @return object
     */
    public function deleteTask(ProjectTask $task): object;

    /**
     * @param Project $project
     * @param Request $request
     *
     * @return object
     */
    public function createImage(Project $project, Request $request): object;

    /**
     * @param ProjectImage $image
     *
     * @return object
     */
    public function editImage(ProjectImage $image, Request $request): object;

    /**
     * @param ProjectImage $image
     *
     * @return object
     */
    public function deleteImage(ProjectImage $image): object;

}
