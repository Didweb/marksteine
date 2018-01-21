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
use AppBundle\Entity\Country;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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

        $builder->add('dayStart', ChoiceType::class, array(
                      'choices' => range(0, 31),
                      'placeholder' => 'Day',
                      'required' => false
        ));
        $builder->add('monthStart', ChoiceType::class, array(
                      'choices' => range(0, 12),
                      'placeholder' => 'Month',
                      'required' => false
        ));
        $builder->add('yearStart');

        $builder->add('dayEnd', ChoiceType::class, array(
                      'choices' => range(0, 31),
                      'placeholder' => 'Day',
                      'required' => false
        ));
        $builder->add('monthEnd', ChoiceType::class, array(
                      'choices' => range(0, 12),
                      'placeholder' => 'Month',
                      'required' => false
        ));
        $builder->add('yearEnd');
        $builder->add('countrys', EntityType::class, array(
                      'class' => Country::class,
                      'choice_label' => 'name',
                      'choice_value' => 'id',
                      'multiple' => true,
                      'expanded' => true,
        ));
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
        return 'appbundle_polity';
    }
}
