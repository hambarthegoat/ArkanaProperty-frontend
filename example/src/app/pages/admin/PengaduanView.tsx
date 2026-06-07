import { useState } from 'react';
import { Filter, Eye, X, MessageSquare, Clock, CheckCircle } from 'lucide-react';

export function PengaduanView() {
  const [selectedTicket, setSelectedTicket] = useState<any>(null);

  const complaints = [
    { id: 'TKT-001', resident: 'Budi (A-01)', judul: 'Atap garasi bocor', kategori: 'Bangunan', status: 'Diterima', tanggal: '14 Mar 2026', deskripsi: 'Atap bagian garasi bocor saat hujan deras semalam. Air merembes hingga ke dinding samping.', lastUpdate: '-' },
    { id: 'TKT-002', resident: 'Siti (B-05)', judul: 'Lampu jalan mati', kategori: 'Fasilitas Umum', status: 'Diproses', tanggal: '13 Mar 2026', deskripsi: 'Lampu jalan di depan rumah nomor B-05 mati sejak 2 hari yang lalu. Kondisi sangat gelap di malam hari.', lastUpdate: 'Sedang dilakukan pengecekan oleh teknisi.' },
    { id: 'TKT-003', resident: 'Agus (C-12)', judul: 'Saluran air mampet', kategori: 'Lingkungan', status: 'Selesai', tanggal: '10 Mar 2026', deskripsi: 'Saluran air got depan rumah tersumbat sampah, air meluap ke jalan.', lastUpdate: 'Telah dibersihkan oleh petugas kebersihan.' },
  ];

  const getStatusBadge = (status: string) => {
    switch (status) {
      case 'Diterima': return 'bg-rose-100 text-rose-700 border-rose-200';
      case 'Diproses': return 'bg-yellow-100 text-yellow-700 border-yellow-200';
      case 'Selesai': return 'bg-emerald-100 text-emerald-700 border-emerald-200';
      default: return 'bg-gray-100 text-gray-700 border-gray-200';
    }
  };

  return (
    <>
      <div className="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
        <div className="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
          <div>
            <h2 className="text-xl font-bold text-gray-900">Pengaduan Masuk</h2>
            <p className="text-sm text-gray-500 mt-1">Tindaklanjuti keluhan dan laporan dari penghuni.</p>
          </div>
          <div className="flex items-center gap-2">
            <span className="text-sm font-medium text-gray-600 flex items-center gap-1">
              <Filter className="w-4 h-4" /> Filter:
            </span>
            <select className="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1A3C5E]">
              <option>Semua Status</option>
              <option>Diterima</option>
              <option>Diproses</option>
              <option>Selesai</option>
            </select>
          </div>
        </div>

        <div className="overflow-x-auto flex-1 p-6">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
                <th className="px-6 py-4 font-medium rounded-tl-lg">No. Tiket</th>
                <th className="px-6 py-4 font-medium">Resident</th>
                <th className="px-6 py-4 font-medium">Judul Keluhan</th>
                <th className="px-6 py-4 font-medium">Kategori</th>
                <th className="px-6 py-4 font-medium">Status</th>
                <th className="px-6 py-4 font-medium">Tanggal</th>
                <th className="px-6 py-4 font-medium rounded-tr-lg text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100 text-sm">
              {complaints.map((item) => (
                <tr key={item.id} className="hover:bg-gray-50 transition-colors">
                  <td className="px-6 py-4 font-bold text-[#1A3C5E]">{item.id}</td>
                  <td className="px-6 py-4 font-medium text-gray-900">{item.resident}</td>
                  <td className="px-6 py-4 text-gray-900">{item.judul}</td>
                  <td className="px-6 py-4 text-gray-600">{item.kategori}</td>
                  <td className="px-6 py-4">
                    <span className={`px-3 py-1.5 rounded-full text-xs font-semibold border ${getStatusBadge(item.status)}`}>
                      {item.status}
                    </span>
                  </td>
                  <td className="px-6 py-4 text-gray-500">{item.tanggal}</td>
                  <td className="px-6 py-4 text-right">
                    <button 
                      onClick={() => setSelectedTicket(item)}
                      className="p-2 text-[#C9A84C] hover:text-white hover:bg-[#C9A84C] rounded-lg transition-colors inline-flex items-center gap-1 font-semibold text-xs border border-[#C9A84C]/30"
                    >
                      <Eye className="w-4 h-4" /> Detail
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>

      {/* Detail Modal */}
      {selectedTicket && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm transition-opacity">
          <div className="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div className="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
              <div className="flex items-center gap-3">
                <span className="bg-[#1A3C5E] text-white text-xs font-bold px-2 py-1 rounded">
                  {selectedTicket.id}
                </span>
                <h3 className="font-bold text-lg text-gray-900">Detail Pengaduan</h3>
              </div>
              <button onClick={() => setSelectedTicket(null)} className="text-gray-400 hover:text-gray-600">
                <X className="w-5 h-5" />
              </button>
            </div>
            
            <div className="p-6">
              <div className="mb-6">
                <h4 className="text-xl font-bold text-gray-900 mb-2">{selectedTicket.judul}</h4>
                <div className="flex gap-4 text-sm text-gray-500 mb-4">
                  <span className="flex items-center gap-1"><MessageSquare className="w-4 h-4" /> {selectedTicket.kategori}</span>
                  <span className="flex items-center gap-1"><Clock className="w-4 h-4" /> {selectedTicket.tanggal}</span>
                </div>
                <div className="bg-gray-50 p-4 rounded-xl border border-gray-100 text-gray-700 text-sm">
                  {selectedTicket.deskripsi}
                </div>
                <p className="mt-3 text-sm text-gray-500 font-medium">Pelapor: <span className="text-gray-900">{selectedTicket.resident}</span></p>
              </div>

              <div className="border-t border-gray-100 pt-5">
                <label className="block text-sm font-semibold text-gray-700 mb-2">Update Status & Catatan</label>
                <select 
                  defaultValue={selectedTicket.status}
                  className="w-full px-4 py-2.5 mb-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A3C5E] focus:border-transparent outline-none transition-all text-sm font-medium"
                >
                  <option value="Diterima">Status: Diterima (Belum Ditangani)</option>
                  <option value="Diproses">Status: Sedang Diproses</option>
                  <option value="Selesai">Status: Selesai</option>
                </select>
                <textarea 
                  rows={2}
                  defaultValue={selectedTicket.lastUpdate !== '-' ? selectedTicket.lastUpdate : ''}
                  className="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A3C5E] focus:border-transparent outline-none transition-all text-sm resize-none"
                  placeholder="Tambahkan catatan untuk penghuni (opsional)..."
                ></textarea>
              </div>
            </div>

            <div className="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
              <button 
                onClick={() => setSelectedTicket(null)}
                className="px-5 py-2.5 font-semibold text-gray-600 hover:bg-gray-200 rounded-xl transition-colors text-sm"
              >
                Tutup
              </button>
              <button 
                onClick={() => setSelectedTicket(null)}
                className="px-5 py-2.5 bg-[#1A3C5E] hover:bg-[#112840] text-white font-semibold rounded-xl shadow-md transition-all text-sm flex items-center gap-2"
              >
                <CheckCircle className="w-4 h-4" /> Simpan Update
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
}
