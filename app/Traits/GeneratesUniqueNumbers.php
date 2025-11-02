<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait GeneratesUniqueNumbers
{
    /**
     * Generate a unique number with a prefix and year.
     * Uses database locking to prevent race conditions.
     *
     * @param  string  $prefix
     * @param  string  $numberColumn
     * @return string
     */
    protected static function generateUniqueNumber(string $prefix, string $numberColumn): string
    {
        return DB::transaction(function () use ($prefix, $numberColumn) {
            $year = now()->year;
            
            // Use pessimistic locking to prevent race conditions
            $lastRecord = static::whereYear('created_at', $year)
                ->lockForUpdate()
                ->orderBy($numberColumn, 'desc')
                ->first();
            
            if ($lastRecord && preg_match('/^' . preg_quote($prefix, '/') . '-' . $year . '-(\d+)$/', $lastRecord->$numberColumn, $matches)) {
                $count = (int) $matches[1] + 1;
            } else {
                $count = 1;
            }
            
            $number = $prefix . '-' . $year . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
            
            // Verify uniqueness (fallback check)
            $attempts = 0;
            while (static::where($numberColumn, $number)->exists() && $attempts < 10) {
                $count++;
                $number = $prefix . '-' . $year . '-' . str_pad($count, 6, '0', STR_PAD_LEFT);
                $attempts++;
            }
            
            return $number;
        });
    }
}

