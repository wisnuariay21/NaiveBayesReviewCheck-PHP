<?php

declare(strict_types=1);

namespace Phpml\Math\Distance;

use Phpml\Exception\InvalidArgumentException;
use Phpml\Math\Distance;

class Jaccard implements Distance
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
            if(pow($m,2) +  pow($n,2) - ($m*$n) == 0){
                return 0;
            }
            return $m * $n/(pow($m,2) +  pow($n,2) - ($m*$n));
        }, $a, $b));
    }
}
