import { useState } from 'react';
import { ChevronDown, ChevronUp, Clock, Megaphone } from 'lucide-react';

export function PengumumanView() {
  const [expandedId, setExpandedId] = useState<number | null>(null);

  const announcements = [
    { 
      id: 1, 
      judul: 'Jadwal Fogging Rutin Bulan Maret 2026', 
      isi: 'Diberitahukan kepada seluruh warga Griya Nusantara bahwa akan diadakan fogging rutin pada hari Minggu, 20 Maret 2026 mulai pukul 08:00 WIB. Mohon untuk menutup pintu dan jendela selama proses fogging berlangsung untuk mencegah masuknya asap secara berlebihan, serta mengamankan makanan/minuman dan hewan peliharaan. Terima kasih atas kerja samanya.', 
      tanggal: '14 Mar 2026', 
      unread: true 
    },
    { 
      id: 2, 
      judul: 'Pembersihan Saluran Air Utama & Pemeliharaan Taman', 
      isi: 'Sehubungan dengan datangnya musim hujan, pihak developer akan melakukan pembersihan saluran air utama dan pemangkasan dahan pohon di area fasilitas umum Blok A dan B. Kegiatan akan dilaksanakan pada hari Sabtu, 12 Maret 2026. Mohon maaf atas ketidaknyamanan yang mungkin ditimbulkan selama proses pemeliharaan.', 
      tanggal: '10 Mar 2026', 
      unread: false 
    },
    { 
      id: 3, 
      judul: 'Perubahan Jam Operasional Gerbang Timur', 
      isi: 'Mulai 1 April 2026, untuk meningkatkan keamanan kompleks Griya Nusantara, gerbang sektor timur hanya akan dibuka pada pukul 06:00 - 22:00 WIB. Di luar jam tersebut, seluruh akses keluar masuk diwajibkan melalui Gerbang Utama (Utara) yang beroperasi 24 jam.', 
      tanggal: '05 Mar 2026', 
      unread: false 
    },
  ];

  const toggleExpand = (id: number) => {
    setExpandedId(expandedId === id ? null : id);
  };

  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
      <div className="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
        <div>
          <h2 className="text-xl font-bold text-[#1A3C5E]">Pengumuman Warga</h2>
          <p className="text-sm text-gray-500 mt-1">Informasi dan berita terbaru dari pengelola perumahan.</p>
        </div>
      </div>

      <div className="p-6 flex-1 overflow-y-auto bg-gray-50/30">
        <div className="max-w-4xl mx-auto space-y-4">
          {announcements.map((item) => {
            const isExpanded = expandedId === item.id;
            return (
              <div 
                key={item.id} 
                className={`bg-white border rounded-xl transition-all duration-200 overflow-hidden ${
                  item.unread ? 'border-blue-200 shadow-sm' : 'border-gray-200 hover:border-gray-300'
                }`}
              >
                <div 
                  className={`p-5 cursor-pointer flex gap-4 ${isExpanded ? 'bg-gray-50/80 border-b border-gray-100' : ''}`}
                  onClick={() => toggleExpand(item.id)}
                >
                  <div className="shrink-0 mt-1 relative">
                    <div className={`w-10 h-10 rounded-full flex items-center justify-center ${
                      item.unread ? 'bg-blue-50 text-[#1A3C5E]' : 'bg-gray-100 text-gray-500'
                    }`}>
                      <Megaphone className="w-5 h-5" />
                    </div>
                    {item.unread && (
                      <span className="absolute top-0 right-0 w-3 h-3 bg-rose-500 border-2 border-white rounded-full shadow-sm"></span>
                    )}
                  </div>
                  
                  <div className="flex-1">
                    <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-1">
                      <h3 className={`text-base ${item.unread ? 'font-bold text-[#1A3C5E]' : 'font-semibold text-gray-800'}`}>
                        {item.judul}
                      </h3>
                      <span className="text-xs font-medium text-gray-500 flex items-center gap-1 shrink-0">
                        <Clock className="w-3.5 h-3.5" /> {item.tanggal}
                      </span>
                    </div>
                    
                    {!isExpanded && (
                      <p className="text-sm text-gray-600 line-clamp-1 pr-8">
                        {item.isi}
                      </p>
                    )}
                  </div>

                  <div className="shrink-0 text-gray-400 self-center">
                    {isExpanded ? <ChevronUp className="w-5 h-5" /> : <ChevronDown className="w-5 h-5" />}
                  </div>
                </div>

                {/* Expanded Content */}
                {isExpanded && (
                  <div className="p-6 bg-white animate-in slide-in-from-top-2 duration-200">
                    <p className="text-gray-700 text-sm leading-relaxed whitespace-pre-wrap">
                      {item.isi}
                    </p>
                  </div>
                )}
              </div>
            );
          })}
        </div>
      </div>
    </div>
  );
}
