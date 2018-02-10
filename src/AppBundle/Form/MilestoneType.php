<?php
/**
 * Class EraType | AppBundle/Form/EraType.php
 *
 * @package     AppBundle
 * @author      Eduard Pinuaga <info@did-web.com>
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use AppBundle\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

/**
 * Formular for Era
 */
class MilestoneType extends AbstractType
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
        $builder->add('title', TextType::class, array('required'=> true));
        $builder->add('description', TextareaType::class, array('required'=> true));
        $builder->add('type', EntityType::class, array(
                                      // looks for choices from this entity
                                      'class' => Type::class,
                                      'query_builder' => function (EntityRepository $er) {
                                              return $er->createQueryBuilder('t')
                                                  ->orderBy('t.name', 'ASC');
                                      },
                                      'choice_label' => 'name',
                                      'required'=> true
                                  ));
        $builder->add('day', ChoiceType::class, array(
                      'choices' => range(0, 31),
                      'placeholder' => 'Day',
                      'required' => true
        ));
        $builder->add('month', ChoiceType::class, array(
                      'choices' => range(0, 12),
                      'placeholder' => 'Month',
                      'required' => true
        ));
        $builder->add('year', IntegerType::class, array('required'=> true));
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
            'data_class' => 'AppBundle\Entity\Milestone'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_milestone';
    }
}
