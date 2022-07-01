<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Form\EmployeFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/* 
 Vous devez importer toute les classes que vous allez utiliser
*/

class EmployeController extends AbstractController
{
    /**
     * Une fonction d'un Controller s'appelera une action.
     * Le nom de cette action (cette fonction) commencera TOUJOURS par un verbe.
     * On privilégie l'anglais, A defaut, on nomme correctement ses variables en français.
     * 
     * La route = 1param: l'uri, 2param: le nom de la route, 3param: la méthode HTTP
     * 
     * @Route("/ajouter-un-employe.html", name="employe_create", methods={"GET|POST"})
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        ////////////////// ------------ 1ere Partie : GET ------------- /////////////////

        # Variabilisation d'un nouvel objet de type Employe
        $employe = new Employe();

        # On crée dans une variable un formulaire à partir de notre prototype EmployeFormType
        # Pour faire fonctionner le mécanisme d'auto hydratation d'objet de Symfony, vous devrez passez en 2eme argument votre objet $employe.
        # Mais également que tous les noms de vos champs dans le prototype de form (EmployeFormType) aient EXACTEMENT les mêmes noms que les propriétés de la Class à laquelle il est rattaché. 
        $form = $this->createForm(EmployeFormType::class, $employe);

        # Pour que Symfony récupère les données des inputs du form, vous devrez handleRequest().
        $form->handleRequest($request);

        ////////////////// ------------ 2eme Partie : POST ------------- /////////////////

        if ($form->isSubmitted() && $form->isValid()) {

            # Cette méthode pour récupérer les données des inputs est la premiere méthode.
            # Nous utiliserons la seconde, gràce au mécanisme d'auto hydrataton de Symfony.
            // $form->get('salary')->getData();     
            
            $entityManager->persist($employe);
            $entityManager->flush();   

            return $this->redirectToRoute('default_home');
        }

        ////////////////// ------------ 1ere Partie : GET ------------- /////////////////

        # On passe en paramètre le formulaire à notre vue Twig.
        return $this->render("form/employe.html.twig", [
            "form_employe" => $form->createView() # On doit createView() sur $form
        ]);

    } # end function create()

    /**
     * @Route ("/modifier-un-employe-{id}", name="employe_update", methods={"GET|POST"})
     */
    public function update(Employe $employe, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EmployeFormType::class, $employe)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($employe);
            $entityManager->flush();

            return $this->redirectToRoute('default_home');
        } // end if()

        return $this->render("form/employe.html.twig", [
            'employe' => $employe,
            'form_employe' => $form->createView()
        ]);
    } // end function update()

    /**
     * @Route("/supprimer-un-employe-{id}", name="employe_delete", methods={"GET"})
     */
    public function delete(Employe $employe, EntityManagerInterface $entityManager): RedirectResponse
    {
        $entityManager->remove($employe);
        $entityManager->flush();

        return $this->redirectToRoute("default_home");
    } # end function delete()

} # end class
