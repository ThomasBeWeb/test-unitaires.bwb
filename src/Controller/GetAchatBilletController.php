<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Billet;
use App\Form\CalculForm;
use App\Entity\Traitements\Calculs;

// use App\Entity\Billet;

class GetAchatBilletController extends Controller
{
    /**
     * @Route("/getbillet", name="get_achat_billet")
     */
    public function index(Request $request)
    {

        $billet = new Billet();

        $form = $this->createForm(CalculForm::class, $billet);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $billet = $form->getData();

            $billet->setPrixFinal((new Calculs)->getPrixBillet($billet));
            

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($billet);
            $entityManager->flush();

            // return $this->redirectToRoute('task_success');
        }

        return $this->render('get_achat_billet/index.html.twig', [
            'form' => $form->createView(),
            'billet' => $billet,
            'price' => $billet->getPrixFinal()
        ]);
    }

}
