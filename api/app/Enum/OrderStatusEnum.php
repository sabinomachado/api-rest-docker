<?php

namespace App\Enum;

use App\Exceptions\ApiException;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';


    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::CONFIRMED => 'Confirmado',
            self::CANCELED => 'Cancelado',
            default => throw new ApiException(ApiException::UNEXPECTED_MATCH_VALUE),
        };
    }

    public function value(): string
    {
        return match ($this) {
            self::PENDING => 'pessoal',
            self::CONFIRMED => 'corporativo',
            self::CANCELED => 'social',
            default => throw new ApiException(ApiException::UNEXPECTED_MATCH_VALUE),
        };
    }

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function random(): self
    {
        $cases = self::cases();
        return $cases[array_rand($cases)];
    }
}
