<?php

namespace App\Listeners;

use App\Events\AbsenGuruSaved;
use App\Models\User;
use App\Models\Kelas;
use App\Notifications\AbsensiNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendAbsensiNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(AbsenGuruSaved $event)
    {
        // Ambil kelas terkait dari absen_guru
        $kelas = Kelas::find($event->absen_guru->kelas_id);

        if ($kelas) {
            // Temukan semua siswa di kelas yang bersangkutan
            $siswa = User::where('role', 'Sekretaris')->where('kelas_id', $kelas->id)->get();

            // Kirim notifikasi ke setiap siswa dengan slug kelas
            foreach ($siswa as $s) {
                $s->notify(new AbsensiNotification($event->absen_guru, $kelas->slug));
            }
        }
    }
}
