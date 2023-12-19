<?php

use Monolog\Logger;
use Security\Authenticator;
use Logger\DatabaseHandler;
use Entity\Book;
use Entity\Editor;
use Entity\Loan;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var Request $request
 * @var int $id
 * @var ValidatorInterface $validator
 **/

$bookRepository = $entityManager->getRepository(Book::class);
$book = $bookRepository->find($id);

$arrayViolations = [];

if (Authenticator::is_authenticated()) {
    $editorRepository = $entityManager->getRepository(Editor::class);
    $editors = $editorRepository->findAll();

    if (Request::METHOD_POST == $request->getMethod()) {
        $editorId = $request->get('editor');
        $editor = $editorRepository->find($editorId);

        $isLoaned = $request->get('isLoaned') == '1';
        $book
            ->setTitre($request->get('title'))
            ->setAuteur($request->get('author'))
            ->setAnneePublication(new \DateTime($request->get('yearOfPublication')))
            ->setEditeur($editor)
            ->setISBN($request->get('ISBN'))
            ->setIsLoaned($isLoaned);

        $loanViolations = [];
        if ($isLoaned) {
            $loan = new Loan();
            $loan->setBook($book);
            $loan->setBorrowerName($request->get('borrowerName'));
            $loan->setBorrowerEmail($request->get('borrowerEmail'));
            $loan->setLoanDate(new \DateTime($request->get('loanDate') ?: 'now'));

            $loanViolations = $validator->validate($loan);
            if (count($loanViolations) === 0) {
                $entityManager->persist($loan);
            }
        }

        $bookViolations = $validator->validate($book);

        if (count($bookViolations) === 0 && count($loanViolations) === 0) {
            $entityManager->flush();

            $customHandler = new DatabaseHandler($entityManager);
            $logger = new Logger('app');
            $logger->pushHandler($customHandler);
            $logger->info('Livre mis à jour par ' . Authenticator::getUser() . ' : ' . $book->getTitre());

            return new RedirectResponse('/book');
        } else {
            foreach ($bookViolations as $violation) {
                $arrayViolations[$violation->getPropertyPath()][] = $violation->getMessage();
            }
            foreach ($loanViolations as $violation) {
                $arrayViolations[$violation->getPropertyPath()][] = $violation->getMessage();
            }
        }
    }
    return new Response($twig->render('book/update.html.twig', ['book' => $book, 'violations' => $arrayViolations, 'editors' => $editors]));
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
