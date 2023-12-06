<?php
use Entity\Book;
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

if(Request::METHOD_POST == $request->getMethod()){
    $book
        ->setTitre($request->get('title'))
        ->setAuteur($request->get('author'))
        ->setAnneePublication(new \DateTime($request->get('yearOfPublication')))
        ->setEditeur($request->get('editor'))
        ->setISBN($request->get('ISBN'));

    $violations = $validator->validate($book);

    if($violations->count()==0){
        $entityManager->persist($book);
        $entityManager->flush();

        return new RedirectResponse('/book');

    }
    foreach ($violations as $violation){
        $arrayViolations[$violation->getPropertyPath()][] = $violation->getMessage();    }
}

return new Response($twig->render('book/_form.html.twig',['book' => $book,'violations'=>$arrayViolations]));

?>