<?php

namespace App\Filament\Resources;

use App\Enums\AccountStatusEnums;
use App\Filament\Resources\AccountResource\Pages;
use App\Filament\Resources\AccountResource\RelationManagers;
use App\Models\Account;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\Action;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'firstname')
                    ->required(),
                Forms\Components\TextInput::make('payday')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('total_coverage_amount')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status')
                    ->options(AccountStatusEnums::class)
                    ->enum(AccountStatusEnums::class)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.firstname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_coverage_amount')
                    ->money('ZAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('payday')
                    ->label('Pay Day')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (AccountStatusEnums $state): string => $state->value)
                    ->color(fn (AccountStatusEnums $state): string => match ($state) {
                        AccountStatusEnums::PENDING => 'warning',
                        AccountStatusEnums::ACTIVE => 'success',
                        AccountStatusEnums::PROCESSING => 'danger',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(AccountStatusEnums::optionsArray())
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->where('status', $data['value']);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //Tables\Actions\ViewAction::make(),
                Action::make('approve')
                    ->action(function (Account $record) {
                        return redirect()->route('accounts.approve', $record);
                    })
                    ->requiresConfirmation()
                    ->modalHeading('Approve Account')
                    ->modalDescription('Are you sure you want to approve this account?')
                    ->modalSubmitActionLabel('Yes, approve')
                    ->color('success')
                    ->icon('heroicon-o-check-circle')
                    ->hidden(fn (Account $record): bool => $record->status !== AccountStatusEnums::PENDING),
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
            //RelationManagers\BeneficiariesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
            'create' => Pages\CreateAccount::route('/create'),
            //'view' => Pages\ViewAccount::route('/{record}'),
            'edit' => Pages\EditAccount::route('/{record}/edit'),
        ];
    }
}
