<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Entity\Login;
use App\Form\Type\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    
    #[Route('/', name: 'home')]
    public function home(Request $request): Response
    {
    $task = new Login();

        $form = $this->createForm(TaskType::class, $task);
        
         $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
             // $form->getData();
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            
             $this->entityManager->persist($task);
            $this->entityManager->flush();


            return $this->redirectToRoute('page');
        }

         return $this->render('home/HomePge.html.twig', [
            'form' => $form->createView(),
        ]);
        
    
    }
    #[Route('/page', name: 'page')]
    public function page(): Response
    {
      
        return new Response('ajouter avec success !');
    }
   
}