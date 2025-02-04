<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\DTO\ClientSearchDTO;
use App\Enums\AccountStatusEnum;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClientSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nom',
                'required' => false,
            ])
            ->add('accountStatus', ChoiceType::class, [
                'label' => 'Compte',
                'choices' => [
                    'Oui' => AccountStatusEnum::TRUE,
                    'Non' => AccountStatusEnum::FALSE,
                ],
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClientSearchDTO::class,
        ]);
    }
}
