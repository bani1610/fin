<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('kategori_id')
                    ->relationship('category', 'nama_kategori')
                    ->required(),
                Forms\Components\TextInput::make('judul')
                    ->required(),
                Forms\Components\RichEditor::make('isi_post'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        
            ->columns([
                Tables\Columns\TextColumn::make('judul')->searchable(),
                Tables\Columns\TextColumn::make('isi_post')
                ->label('Isi Post') // Mengubah label kolom
                ->limit(50) // Batasi teks yang tampil jadi 50 karakter
                ->searchable(),
                Tables\Columns\TextColumn::make('user.name')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime('d M Y'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(), // <-- TAMBAHKAN BARIS INI
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    
    public static function shouldRegisterNavigation(): bool
    {
        return true; // Pastikan ini true
    }
    public static function getRelations(): array
    {
        return [];
    }
    
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }    
}
