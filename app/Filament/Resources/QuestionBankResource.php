<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionBankResource\Pages;
use App\Filament\Resources\QuestionBankResource\RelationManagers;
use App\Models\SubjectClass;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Gate;

class QuestionBankResource extends Resource
{
    protected static ?string $model = SubjectClass::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = "Bank Soal";

    protected static ?string $modelLabel = "Bank Soal";
    protected static ?string $pluralModelLabel = "Bank Soal";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('subject_id')->relationship('subject', 'name')->label('Mata Pelajaran')->disabled(),
                TextInput::make("class")->label('Kelas')->disabled()
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Pengelola'),
                TextColumn::make('subject.name'),
                TextColumn::make('class')
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            QuestionBankResource\RelationManagers\QuestionsRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestionBanks::route('/'),
            'create' => Pages\CreateQuestionBank::route('/create'),
            'edit' => Pages\EditQuestionBank::route('/{record}/edit'),
        ];
    }      

    public static function getEloquentQuery(): Builder
    {
        if(Gate::check('question_bank.all')) return parent::getEloquentQuery();
        return parent::getEloquentQuery()->whereUserId(auth()->user()->id);
    }  
}
