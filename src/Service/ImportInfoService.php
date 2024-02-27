<?php

namespace App\Service;

use App\Entity\Info;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;



class ImportInfoService 
{
   
    private ManagerRegistry $doctrine;
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    public function create(string $nomGroupe, string $origin, string $ville, float $anneeDebut, float $anneeSeparation, string $fondateurs, int $membres, string $courantMusical, string $presentation)
    {
        $entityManager = $this->doctrine->getManager();
    
        $info = new Info();
        $info->setNomDuGroupe($nomGroupe);
        $info->setOrigine($origin);
        $info->setVille($ville);
        $info->setAnneeDebut($anneeDebut);
        $info->setanneeSeparation($anneeSeparation);
        $info->setFondateur($fondateurs);
        $info->setMembre($membres);
        $info->setCourantMusicale($courantMusical);
        $info->setpresentation($presentation);

        $entityManager->persist($info);
        $entityManager->flush();
    }

}