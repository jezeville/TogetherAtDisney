<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\AddType;
use DateTimeImmutable;
use Cloudinary\Cloudinary;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddController extends AbstractController
{
    public function __construct(private UrlGeneratorInterface $urlGenerator)
    {
    }
    #[Route('/add', name: 'app_add')]
    public function index(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $photo = new Photo();
        $form = $this->createForm(AddType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $security->getUser();

            $publicId = uniqid();

            // Récupérer la date et l'heure actuelles
            $currentDateTime = new \DateTimeImmutable();

            // Configuration de Cloudinary
            $cloudinary = new Cloudinary([
                'cloud' => [
                    'cloud_name' => 'dxuvj7io8',
                    'api_key'    => '912562256574687',
                    'api_secret' => 'Or44eb6aN3d8Aq_4LTrspJMMj60',
                ],
            ]);

            // Récupérer le fichier téléchargé depuis le formulaire
            $file = $form['publicId']->getData();

            // Téléverser le fichier sur Cloudinary
            $result = $cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                ["public_id" => $publicId]
            );

            // Associer l'utilisateur à la photo
            $photo->setUser($user);

            // Définir l'identifiant public de la photo
            $photo->setPublicId($publicId);

            // Définir la date et l'heure de création de la photo
            $photo->setCreatedAt($currentDateTime);

            // Enregistrer la photo
            $entityManager->persist($photo);
            $entityManager->flush();
            return new RedirectResponse($this->urlGenerator->generate('app_profil'));
        }

        // Afficher le formulaire
        return $this->render('add/index.html.twig', [
            'AddForm' => $form->createView(),
        ]);
    }
}
