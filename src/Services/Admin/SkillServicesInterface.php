<?php
namespace App\Services\Admin;

use App\Entity\GroupSkill;
use Symfony\Component\HttpFoundation\Request;

interface SkillServicesInterface
{

    /**
     * @return array
     */
    public function index(): array;

    /**
     * @param Request $request
     * @param GroupSkill $groupSkill
     */
    public function store(GroupSkill $groupSkill);

    /**
     * @param GroupSkill $groupSkill
     *
     * @return object
     */
    public function delete(GroupSkill $groupSkill): object;
}
