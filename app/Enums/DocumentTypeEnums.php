<?php

namespace App\Enums;

enum DocumentTypeEnums: string
{
    case CONTRACT = 'contract';
    case INVOICE = 'invoice';
    case RECEIPT = 'receipt';
    case ID_DOCUMENT = 'id_document';
    case ADDRESS_PROOF = 'address_proof';
    case EVIDENCE = 'evidence';
    case REPORT = 'report';
    case CLAIM_FORM = 'claim_form';
    case BI1663_NOTICE = 'bi1663_notice';
    case DEATH_CERTIFICATE = 'death_certificate';
    case BANK_STATEMENT = 'bank_statement';
    case OTHER = 'other';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labels(): array
    {
        return [
            self::CONTRACT->value => 'Contract',
            self::INVOICE->value => 'Invoice',
            self::RECEIPT->value => 'Receipt',
            self::ID_DOCUMENT->value => 'ID Document',
            self::ADDRESS_PROOF->value => 'Proof Of Address',
            self::EVIDENCE->value => 'Evidence',
            self::REPORT->value => 'Report',
            self::CLAIM_FORM->value => 'Claim Form',
            self::BI1663_NOTICE->value => 'BI 1663 Notice of Death ',
            self::DEATH_CERTIFICATE->value => 'Death Certificate',
            self::BANK_STATEMENT->value => 'Bank Statement',
            self::OTHER->value => 'Other'
        ];
    }

    public function label(): string
    {
        return self::labels()[$this->value] ?? 'Unknown';
    }
}