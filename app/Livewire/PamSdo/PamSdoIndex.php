<?php

namespace App\Livewire\PamSdo;

use App\Models\PamSdo;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

#[Layout('layouts.app')]
class PamSdoIndex extends Component
{
    use WithPagination, WithFileUploads;

    // Data Input
    public $nama_kegiatan, $kategori_pam, $tanggal_kegiatan;
    public $lokasi, $pelaksana, $keterangan, $status = 'Aman';
    public $status_verifikasi = 'pending';
    public $batas_waktu; // <--- Tambahan Batas Waktu

    // Upload Foto
    public $foto;
    public $old_foto;

    public $pam_id;
    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    protected function rules()
    {
        return [
            'nama_kegiatan' => 'required|string|max:255',
            'kategori_pam' => 'required|string', 
            'tanggal_kegiatan' => 'required|date',
            'lokasi' => 'required|string',
            'pelaksana' => 'required|string',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
            'batas_waktu' => 'nullable|date', // <--- Aturan Batas Waktu
            'foto' => 'nullable|image|max:2048',
        ];
    }

    public function render()
    {
        $query = PamSdo::query();

        if ($this->search) {
            $query->where('nama_kegiatan', 'like', '%' . $this->search . '%')
                ->orWhere('lokasi', 'like', '%' . $this->search . '%')
                ->orWhere('pelaksana', 'like', '%' . $this->search . '%');
        }

        $data = $query->latest()->paginate(10);

        return view('livewire.pam-sdo.pam-sdo-index', ['pam_sdos' => $data]);
    }

    public function create()
    {
        $this->reset([
            'nama_kegiatan',
            'kategori_pam',
            'lokasi',
            'pelaksana',
            'keterangan',
            'batas_waktu', // <--- Reset Batas Waktu
            'foto',
            'old_foto',
            'pam_id'
        ]);

        $this->tanggal_kegiatan = date('Y-m-d');
        $this->status = 'Aman';
        $this->status_verifikasi = 'pending';
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $data = PamSdo::findOrFail($id);

        $this->pam_id = $id;
        $this->nama_kegiatan = $data->nama_kegiatan;
        $this->kategori_pam = $data->kategori_pam;
        $this->tanggal_kegiatan = $data->tanggal_kegiatan;
        $this->lokasi = $data->lokasi;
        $this->pelaksana = $data->pelaksana;
        $this->keterangan = $data->keterangan;
        $this->status = $data->status;
        $this->status_verifikasi = $data->status_verifikasi;
        
        // <--- Ambil data Batas Waktu
        $this->batas_waktu = $data->batas_waktu ? Carbon::parse($data->batas_waktu)->format('Y-m-d') : null;

        $this->old_foto = $data->foto_dokumentasi; 
        $this->foto = null;

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $dataToSave = [
            'nama_kegiatan' => $this->nama_kegiatan,
            'kategori_pam' => $this->kategori_pam,
            'tanggal_kegiatan' => $this->tanggal_kegiatan,
            'lokasi' => $this->lokasi,
            'pelaksana' => $this->pelaksana,
            'keterangan' => $this->keterangan,
            'status' => $this->status,
            'batas_waktu' => $this->batas_waktu, // <--- Simpan Batas Waktu
        ];

        // Logic Verifikasi
        if (Auth::user()->role === 'admin') {
            $dataToSave['status_verifikasi'] = $this->status_verifikasi;
        } else {
            if (!$this->is_edit) {
                $dataToSave['status_verifikasi'] = 'pending';
            }
        }

        // Logic Upload Foto
        if ($this->foto) {
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            $dataToSave['foto_dokumentasi'] = $this->foto->store('fotos-pam', 'public');
        }

        if ($this->is_edit) {
            $pam = PamSdo::findOrFail($this->pam_id);
            $pam->update($dataToSave);

            // --- LOGIKA PENGHAPUS NOTIFIKASI OTOMATIS ---
            if (Auth::user()->role === 'admin' && $this->status_verifikasi !== 'pending') {
                foreach (Auth::user()->unreadNotifications as $notification) {
                    // Cari notif yang isinya punya $nama_kegiatan ini
                    if (isset($notification->data['pesan']) && str_contains($notification->data['pesan'], $this->nama_kegiatan)) {
                        $notification->markAsRead(); // Hapus dari lonceng
                    }
                }
            }
            // ---------------------------------------------

            session()->flash('message', 'Laporan PAM SDO berhasil diperbarui.');
        } else {
            $dataToSave['user_id'] = Auth::id();
            PamSdo::create($dataToSave);
            session()->flash('message', 'Laporan PAM SDO baru berhasil dibuat.');
        }

        $this->showModal = false;
        $this->reset(['foto', 'old_foto', 'pam_id']);
    }

    public function delete($id)
    {
        $data = PamSdo::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $data->user_id) {
            session()->flash('error', 'Anda tidak memiliki izin menghapus data ini.');
            return;
        }

        if ($data->foto_dokumentasi) {
            Storage::disk('public')->delete($data->foto_dokumentasi);
        }

        $data->delete();
        session()->flash('message', 'Laporan PAM SDO berhasil dihapus.');
    }
}