<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $props = [
            'pagination' => $pagination,
            'itemsCount' => [
                'currentLow' => (($pagination->getCurrentPageNumber() - 1) * $pagination->getItemNumberPerPage()) + 1 < $pagination->getTotalItemCount() ? (($pagination->getCurrentPageNumber() - 1) * $pagination->getItemNumberPerPage()) + 1 : $pagination->getTotalItemCount(),
                'currentHigh' => (($pagination->getCurrentPageNumber() - 1) * $pagination->getItemNumberPerPage()) + $pagination->getItemNumberPerPage() < $pagination->getTotalItemCount() ? (($pagination->getCurrentPageNumber() - 1) * $pagination->getItemNumberPerPage()) + $pagination->getItemNumberPerPage() : $pagination->getTotalItemCount(),
                'total' => $pagination->getTotalItemCount(),
            ],
        ];

        if ($request->headers->get('content-type') === 'application/json') {
            $tableView = $this->renderView('contact/partial/listTable.html.twig', $props);
            $paginationView = $this->renderView('common/pagination.html.twig', $props);

            return new JsonResponse([
                'snippets' => [
                    'table' => $tableView,
                    'pagination' => $paginationView,
                ]
            ]);
        }

        return $this->render('contact/list.html.twig', $props);
    }
}
