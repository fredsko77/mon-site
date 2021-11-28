<?php
namespace App\Services\Admin;

use App\Entity\Skill;
use Symfony\Component\HttpFoundation\Request;

interface SkillServicesInterface
{

    /**
     * @return array
     */
    public function index(): array;

    /**
     * @param Request $request
     * @param Skill $skill
     *
     * @return object
     */
    public function create(Request $request): object;

    /**
     * @return array
     */
    public function edit(Skill $skill): array;

    /**
     * @param Request $request
     * @param Skill $skill
     *
     * @return object
     */
    public function store(Request $request, Skill $skill): object;

    /**
     * @param Skill $skill
     *
     * @return object
     */
    public function delete(Skill $skill): object;
}
