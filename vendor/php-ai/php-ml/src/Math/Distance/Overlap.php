<?php

declare(strict_types=1);

namespace Phpml\Math\Distance;

use Phpml\Exception\InvalidArgumentException;
use Phpml\Math\Distance;

class Overlap implements Distance
{
    /**
     * @throws InvalidArgumentException
     */
    public function distance(array $a, array $b): float
    {
        if (count($a) !== count($b)) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        return array_sum(array_map(function ($m, $n) {
            if(min(pow($m,2) ,  pow($n,2)) == 0){
                return 0;
            }
            return $m * $n/(min(pow($m,2) ,  pow($n,2)));
        }, $a, $b));
    }
}
