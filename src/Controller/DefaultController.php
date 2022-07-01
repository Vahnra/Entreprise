<?php

namespace App\Controller;

use App\Entity\Employe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/", name="default_home")
     */
    public function home(EntityManagerInterface $entityManager): Response
    {
        # On récupère dans la variable $employes TOUS les employés enregistrés en BDD.
        $employes = $entityManager->getRepository(Employe::class)->findAll();

        return $this->render("default/home.html.twig", [
            # On passe le tableau (array $employes) d'employés à Twig.
            "employes" => $employes
        ]);
    }

}
