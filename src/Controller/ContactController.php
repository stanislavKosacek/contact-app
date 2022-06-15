<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use App\Utils\ContactUtility;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Exception\InvalidArgumentException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ContactController extends AbstractController
{
    public function __construct(
        protected ContactRepository $contactRepository,
        protected ValidatorInterface $validator,
        protected EntityManagerInterface $em,
        protected ContactUtility $contactUtility,
        protected TranslatorInterface $translator,
    ) {
    }

    public function list(PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $this->contactRepository->createQueryBuilder('c'),
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
                ],
            ]);
        }

        return $this->render('contact/list.html.twig', $props);
    }

    public function detail(Request $request): Response
    {
        $contact = $this->contactRepository->findOneBy(['slug' => $request->get('slug')]);

        if (!$contact) {
            throw $this->createNotFoundException($this->translator->trans('contact.notFound'));
        }

        return $this->render('contact/detail.html.twig', [
            'contact' => $contact,
        ]);
    }

    public function create(Request $request): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processContactForm($form);
        }

        return $this->render('contact/createUpdate.html.twig', [
            'form' => $form->createView(),
            'edit' => false,
        ]);
    }

    public function edit(Request $request, ContactRepository $contactRepository, TranslatorInterface $translator): Response
    {
        $contact = $contactRepository->findOneBy(['slug' => $request->get('slug')]);

        if (!$contact) {
            throw $this->createNotFoundException($translator->trans('contact.notFound'));
        }

        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processContactForm($form);
        }

        return $this->render('contact/createUpdate.html.twig', [
            'form' => $form->createView(),
            'edit' => true,
        ]);
    }

    protected function processContactForm(FormInterface $form): RedirectResponse
    {
        $contact = $form->getData();
        $contact->setSlug($this->contactUtility->createSlug($contact));
        $this->validateContact($contact);
        $this->em->persist($contact);
        $this->em->flush();

        return $this->redirectToRoute('contact_detail', ['slug' => $contact->getSlug()]);
    }

    protected function validateContact(Contact $contact): void
    {
        $violations = $this->validator->validate($contact);
        if (count($violations)) {
            throw new InvalidArgumentException();
        }
    }
}
