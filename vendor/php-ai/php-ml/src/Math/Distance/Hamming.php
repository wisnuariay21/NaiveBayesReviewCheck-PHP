<?php

declare(strict_types=1);

namespace Phpml\Math\Distance;

use Phpml\Exception\InvalidArgumentException;
use Phpml\Math\Distance;

class Hamming implements Distance
{
    /**
     * @throws InvalidArgumentException
     */
    public function distance(array $a, array $b): float
    {
        if (count($a) !== count($b)) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        $differences = [];
        $count = count($a);

        for ($i = 0; $i < $count; ++$i) {
            if ($a[$i] > 0 && $b[$i] > 0) {
                return 0;
            }
            else if($a[$i] == 0 && $b[$i] == 0){
                return 0; 
            }
            else  if($a[$i] > 0 && $b[$i] == 0){
                return 1;
            }
            else if($a[$i] == 0 && $b[$i] > 0){
                return 1;
            }
            // $differences[] = abs($a[$i] - $b[$i]);
        }

        return max($differences);
    }
}
