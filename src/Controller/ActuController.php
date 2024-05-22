<?php

namespace App\Controller;

use App\Entity\Photo;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Resize;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ActuController extends AbstractController
{
    #[Route('/actu', name: 'app_actu')]
    public function randomImages(EntityManagerInterface $entityManager)
    {

        $photos = $entityManager->getRepository(Photo::class)->findAll();
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => 'dxuvj7io8',
                'api_key'    => '912562256574687',
                'api_secret' => 'Or44eb6aN3d8Aq_4LTrspJMMj60',
            ],
        ]);

        $imageList = [];
        foreach ($photos as $photo) {
            $imageList[] = $photo->getPublicId();
        }
        for ($i = 0; $i < count($imageList); $i++) {
            $imageUrl = $cloudinary->image($imageList[$i])->resize(Resize::fill(250, 300))->toUrl();
            $imageUrls[] = $imageUrl;
        }


        return $this->render('actu/index.html.twig', [
            'imageUrls' => $imageUrls,
        ]);
    }
}
