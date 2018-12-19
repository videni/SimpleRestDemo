<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type as FormType;

class CommentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', FormType\TextType::class)
            ->add('published_at', FormType\DateTimeType::class, [
                'property_path'=> 'publishedAt',
                'widget'=>'single_text',
                'format' => 'yyyy-MM-dd H:i:s',
            ])
        ;
    }
}
