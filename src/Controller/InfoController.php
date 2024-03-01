<?php

namespace App\Controller;
header("Access-Control-Allow-Origin: *");
use App\Form\InfoType;
use App\Repository\InfoRepository;
use App\Service\ImportInfoService;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class InfoController extends AbstractController
{
    private ManagerRegistry $doctrine;
    private ImportInfoService $importInfoService;
    public function __construct(ManagerRegistry $doctrine,ImportInfoService $importInfoService)
    {
        $this->doctrine = $doctrine;
        $this->importInfoService = $importInfoService;
    }

    #[Route('/', name: 'inport')]
    public function index2(
        InfoRepository $repository,
        Request $request): Response
    {
      
           $infos= $repository->findAll();
       

        return $this->render('pages/importFile.html.twig', [
            'infos' =>$infos
        ]);
    }
     

    #[Route('/info', name: 'info.index')]
    public function index(
        InfoRepository $repository,
        Request $request): Response
    {
      
           $infos= $repository->findAll();
       

        return $this->render('pages/index.html.twig', [
            'infos' =>$infos
        ]);
    }
     
    #[Route("/upload-excel", name:"xlsx", methods: ["POST","OPTIONS", "get"])]
    public function xslx(Request $request)
    {
           
        $file = $request->files->get('file');
      //dd($file);
        $fileFolder = $this->getParameter('kernel.project_dir') . '/public/uploads/'; 
        $filePathName = md5(uniqid()) . '.' . $file->getClientOriginalExtension(); 
        $file->move($fileFolder, $filePathName);
        $spreadsheet = IOFactory::load($fileFolder . $filePathName); 
        $spreadsheet->getActiveSheet()->removeRow(1); 
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true); 
        
        foreach ($sheetData as $Row) 
        { 
                $nomGroupe = $Row['A'];  
                $origine = $Row['B']; 
                $ville= $Row['C'];     
                $anneeDebut =(float) $Row['D'];
                $anneeSeparation = (float) $Row['E'];
                $fondateurs = $Row['F'];
                $membres = (int) $Row['G'];
                $courantMusical = $Row['H'];
                $presentation = $Row['I'];
                $this->importInfoService->create(strval($nomGroupe),strval($origine),strval($ville),$anneeDebut,$anneeSeparation,strval($fondateurs),$membres,strval($courantMusical),strval($presentation));
        }

        return $this->redirectToRoute('info.index');
    }


    #[Route('/info/suppression/{id}', 'info.delete' , methods: ['get'])]
    public function delete(
        InfoRepository $repository,
        EntityManagerInterface $manager,
        int $id
        ): Response
    {
       $info = $repository->findOneBy(["id" => $id]);
       if(!$info){
        $this->addFlash(
            'success',
            'La ligne en question n\'a pas été trouvé !'
        );
        return $this->redirectToRoute('info.index');
       } 
       $manager->remove($info);
       $manager->flush();
       $this->addFlash(
        'success',
        'Votre ligne a été supprimé avec succès !'
    );

    return $this->redirectToRoute('info.index');

    }

    #[Route('/info/edition/{id}', name: 'info.edit', methods: ['GET', 'POST'])]
    public function edit(
        InfoRepository $repository,
        Request $request,
        EntityManagerInterface $manager,
        int $id
    ): Response {
    
        $info= $repository->findOneBy(["id" => $id]);
        $form = $this->createForm(InfoType::class, $info);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $info = $form->getData();

            $manager->persist($info);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre ligne a été modifié avec succès !'
            );

            return $this->redirectToRoute('info.index');
        } 

        return $this->render('pages/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/info/detail/{id}', name: 'info.detail', methods: ['GET'])]
    public function detail(
        InfoRepository $repository,
        Request $request,
        EntityManagerInterface $manager,
        int $id
    ): Response {
        $info= $repository->findOneBy(["id" => $id]);
        return $this->render('pages/detail.html.twig', [
            'info' => $info,
        ]);
    }
}    