<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    public function list(ContactRepository $contactRepository): Response
    {
        return $this->render('contact/list.html.twig', [
            'contacts' => $contactRepository->findAll(),
        ]);
    }
}
