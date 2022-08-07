<?php

namespace Plugin\ProductDisplayRank4\Form\Type\Admin;


use Eccube\Common\EccubeConfig;
use Plugin\ProductDisplayRank4\Entity\Config;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ConfigType extends AbstractType
{
    /**
     * @var EccubeConfig
     */
    protected $eccubeConfig;

    /**
     * CustomerType constructor.
     *
     * @param EccubeConfig $eccubeConfig
     */
    public function __construct(EccubeConfig $eccubeConfig)
    {
        $this->eccubeConfig = $eccubeConfig;
    }


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['max' => 255]),
                ],
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    '降順(大きい数字の商品を先に表示)' => Config::ORDER_BY_DESCENDING,
                    '昇順(小さい数字の商品を先に表示)' => Config::ORDER_BY_ASCENDING,
                ],
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('csv_import_default_rank', IntegerType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'max' => $this->eccubeConfig['eccube_int_len'],
                    ]),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Config::class,
        ]);
    }
}
