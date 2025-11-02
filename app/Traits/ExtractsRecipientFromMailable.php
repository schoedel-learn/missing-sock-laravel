<?php

namespace App\Traits;

use Illuminate\Mail\Mailable;

trait ExtractsRecipientFromMailable
{
    /**
     * Extract recipient email from Mailable.
     *
     * @param  Mailable  $mailable
     * @return string|null
     */
    protected function extractRecipientFromMailable(Mailable $mailable): ?string
    {
        // Get recipients from Mailable's to property
        $to = $mailable->to ?? [];

        if (empty($to)) {
            return null;
        }

        // Handle array of addresses or array of arrays
        $firstRecipient = is_array($to) ? ($to[0] ?? null) : $to;

        if (is_string($firstRecipient)) {
            return $firstRecipient;
        }

        if (is_array($firstRecipient) && isset($firstRecipient['address'])) {
            return $firstRecipient['address'];
        }

        // Handle object with address property
        if (is_object($firstRecipient) && isset($firstRecipient->address)) {
            return $firstRecipient->address;
        }

        return null;
    }
}

