<?php

namespace App\Services;

class ShippingService
{
    // Define base rates by postcode ranges (example rates)
    private $postcodeRates = [
        '2000-2999' => 10.00, // Example for NSW postcodes
        '3000-3999' => 12.00, // Example for VIC postcodes
        '4000-4999' => 15.00, // Example for QLD postcodes
        '5000-5999' => 18.00, // Example for SA postcodes
        '6000-6999' => 20.00, // Example for WA postcodes
        '7000-7999' => 25.00, // Example for TAS postcodes
    ];

    private $weightRate = 2.00; // Cost per kilogram

    /**
     * Calculate the shipping cost based on postcode and weight.
     *
     * @param string $postcode
     * @param float $weight
     * @return float
     */
    public function calculateShippingCost($postcode, $weight)
    {
        $baseRate = $this->getBaseRateForPostcode($postcode);

        // Calculate the weight-based cost
        $weightCost = $weight * $this->weightRate;

        return $baseRate + $weightCost;
    }

    /**
     * Get the base rate for a given postcode.
     *
     * @param string $postcode
     * @return float
     */
    private function getBaseRateForPostcode($postcode)
    {
        foreach ($this->postcodeRates as $range => $rate) {
            [$start, $end] = explode('-', $range);
            if ($postcode >= $start && $postcode <= $end) {
                return $rate;
            }
        }

        // Default rate if postcode doesn't match any range
        return 1000.00;
    }
}
