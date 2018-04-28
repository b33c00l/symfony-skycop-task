<?php

namespace App\Repository;

use App\Entity\Flight;

class FlightRepository
{
    /**
     * @param $filepath
     * @return \Generator
     */
    public function getAllFlights($filepath)
    {
        $file = fopen($filepath, 'r');

        try {
            while ($line = fgetcsv($file)) {
                list($country, $status, $details ) = $line;
                yield new Flight($country, $status, $details);
            }
        }
        finally {
            fclose($file);
        }
    }

}