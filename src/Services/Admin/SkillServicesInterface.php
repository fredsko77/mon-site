<?php
namespace App\Services\Admin;

use App\Entity\GroupSkill;
use Symfony\Component\Form\FormInterface;

interface SkillServicesInterface
{

    /**
     * @return array
     */
    public function index(): array;

    /**
     * @param GroupSkill $groupSkill
     * @param FormInterface $form
     */
    public function store(GroupSkill $groupSkill, FormInterface $form);

    /**
     * @param GroupSkill $groupSkill
     *
     * @return object
     */
    public function delete(GroupSkill $groupSkill): object;
}
