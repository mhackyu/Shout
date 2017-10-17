<?php

namespace AppBundle\Twig\Extension;

use AppBundle\Entity\Shout;
use AppBundle\Entity\User;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class LoudExtension
 * This Twig extension handles loud reactions inside Twig template.
 * @author Mark Christian Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Twig\Extension
 */
class LoudExtension extends \Twig_Extension
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'loud_extension';
    }

    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('isLoud', [$this, 'isLoudFilter']),
            new \Twig_SimpleFilter('numOfLoud', [$this, 'numOfLoudFilter'])
        ];
    }

    public function isLoudFilter(User $user, Shout $shout)
    {
        $loud = $this->doctrine->getRepository('AppBundle:Loud')
            ->findOneBy([
                'user' => $user,
                'shout' => $shout
            ]);

        if ($loud) {
            return true;
        }

        return false;
    }

    public function numOfLoudFilter(Shout $shout)
    {
        $loud = $this->doctrine->getRepository('AppBundle:Loud')
            ->findBy([
                'shout' => $shout
            ]);

        return count($loud);
    }
}
