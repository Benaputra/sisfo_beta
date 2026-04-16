<?php

namespace App\Filament\Resources\PengajuanJuduls\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;

class PengajuanJudulsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nim')->label('NIM')->searchable()->sortable(),
                TextColumn::make('mahasiswa.nama')->label('Nama Mahasiswa')->searchable(),
                TextColumn::make('judul')->limit(30),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('pembimbing1.nama')->label('Pembimbing 1'),
                TextColumn::make('pembimbing2.nama')->label('Pembimbing 2'),
                TextColumn::make('is_kesediaan_valid')
                    ->label('Kesediaan')
                    ->badge()
                    ->formatStateUsing(fn ($state, $record) => $record->file_kesediaan ? ($state ? 'Valid' : 'Menunggu Validasi') : 'Belum Upload')
                    ->color(fn ($state, $record) => $record->file_kesediaan ? ($state ? 'success' : 'warning') : 'gray'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve & Kirim Notifikasi WhatsApp')
                    ->modalDescription('Masukkan data persetujuan berikut. Sistem akan mengirim notifikasi WA ke mahasiswa setelah disetujui.')
                    ->form([
                        TextInput::make('no_surat')->required(),
                        Select::make('pembimbing1_id')
                            ->label('Pembimbing 1')
                            ->options(\App\Models\Dosen::pluck('nama', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('pembimbing2_id')
                            ->label('Pembimbing 2')
                            ->options(\App\Models\Dosen::pluck('nama', 'id'))
                            ->searchable(),
                        Textarea::make('keterangan'),
                    ])
                    ->visible(fn (\App\Models\PengajuanJudul $record) => $record->status === 'pending')
                    ->action(function (\App\Models\PengajuanJudul $record, array $data) {
                        // Buat record di tabel surats untuk surat kesediaan bimbingan
                        $surat = \App\Models\Surat::create([
                            'jenis_surat' => 'Surat Kesediaan Bimbingan',
                            'no_surat'    => $data['no_surat'],
                            'tujuan_surat' => $record->mahasiswa?->nama,
                        ]);

                        $record->update([
                            'status'        => 'disetujui',
                            'no_surat'      => $data['no_surat'],
                            'surat_id'      => $surat->id,
                            'pembimbing1_id' => $data['pembimbing1_id'],
                            'pembimbing2_id' => $data['pembimbing2_id'] ?? null,
                            'keterangan'    => $data['keterangan'] ?? null,
                            'surat_kesediaan' => 'generated',
                        ]);

                        $mahasiswa = $record->mahasiswa;
                        if ($mahasiswa && $mahasiswa->no_hp) {
                            $hour = now()->format('H');
                            $greeting = ($hour < 12) ? 'pagi' : (($hour < 15) ? 'siang' : (($hour < 18) ? 'sore' : 'malam'));
                            $message = "Selamat {$greeting} " . ($mahasiswa->nama ?? '') . ". Pengajuan judul skripsi Anda dengan judul: \"{$record->judul}\" telah DISETUJUI. Surat Kesediaan Bimbingan sudah dapat diunduh di sistem. Terima Kasih.";

                            $waService = new \App\Services\WhatsAppService();
                            $waService->send($mahasiswa->no_hp, $message);
                        }

                        Notification::make()
                            ->title('Status disetujui & WA terkirim')
                            ->success()
                            ->send();
                    }),
                Action::make('validate_kesediaan')
                    ->label('Validasi Kesediaan')
                    ->icon('heroicon-o-check-badge')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Validasi Surat Kesediaan Bimbingan')
                    ->modalDescription('Apakah Anda yakin surat kesediaan ini valid? Data akan diteruskan ke pendaftaran seminar.')
                    ->visible(fn (\App\Models\PengajuanJudul $record) => $record->file_kesediaan && !$record->is_kesediaan_valid)
                    ->action(function (\App\Models\PengajuanJudul $record) {
                        $record->update(['is_kesediaan_valid' => true]);

                        // Otomatis buat/perbarui record seminar dengan status Menunggu
                        \App\Models\Seminar::updateOrCreate(
                            ['pengajuan_judul_id' => $record->id],
                            [
                                'nim'              => $record->nim,
                                'judul'            => $record->judul,
                                'pembimbing1_id'   => $record->pembimbing1_id,
                                'pembimbing2_id'   => $record->pembimbing2_id,
                                'acc_seminar'      => 'Menunggu',
                                'bukti_bayar'      => $record->bukti_bayar,
                                'is_kesediaan_valid' => true,
                                'file_kesediaan'   => $record->file_kesediaan,
                                'surat_kesediaan_id' => $record->surat_id,
                            ]
                        );

                        Notification::make()
                            ->title('Kesediaan divalidasi & diteruskan ke seminar')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
