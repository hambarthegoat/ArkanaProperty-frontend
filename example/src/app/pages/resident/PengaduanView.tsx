import { useState } from 'react';
import { Plus, X, Search, FileText } from 'lucide-react';

export function PengaduanView() {
  const [isModalOpen, setIsModalOpen] = useState(false);

  const complaints = [
    { id: 'TKT-001', judul: 'Lampu jalan depan blok mati', kategori: 'Fasilitas Umum', status: 'Diterima', tanggal: '14 Mar 2026' },
    { id: 'TKT-002', judul: 'Saluran air mampet', kategori: 'Lingkungan', status: 'Selesai', tanggal: '10 Mar 2026' },
    { id: 'TKT-003', judul: 'Pohon tumbang di taman', kategori: 'Lingkungan', status: 'Diproses', tanggal: '05 Mar 2026' },
  ];

  const getStatusBadge = (status: string) => {
    switch (status) {
      case 'Diterima': return 'bg-blue-100 text-blue-700 border-blue-200';
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
            <h2 className="text-xl font-bold text-gray-900">Pengaduan Saya</h2>
            <p className="text-sm text-gray-500 mt-1">Sampaikan keluhan dan pantau status penyelesaiannya.</p>
          </div>
          <button 
            onClick={() => setIsModalOpen(true)}
            className="bg-[#C9A84C] hover:bg-[#b59640] text-white px-5 py-2.5 rounded-lg font-semibold transition-colors flex items-center gap-2 text-sm shadow-sm whitespace-nowrap"
          >
            <Plus className="w-4 h-4" />
            Buat Pengaduan
          </button>
        </div>

        <div className="p-4 bg-gray-50 border-b border-gray-100">
          <div className="relative max-w-md">
            <Search className="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" />
            <input 
              type="text" 
              placeholder="Cari nomor tiket atau judul pengaduan..." 
              className="w-full pl-9 pr-4 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1A3C5E] transition-all"
            />
          </div>
        </div>

        <div className="overflow-x-auto flex-1 p-6">
          <table className="w-full text-left border-collapse">
            <thead>
              <tr className="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
                <th className="px-6 py-4 font-semibold rounded-tl-lg">No. Tiket</th>
                <th className="px-6 py-4 font-semibold">Judul Pengaduan</th>
                <th className="px-6 py-4 font-semibold">Kategori</th>
                <th className="px-6 py-4 font-semibold">Tanggal</th>
                <th className="px-6 py-4 font-semibold rounded-tr-lg">Status</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-gray-100 text-sm">
              {complaints.map((item) => (
                <tr key={item.id} className="hover:bg-gray-50 transition-colors">
                  <td className="px-6 py-4 font-bold text-[#1A3C5E]">{item.id}</td>
                  <td className="px-6 py-4 font-bold text-gray-900">{item.judul}</td>
                  <td className="px-6 py-4 text-gray-600">{item.kategori}</td>
                  <td className="px-6 py-4 text-gray-500">{item.tanggal}</td>
                  <td className="px-6 py-4">
                    <span className={`px-3 py-1.5 rounded-full text-xs font-bold border ${getStatusBadge(item.status)}`}>
                      {item.status}
                    </span>
                  </td>
                </tr>
              ))}
              
              {complaints.length === 0 && (
                <tr>
                  <td colSpan={5} className="py-12 text-center">
                    <div className="flex flex-col items-center justify-center text-gray-400">
                      <FileText className="w-12 h-12 mb-3 text-gray-300" />
                      <p className="font-semibold text-gray-600">Belum ada pengaduan</p>
                      <p className="text-sm">Anda belum pernah membuat tiket pengaduan.</p>
                    </div>
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        </div>
      </div>

      {/* Create Complaint Modal */}
      {isModalOpen && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-[#1A3C5E]/40 backdrop-blur-sm transition-opacity">
          <div className="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div className="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
              <h3 className="font-bold text-lg text-[#1A3C5E]">Buat Pengaduan Baru</h3>
              <button onClick={() => setIsModalOpen(false)} className="text-gray-400 hover:text-gray-600 transition-colors p-1 rounded-md hover:bg-gray-200">
                <X className="w-5 h-5" />
              </button>
            </div>
            
            <div className="p-6 space-y-5">
              <div>
                <label className="block text-sm font-semibold text-gray-700 mb-1.5">Judul Pengaduan <span className="text-rose-500">*</span></label>
                <input 
                  type="text" 
                  className="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent outline-none transition-all text-sm"
                  placeholder="Contoh: Lampu taman blok A mati"
                />
              </div>
              
              <div>
                <label className="block text-sm font-semibold text-gray-700 mb-1.5">Kategori <span className="text-rose-500">*</span></label>
                <select className="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent outline-none transition-all text-sm bg-white">
                  <option value="" disabled selected>Pilih Kategori</option>
                  <option value="Fasilitas Umum">Fasilitas Umum</option>
                  <option value="Keamanan">Keamanan</option>
                  <option value="Kebersihan">Kebersihan</option>
                  <option value="Lainnya">Lainnya</option>
                </select>
              </div>

              <div>
                <label className="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi Lengkap <span className="text-rose-500">*</span></label>
                <textarea 
                  rows={4}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#C9A84C] focus:border-transparent outline-none transition-all text-sm resize-none"
                  placeholder="Jelaskan detail pengaduan Anda di sini agar tim kami dapat segera menindaklanjuti..."
                ></textarea>
              </div>
            </div>

            <div className="px-6 py-5 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
              <button 
                onClick={() => setIsModalOpen(false)}
                className="px-5 py-2.5 font-semibold text-gray-600 hover:bg-gray-200 rounded-xl transition-colors text-sm"
              >
                Batal
              </button>
              <button 
                onClick={() => setIsModalOpen(false)}
                className="px-5 py-2.5 bg-[#C9A84C] hover:bg-[#b59640] text-white font-bold rounded-xl shadow-md transition-all text-sm"
              >
                Kirim Pengaduan
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
}
