<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    public function list(ContactRepository $contactRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $contactRepository->createQueryBuilder('c'),
            $request->query->getInt('page', 1),
            (int) $this->getParameter('contactsPerPage')
        );

        return $this->render('contact/list.html.twig', [
            'pagination' => $pagination,
            'itemsCount' => [
                'currentLow' => (($pagination->getCurrentPageNumber() - 1) * $pagination->getItemNumberPerPage()) + 1 < $pagination->getTotalItemCount() ? (($pagination->getCurrentPageNumber() - 1) * $pagination->getItemNumberPerPage()) + 1 : $pagination->getTotalItemCount(),
                'currentHigh' => (($pagination->getCurrentPageNumber() - 1) * $pagination->getItemNumberPerPage()) + $pagination->getItemNumberPerPage() < $pagination->getTotalItemCount() ? (($pagination->getCurrentPageNumber() - 1) * $pagination->getItemNumberPerPage()) + $pagination->getItemNumberPerPage() : $pagination->getTotalItemCount(),
                'total' => $pagination->getTotalItemCount(),
            ],
        ]);
    }
}
