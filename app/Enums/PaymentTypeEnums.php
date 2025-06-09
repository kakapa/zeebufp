<?php

namespace App\Enums;

enum PaymentTypeEnums: string
{
    case CLAIM = 'claim';
    case EXPENSE = 'expense';
    case INCOME = 'income';
    case CONTRIBUTION = 'contribution';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::CLAIM->value => 'Claim',
            self::CONTRIBUTION->value => 'Contribution',
            self::EXPENSE->value => 'Expense',
            self::INCOME->value => 'Income',
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}