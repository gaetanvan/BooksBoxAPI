<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Endroid\QrCode\QrCode;
use Ramsey\Collection\Collection;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Uid\Uuid;

class UserCrudController extends AbstractCrudController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('mail'),
            TextField::new('avatar'),
            TextField::new('Uuid'),
            CollectionField::new('roles'),
            TextField::new('password'),
            TextField::new('QRCode')->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setUuid(Uuid::v4()); // Générer un UUID aléatoire
        return $user;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // Génère un QR Code pour l'utilisateur
        $qrText = $entityInstance->getUuid(); // Utilisez l'identifiant de l'utilisateur pour créer un texte unique
        $qrCode = new QrCode($qrText);
        $qrCode->setSize(300);
        $qrImage = $qrCode->getData(); // Enregistre le QR Code généré sous forme de données URI

        // Enregistre le QR Code généré dans la propriété "qrCode" de l'utilisateur
        $entityInstance->setQrCode($qrImage);

        // Appelle la méthode persistEntity() du parent pour enregistrer l'utilisateur
        parent::persistEntity($entityManager, $entityInstance);
    }

}
