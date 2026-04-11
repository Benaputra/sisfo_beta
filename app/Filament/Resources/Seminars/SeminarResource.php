<?php

namespace App\Filament\Resources\Seminars;

use App\Filament\Resources\Seminars\Pages\CreateSeminar;
use App\Filament\Resources\Seminars\Pages\EditSeminar;
use App\Filament\Resources\Seminars\Pages\ListSeminars;
use App\Filament\Resources\Seminars\Schemas\SeminarForm;
use App\Filament\Resources\Seminars\Tables\SeminarsTable;
use App\Models\Seminar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SeminarResource extends Resource
{
    protected static ?string $model = Seminar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'judul';

    public static function form(Schema $schema): Schema
    {
        return SeminarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeminarsTable::configure($table);
    }

    /**
     * Scope data berdasarkan Role
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        // Admin, Staff, dan Kaprodi melihat semua
        if ($user->hasAnyRole(['admin', 'staff', 'kaprodi'])) {
            return $query;
        }

        // Dosen melihat seminar di mana dia terlibat
        if ($user->hasRole('dosen')) {
            return $query->where(function (Builder $q) use ($user) {
                $q->where('pembimbing1_id', $user->id)
                    ->orWhere('pembimbing2_id', $user->id)
                    ->orWhere('penguji_seminar_id', $user->id)
                    ->orWhere('penguji2_id', $user->id);
            });
        }

        // Mahasiswa hanya melihat miliknya sendiri (berdasarkan NIM)
        if ($user->hasRole('mahasiswa')) {
            return $query->where('nim', $user->nim);
        }

        return $query;
    }

    // --- Authorization Hooks ---

    public static function canCreate(): bool
    {
        return auth()->user()->hasAnyPermission(['create-seminar', 'manage-all-seminar']);
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();

        if ($user->hasAnyPermission(['manage-all-seminar'])) {
            return true;
        }

        if ($user->hasRole('mahasiswa') && $record->nim === $user->nim) {
            // Contoh logic: mahasiswa hanya bisa edit jika belum di-ACC
            return empty($record->acc_seminar);
        }

        return false;
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->hasPermissionTo('delete-data');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeminars::route('/'),
            'create' => CreateSeminar::route('/create'),
            'edit' => EditSeminar::route('/{record}/edit'),
        ];
    }
}
