<?php

namespace Badger\GameBundle\Factory;

use Badger\GameBundle\Entity\Adventure;
use Badger\GameBundle\Entity\AdventureStep;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */
class AdventureFactory implements SimpleFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create()
    {
        $adventure = new Adventure();
        $adventure->addStep(new AdventureStep());

        return $adventure;
    }
}
