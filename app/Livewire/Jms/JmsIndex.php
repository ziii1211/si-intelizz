<?php

namespace App\Livewire\Jms;

use App\Models\JmsActivity;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

#[Layout('layouts.app')]
class JmsIndex extends Component
{
    use WithPagination, WithFileUploads;

    // Properti Form
    public $nama_sekolah, $tanggal_kegiatan, $materi;
    public $jumlah_peserta, $narasumber, $keterangan;
    public $batas_waktu; // <--- Tambahan Properti
    public $status_verifikasi = 'pending';

    // Properti File/Foto
    public $foto;
    public $old_foto;

    // State Management
    public $jms_id;
    public $is_edit = false;
    public $showModal = false;
    public $search = '';

    // Rules Validasi
    protected function rules()
    {
        return [
            'nama_sekolah' => 'required|string|max:255',
            'tanggal_kegiatan' => 'required|date',
            'materi' => 'required|string',
            'jumlah_peserta' => 'required|integer|min:1',
            'narasumber' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'batas_waktu' => 'nullable|date', // <--- Validasi
            'foto' => 'nullable|image|max:2048',
            'status_verifikasi' => 'required|in:pending,disetujui,ditolak',
        ];
    }

    public function render()
    {
        $query = JmsActivity::query();

        if ($this->search) {
            $query->where('nama_sekolah', 'like', '%' . $this->search . '%')
                ->orWhere('materi', 'like', '%' . $this->search . '%');
        }

        $data = $query->latest()->paginate(10);

        return view('livewire.jms.jms-index', ['jms' => $data]);
    }

    public function create()
    {
        $this->reset(['nama_sekolah', 'tanggal_kegiatan', 'materi', 'jumlah_peserta', 'narasumber', 'keterangan', 'batas_waktu', 'foto', 'old_foto', 'jms_id']);

        $this->tanggal_kegiatan = date('Y-m-d');
        $this->status_verifikasi = 'pending';
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $data = JmsActivity::findOrFail($id);

        $this->jms_id = $id;
        $this->nama_sekolah = $data->nama_sekolah;
        $this->tanggal_kegiatan = $data->tanggal_kegiatan;
        $this->materi = $data->materi;
        $this->jumlah_peserta = $data->jumlah_peserta;
        $this->narasumber = $data->narasumber;
        $this->keterangan = $data->keterangan;
        $this->status_verifikasi = $data->status_verifikasi;
        
        // <--- Load Batas Waktu
        $this->batas_waktu = $data->batas_waktu ? Carbon::parse($data->batas_waktu)->format('Y-m-d') : null;

        $this->old_foto = $data->foto_kegiatan;
        $this->foto = null;

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $dataToSave = [
            'nama_sekolah' => $this->nama_sekolah,
            'tanggal_kegiatan' => $this->tanggal_kegiatan,
            'materi' => $this->materi,
            'jumlah_peserta' => $this->jumlah_peserta,
            'narasumber' => $this->narasumber,
            'keterangan' => $this->keterangan,
            'batas_waktu' => $this->batas_waktu, // <--- Simpan
        ];

        if (Auth::user()->role === 'admin') {
            $dataToSave['status_verifikasi'] = $this->status_verifikasi;
        } else {
            if (!$this->is_edit) {
                $dataToSave['status_verifikasi'] = 'pending';
            }
        }

        if ($this->foto) {
            if ($this->is_edit && $this->old_foto) {
                Storage::disk('public')->delete($this->old_foto);
            }
            $dataToSave['foto_kegiatan'] = $this->foto->store('fotos-jms', 'public');
        }

        if ($this->is_edit) {
            $jms = JmsActivity::findOrFail($this->jms_id);
            $jms->update($dataToSave);

            // --- LOGIKA PENGHAPUS NOTIFIKASI OTOMATIS Lonceng ---
            if (Auth::user()->role === 'admin' && $this->status_verifikasi !== 'pending') {
                foreach (Auth::user()->unreadNotifications as $notification) {
                    if (isset($notification->data['pesan']) && str_contains($notification->data['pesan'], $this->nama_sekolah)) {
                        $notification->markAsRead(); // Hapus dari lonceng
                    }
                }
            }
            // ----------------------------------------------------

            session()->flash('message', 'Data kegiatan JMS berhasil diperbarui.');
        } else {
            $dataToSave['user_id'] = Auth::id();
            JmsActivity::create($dataToSave);
            session()->flash('message', 'Kegiatan JMS baru berhasil ditambahkan.');
        }

        $this->showModal = false;
        $this->reset(['foto', 'old_foto', 'jms_id']);
    }

    public function delete($id)
    {
        $data = JmsActivity::findOrFail($id);

        if (Auth::user()->role !== 'admin' && Auth::id() !== $data->user_id) {
            session()->flash('error', 'Anda tidak memiliki izin menghapus data ini.');
            return;
        }

        if ($data->foto_kegiatan) {
            Storage::disk('public')->delete($data->foto_kegiatan);
        }

        $data->delete();
        session()->flash('message', 'Data kegiatan JMS berhasil dihapus.');
    }
}