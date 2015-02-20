<?php

namespace Ilios\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CompetencyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('school', 'single_related', [
                'required' => false,
                'entityName' => "IliosCoreBundle:School"
            ])
            ->add('parent', 'single_related', [
                'required' => false,
                'entityName' => "IliosCoreBundle:Competency"
            ])
            ->add('aamcPcrses', 'many_related', [
                'required' => false,
                'entityName' => "IliosCoreBundle:AamcPcrs"
            ])
            ->add('programYears', 'many_related', [
                'required' => false,
                'entityName' => "IliosCoreBundle:ProgramYear"
            ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ilios\CoreBundle\Entity\Competency'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'competency';
    }
}