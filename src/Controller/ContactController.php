<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ContactController extends AbstractController
{
    public function list(ContactRepository $contactRepository): JsonResponse
    {
        return new JsonResponse(['contact-list']);
    }
}
