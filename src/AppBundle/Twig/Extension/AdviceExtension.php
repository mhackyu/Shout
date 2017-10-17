<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Entity\Advice;
use AppBundle\Entity\Shout;
use AppBundle\Entity\User;
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
            new \Twig_SimpleFilter('numOfAdvice', [$this, 'numOfAdviceFilter']),
            new \Twig_SimpleFilter('is_helpful', [$this, 'isHelpfulFilter'])
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

    public function isHelpfulFilter(User $user, Advice $advice)
    {
        $helpful = $this->doctrine->getRepository('AppBundle:FoundHelpful')
            ->findOneBy([
                'user' => $user,
                'advice' => $advice
            ]);

        if ($helpful) {
            return true;
        }

        return false;
    }
}
