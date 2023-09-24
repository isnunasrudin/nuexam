<?php

namespace App\Filament\Resources\SubjectResource\RelationManagers;

use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class ClassesRelationManager extends RelationManager
{
    protected static string $relationship = 'classes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('class')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true, modifyRuleUsing: fn($rule) => $rule->where('subject_id', $this->getOwnerRecord()->id))->label('Kelas'),

                Forms\Components\Select::make('user_id')->relationship('user', 'name', modifyQueryUsing: fn($query) => $query->role('Sekolah'))->label('Pengelola')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('class')
            ->columns([
                Tables\Columns\TextColumn::make('class'),
                Tables\Columns\TextColumn::make('user.name')
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('class');
    }
}
