<?php
/**
 * Class PolityType | AppBundle/Form/PolityType.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Polity;

/**
 * Formular for Polity
 */
class PolityType extends AbstractType
{
    /**
     * BuildFormular
     * {@inheritdoc}
     *
     * @param FormBuilderInterface   $builder Service FormBuilderInterface
     * @param string[]               $options List Options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('description');
        $builder->add('yearStart');
        $builder->add('monthStart');
        $builder->add('dayStart');
        $builder->add('yearEnd');
        $builder->add('monthEnd');
        $builder->add('dayEnd');
    }

    /**
     * Config options.
     * {@inheritdoc}
     *
     * @param OptionsResolver   $resolver Service OptionsResolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Polity'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_country';
    }
}
