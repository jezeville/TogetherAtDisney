<?php

namespace App\Controller;

use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use App\Form\BioSurFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }
    #[Route('/profil', name: 'app_profil')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        $name = $user->getName();
        $firstname = $user->getFirstname();
        $surname = $user->getSurname();
        $biography = $user->getBiography();

        $fullname = $surname ? $surname : $name ." ". $firstname;

        // Créez une instance de Cloudinary avec vos identifiants
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dxuvj7io8',
                'api_key'    => '912562256574687',
                'api_secret' => 'Or44eb6aN3d8Aq_4LTrspJMMj60',
            ],
        ]);
        $pp = $user->getPp();
            if ($pp){
                $ppUrl = $cloudinary->image($pp)->resize(Resize::fill(150, 150))->toUrl();
            }
            else{
                $ppUrl = "img/exempleProfil.png";
            }

        $photos = $user->getPhotos(); 

        $imageList = [];
            foreach ($photos as $photo) {
                $imageList[] = $photo->getPublicId();
            }
            for ($i = 0; $i < count($imageList); $i++) {
                $imageUrl = $cloudinary->image($imageList[$i])->resize(Resize::fill(150, 150))->toUrl();
                $imageUrls[] = $imageUrl;
            }
        return $this->render('profil/index.html.twig', [
            'fullname' => $fullname,
            'biography' => $biography,
            'pp' => $ppUrl,
            //Ajoutez la liste de toutes les images correspondantes à l'utilisateur
            'imageUrls' => $imageUrls, 
        ]);
    }
    #[Route('/profil/edit', name: 'app_edit')]
    public function edit(Security $security , Request $request, EntityManagerInterface $entityManager): Response
    {
            $user = $security->getUser();
            $surname = $user->getSurname();
            $biography = $user->getBiography();
            $form = $this->createForm(BioSurFormType::class, $user);
            $form->handleRequest($request);
            
            //Il faut réussir à générer un public id random et l'enregistrez sur la DB V
            $publicId = uniqid();
            // Il faut ensuite liér la public id random avec l'image et upload cela sur cloudinary
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => 'dxuvj7io8',
                    'api_key'    => '912562256574687',
                    'api_secret' => 'Or44eb6aN3d8Aq_4LTrspJMMj60',
                ],
            ]);


            if ($form->isSubmitted() && $form->isValid()) {
                $photo = $form['pp']->getData();
                $result = $cloudinary->uploadApi()->upload(
                    $photo->getRealPath(), 
                    ["public_id" => $publicId]
                );
                
                $user->setPP($publicId);
                $entityManager->persist($user);
                $entityManager->flush();
                return new RedirectResponse($this->urlGenerator->generate('app_profil'));
            }
    
            return $this->render('profil/edit.html.twig', [
                'BioSurForm' => $form->createView(),
                'surname' => $surname,
                'biography' => $biography,
            ]);
        }
    }
