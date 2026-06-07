import { useState } from 'react';
import { Plus, Eye, Trash2, Megaphone, X } from 'lucide-react';

export function PengumumanView() {
  const [isModalOpen, setIsModalOpen] = useState(false);

  const announcements = [
    { id: 1, judul: 'Jadwal Fogging Bulan Maret 2026', isi: 'Diberitahukan kepada seluruh warga bahwa akan diadakan fogging rutin pada hari Minggu, 20 Maret 2026 mulai pukul 08:00 WIB. Mohon untuk...', tanggal: '14 Mar 2026', target: 'Semua Resident' },
    { id: 2, judul: 'Pembersihan Saluran Air Utama', isi: 'Sehubungan dengan datangnya musim hujan, pihak developer akan melakukan pembersihan saluran air utama di area Blok A dan B...', tanggal: '10 Mar 2026', target: 'Blok A & B' },
    { id: 3, judul: 'Perubahan Jam Operasional Gerbang', isi: 'Mulai 1 April 2026, gerbang sektor timur hanya akan dibuka pada pukul 06:00 - 22:00 WIB untuk meningkatkan keamanan kompleks...', tanggal: '05 Mar 2026', target: 'Semua Resident' },
  ];

  return (
    <>
      <div className="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
        <div className="p-6 border-b border-gray-100 flex justify-between items-center">
          <div>
            <h2 className="text-xl font-bold text-gray-900">Pengumuman</h2>
            <p className="text-sm text-gray-500 mt-1">Kirim informasi dan broadcast pesan ke portal penghuni.</p>
          </div>
          <button 
            onClick={() => setIsModalOpen(true)}
            className="bg-[#1A3C5E] hover:bg-[#112840] text-white px-4 py-2.5 rounded-lg font-semibold transition-colors flex items-center gap-2 text-sm shadow-sm"
          >
            <Plus className="w-4 h-4" />
            Buat Pengumuman
          </button>
        </div>

        <div className="p-6 flex-1 overflow-y-auto space-y-4">
          {announcements.map((item) => (
            <div key={item.id} className="p-5 border border-gray-200 rounded-xl hover:border-[#C9A84C]/50 hover:shadow-md transition-all group relative">
              <div className="flex justify-between items-start mb-2">
                <div className="flex items-center gap-3">
                  <div className="w-10 h-10 bg-blue-50 text-[#1A3C5E] rounded-lg flex items-center justify-center">
                    <Megaphone className="w-5 h-5" />
                  </div>
                  <div>
                    <h3 className="font-bold text-gray-900 text-lg">{item.judul}</h3>
                    <div className="flex gap-3 text-xs text-gray-500 mt-1">
                      <span>{item.tanggal}</span>
                      <span>•</span>
                      <span className="font-medium text-[#1A3C5E]">Kirim ke: {item.target}</span>
                    </div>
                  </div>
                </div>
                <div className="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                  <button className="p-2 text-gray-400 hover:text-[#1A3C5E] hover:bg-blue-50 rounded-lg transition-colors">
                    <Eye className="w-4 h-4" />
                  </button>
                  <button className="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                    <Trash2 className="w-4 h-4" />
                  </button>
                </div>
              </div>
              <p className="text-gray-600 text-sm mt-3 leading-relaxed ml-13">
                {item.isi}
              </p>
            </div>
          ))}
        </div>
      </div>

      {/* Create Modal */}
      {isModalOpen && (
        <div className="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm transition-opacity">
          <div className="bg-white rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
            <div className="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
              <h3 className="font-bold text-lg text-gray-900">Buat Pengumuman Baru</h3>
              <button onClick={() => setIsModalOpen(false)} className="text-gray-400 hover:text-gray-600">
                <X className="w-5 h-5" />
              </button>
            </div>
            <div className="p-6 space-y-5">
              <div>
                <label className="block text-sm font-semibold text-gray-700 mb-1.5">Judul Pengumuman</label>
                <input 
                  type="text" 
                  className="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A3C5E] focus:border-transparent outline-none transition-all text-sm"
                  placeholder="Masukkan judul..."
                />
              </div>
              <div>
                <label className="block text-sm font-semibold text-gray-700 mb-1.5">Isi Pengumuman</label>
                <textarea 
                  rows={5}
                  className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A3C5E] focus:border-transparent outline-none transition-all text-sm resize-none"
                  placeholder="Ketik isi pengumuman di sini..."
                ></textarea>
              </div>
              <div>
                <label className="block text-sm font-semibold text-gray-700 mb-1.5">Kirim ke</label>
                <select className="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1A3C5E] focus:border-transparent outline-none transition-all text-sm">
                  <option>Semua Resident</option>
                  <option>Blok A Saja</option>
                  <option>Blok B Saja</option>
                </select>
              </div>
            </div>
            <div className="px-6 py-4 border-t border-gray-100 bg-gray-50 flex justify-end gap-3">
              <button 
                onClick={() => setIsModalOpen(false)}
                className="px-5 py-2.5 font-semibold text-gray-600 hover:bg-gray-200 rounded-xl transition-colors text-sm"
              >
                Batal
              </button>
              <button 
                onClick={() => setIsModalOpen(false)}
                className="px-5 py-2.5 bg-[#1A3C5E] hover:bg-[#112840] text-white font-semibold rounded-xl shadow-md transition-all text-sm"
              >
                Kirim Pengumuman
              </button>
            </div>
          </div>
        </div>
      )}
    </>
  );
}
