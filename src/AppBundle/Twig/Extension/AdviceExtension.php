<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Entity\Shout;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class AdviceExtension
 * This Twig extension handles advice inside Twig templates.
 * @author Mark Christian Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Twig\Extension
 */
class AdviceExtension extends \Twig_Extension
{
    public $doctrine;

    function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'advice_extension';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('numOfAdvice', [$this, 'numOfAdviceFilter'])
        ];
    }

    public function numOfAdviceFilter(Shout $shout)
    {
        $advice = $this->doctrine->getRepository('AppBundle:Advice')
            ->findBy([
                'shout' => $shout
            ]);

        return count($advice);
    }
}
