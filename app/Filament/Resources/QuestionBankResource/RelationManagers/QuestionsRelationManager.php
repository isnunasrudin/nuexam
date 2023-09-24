<?php

namespace App\Filament\Resources\QuestionBankResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            RichEditor::make('question'),
            Repeater::make('answers')
                ->schema([
                    TextInput::make('a'),
                    TextInput::make('b'),
                    TextInput::make('c'),
                    TextInput::make('d'),
                ])->columns(4)->addable(false),
            Repeater::make('correct')->required()
                ->schema([
                    Toggle::make('a'),
                    Toggle::make('b'),
                    Toggle::make('c'),
                    Toggle::make('d'),
                ])->columns(4)->addable(false),
            Hidden::make('type')->default("single_choice")
        ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('question')->limit(40),
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
            ]);
    }
}
