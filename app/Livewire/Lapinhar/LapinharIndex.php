<?php

namespace App\Livewire\Lapinhar;

use App\Models\Lapinhar;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class LapinharIndex extends Component
{
    use WithPagination;

    public $showModal = false; 
    public $showWaktuModal = false; // Modal baru untuk atur waktu
    public $is_edit = false;
    public $search = '';
    public $lapinhar_id;

    // Data Form Utama
    public $nomor_surat;
    public $tanggal_surat;
    public $sumber_informasi;
    public $bidang;
    public $peristiwa;
    public $pendapat;
    public $status = 'rahasia';
    public $status_verifikasi = 'pending';

    // Data Form Waktu (Khusus Admin)
    public $tanggal_dibuka;
    public $tanggal_ditutup;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    protected function rules()
    {
        return [
            'nomor_surat' => 'required|string',
            'tanggal_surat' => 'required|date',
            'sumber_informasi' => 'required|string',
            'bidang' => 'required|string',
            'peristiwa' => 'required|string|min:10',
            'pendapat' => 'required|string|min:5',
            'status' => 'required|in:rahasia,biasa',
        ];
    }

    public function render()
    {
        $query = Lapinhar::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('peristiwa', 'like', '%' . $this->search . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $this->search . '%')
                    ->orWhere('bidang', 'like', '%' . $this->search . '%');
            });
        }

        $lapinhars = $query->latest()->paginate(10);

        return view('livewire.lapinhar.lapinhar-index', [
            'lapinhars' => $lapinhars
        ]);
    }

    public function create()
    {
        $this->resetInput();
        $this->tanggal_surat = date('Y-m-d');
        $this->is_edit = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $data = Lapinhar::findOrFail($id);

        $this->lapinhar_id = $id;
        $this->nomor_surat = $data->nomor_surat;
        $this->tanggal_surat = \Carbon\Carbon::parse($data->tanggal_surat)->format('Y-m-d');
        $this->sumber_informasi = $data->sumber_informasi;
        $this->bidang = $data->bidang;
        $this->peristiwa = $data->peristiwa;
        $this->pendapat = $data->pendapat;
        $this->status = $data->status;
        $this->status_verifikasi = $data->status_verifikasi;

        $this->is_edit = true;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();

        $dataToSave = [
            'nomor_surat' => $this->nomor_surat,
            'tanggal_surat' => $this->tanggal_surat,
            'sumber_informasi' => $this->sumber_informasi,
            'bidang' => $this->bidang,
            'peristiwa' => $this->peristiwa,
            'pendapat' => $this->pendapat,
            'status' => $this->status,
        ];

        if (Auth::user()->role === 'admin') {
            $dataToSave['status_verifikasi'] = $this->status_verifikasi;
        }

        if ($this->is_edit) {
            $lapinhar = Lapinhar::findOrFail($this->lapinhar_id);
            $lapinhar->update($dataToSave);
            if (Auth::user()->role === 'admin' && $this->status_verifikasi !== 'pending') {
                foreach (Auth::user()->unreadNotifications as $notification) {
                    // Cek apakah pesan notifikasi mengandung Nomor Surat ini
                    if (isset($notification->data['pesan']) && str_contains($notification->data['pesan'], $this->nomor_surat)) {
                        $notification->markAsRead(); 
                    }
                }
            }
            session()->flash('message', 'Laporan berhasil diperbarui.');
        } else {
            $dataToSave['user_id'] = Auth::id();
            $dataToSave['status_verifikasi'] = 'pending';
            Lapinhar::create($dataToSave);
            session()->flash('message', 'Laporan berhasil dibuat.');
        }

        $this->showModal = false;
        $this->resetInput();
    }

    // --- FUNGSI BUKA MODAL ATUR WAKTU ---
    public function aturWaktu($id)
    {
        if (Auth::user()->role !== 'admin') return;

        $data = Lapinhar::findOrFail($id);
        $this->lapinhar_id = $id;
        $this->tanggal_dibuka = $data->tanggal_dibuka ? \Carbon\Carbon::parse($data->tanggal_dibuka)->format('Y-m-d') : null;
        $this->tanggal_ditutup = $data->tanggal_ditutup ? \Carbon\Carbon::parse($data->tanggal_ditutup)->format('Y-m-d') : null;
        
        $this->showWaktuModal = true;
    }

    // --- FUNGSI SIMPAN WAKTU ---
    public function saveWaktu()
    {
        if (Auth::user()->role !== 'admin') return;

        $lapinhar = Lapinhar::findOrFail($this->lapinhar_id);
        $lapinhar->update([
            'tanggal_dibuka' => $this->tanggal_dibuka ?: null,
            'tanggal_ditutup' => $this->tanggal_ditutup ?: null,
        ]);

        $this->showWaktuModal = false;
        session()->flash('message', 'Periode waktu penanganan berkas berhasil diatur.');
    }

    public function updateStatus($id, $status)
    {
        if (Auth::user()->role !== 'admin') return;
        $validStatuses = ['pending', 'disetujui', 'ditolak'];
        if (!in_array($status, $validStatuses)) return;

        Lapinhar::findOrFail($id)->update(['status_verifikasi' => $status]);
        session()->flash('message', 'Status verifikasi berhasil diubah menjadi ' . strtoupper($status) . '.');
    }

    public function delete($id)
    {
        $data = Lapinhar::findOrFail($id);
        if (Auth::user()->role !== 'admin' && Auth::id() !== $data->user_id) {
            session()->flash('message', 'Anda tidak berhak menghapus data ini.');
            return;
        }
        $data->delete();
        session()->flash('message', 'Laporan berhasil dihapus.');
    }

    private function resetInput()
    {
        $this->reset(['nomor_surat', 'sumber_informasi', 'bidang', 'peristiwa', 'pendapat', 'lapinhar_id', 'tanggal_dibuka', 'tanggal_ditutup']);
        $this->status = 'rahasia';
        $this->status_verifikasi = 'pending';
    }
}