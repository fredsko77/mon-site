<?php
namespace App\Services;

use App\Entity\Contact;

interface WebSiteServicesInterface
{

    public function index(): array;

    public function contact(Contact $contact): void;

    public function projects(): ?array;

}
