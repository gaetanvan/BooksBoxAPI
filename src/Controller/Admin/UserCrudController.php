<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
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

    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setUuid(Uuid::v4()); // Générer un UUID aléatoire
        return $user;
    }
    public function persistEntity($entity)
    {
        $entity->setPassword(
            $this->passwordEncoder->encodePassword(
                $entity,
                $entity->getPassword()
            )
        );

        parent::persistEntity($entity);
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
