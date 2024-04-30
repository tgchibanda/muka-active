<?php

namespace App\Enums;

/**
 * Class AddressType
 * 
 * @package App\Enums
 */
enum AddressType: string
{
    const Shipping = 'shipping';
    const Billing = 'billing';
}