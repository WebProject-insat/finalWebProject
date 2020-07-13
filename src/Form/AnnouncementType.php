<?php

namespace App\Form;

use App\Entity\Announcement;
use App\Entity\City;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnouncementType extends AbstractType
{
    /**
     * @param string $label
     * @param string $placeholder
     * @param array $options
     * @return array
     */
    private function getConfiguration($label,$placeholder,$options = []){
        return array_merge([
            'label'=>$label,
            'attr' =>[
                'placeholder' => $placeholder
            ]
        ],$options);

    }



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TexTType::class,$this->getConfiguration("Title",'Enter a super title for your announcement'))
            ->add('roomNb',IntegerType::class,$this->getConfiguration('Number of available Rooms','Enter the number of Rooms ',["attr"=>["min"=>"1"]]))
            ->add('surface')
            ->add('price',MoneyType::class,$this->getConfiguration('Price Per Month',"Enter a a price per month"))
            ->add('furnished')
            ->add('AvailabilityDate')
            ->add('Smoker')
            ->add('maxRoomates')
            ->add('balcon')
            ->add('garden')
            ->add('garage')
            ->add('CoverImage' ,UrlType::class,
                $this->getConfiguration('Principal Image Url',
                    'Enter the adresse of the principal cover Image',
                    ['attr' => [
                        'value' => 'http://placehold.it/350x150'
                    ]]))

            ->add('locatedAt' , EntityType::class,[
                'class' => City::class,
                'choice_label' => 'name'
            ])
            ->add('description',TextType::class,$this->getConfiguration('Introduction','A Global description..'))
            ->add('imagess', CollectionType::class,
                [
                    'entry_type'=> ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            ) ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Announcement::class,
        ]);
    }
}
