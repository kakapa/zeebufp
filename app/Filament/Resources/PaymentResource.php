<?php

namespace App\Filament\Resources;

use App\Enums\PaymentMethodEnums;
use App\Enums\PaymentStatusEnums;
use App\Enums\PaymentTypeEnums;
use App\Filament\Resources\PaymentResource\Pages;
use App\Filament\Resources\PaymentResource\RelationManagers;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('acount_id')
                    ->relationship('account', 'slug')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('claim_id')
                    ->relationship('claim', 'slug')
                    ->searchable()
                    ->nullable(),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options(PaymentStatusEnums::labels())
                    ->default(PaymentStatusEnums::PENDING->value)
                    ->enum(PaymentStatusEnums::class),
                Forms\Components\Select::make('type')
                    ->options(PaymentTypeEnums::labels())
                    ->default(PaymentTypeEnums::CONTRIBUTION->value)
                    ->enum(PaymentTypeEnums::class),
                Forms\Components\Select::make('method')
                    ->options(PaymentMethodEnums::labels())
                    ->default(PaymentMethodEnums::EFT->value)
                    ->enum(PaymentMethodEnums::class),
                Forms\Components\TextInput::make('reference')
                    ->maxLength(255),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('created_at'),
                Forms\Components\DateTimePicker::make('paid_at'),
                Forms\Components\DateTimePicker::make('approved_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Ref')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account.slug')
                    ->label('Account')
                    ->searchable(),
                Tables\Columns\TextColumn::make('claim.slug')
                    ->label('Claim')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('amount')
                    ->money('ZAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (PaymentStatusEnums $state): string => $state->label())
                    ->color(fn (PaymentStatusEnums $state): string => match ($state) {
                        PaymentStatusEnums::PENDING => 'warning',
                        PaymentStatusEnums::PAID => 'success',
                        PaymentStatusEnums::PROCESSING => 'danger',
                        PaymentStatusEnums::REVERSED => 'info',
                    }),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->formatStateUsing(fn (PaymentTypeEnums $state): string => $state->label())
                    ->color(fn (PaymentTypeEnums $state): string => match ($state) {
                        PaymentTypeEnums::CLAIM => 'warning',
                        PaymentTypeEnums::CONTRIBUTION => 'success',
                        PaymentTypeEnums::EXPENSE => 'danger',
                        PaymentTypeEnums::INCOME => 'info',
                    }),
                Tables\Columns\TextColumn::make('method')
                    ->badge()
                    ->formatStateUsing(fn (PaymentMethodEnums $state): string => $state->label())
                    ->color(fn (PaymentMethodEnums $state): string => match ($state) {
                        PaymentMethodEnums::CASH => 'success',
                        PaymentMethodEnums::EFT => 'danger',
                        PaymentMethodEnums::DEPOSIT => 'info',
                    }),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('paid_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('approved_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('approve')
                    ->action(function (Payment $record) {
                        return redirect()->route('payments.approve', $record);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Approve Payment')
                    ->modalDescription('Are you sure you want to approve this payment?')
                    ->modalSubmitActionLabel('Yes, approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->hidden(fn (Payment $record): bool => $record->status !== PaymentStatusEnums::PENDING),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
