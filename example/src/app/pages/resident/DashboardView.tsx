import { AlertCircle, Bell, ArrowRight, CheckCircle, Clock } from 'lucide-react';

export function DashboardView() {
  const pengaduanTerbaru = [
    { id: 'TKT-001', judul: 'Lampu jalan depan blok mati', status: 'Diterima', tanggal: '14 Mar 2026' },
    { id: 'TKT-002', judul: 'Saluran air mampet', status: 'Selesai', tanggal: '10 Mar 2026' },
    { id: 'TKT-003', judul: 'Pohon tumbang di taman', status: 'Diproses', tanggal: '05 Mar 2026' },
  ];

  const pengumumanTerbaru = [
    { id: 1, judul: 'Jadwal Fogging Bulan Maret 2026', tanggal: '14 Mar 2026', unread: true },
    { id: 2, judul: 'Pembersihan Saluran Air Utama', tanggal: '10 Mar 2026', unread: false },
    { id: 3, judul: 'Perubahan Jam Operasional Gerbang', tanggal: '05 Mar 2026', unread: false },
  ];

  const getStatusBadge = (status: string) => {
    switch (status) {
      case 'Diterima': return 'bg-blue-50 text-blue-700 border-blue-200';
      case 'Diproses': return 'bg-yellow-50 text-yellow-700 border-yellow-200';
      case 'Selesai': return 'bg-emerald-50 text-emerald-700 border-emerald-200';
      default: return 'bg-gray-50 text-gray-700 border-gray-200';
    }
  };

  return (
    <div className="space-y-6">
      {/* Welcome Banner */}
      <div className="bg-[#1A3C5E] rounded-2xl p-6 md:p-8 text-white relative overflow-hidden flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-md">
        <div className="absolute top-0 right-0 w-64 h-64 bg-[#C9A84C] opacity-10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 pointer-events-none"></div>
        <div className="relative z-10">
          <h2 className="text-2xl md:text-3xl font-bold mb-2">Selamat datang, Budi Santoso!</h2>
          <p className="text-blue-100">Pantau informasi terbaru dan kelola pengaduan di lingkungan Griya Nusantara.</p>
        </div>
        
        {/* Unit Info Card */}
        <div className="relative z-10 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl p-5 min-w-[280px]">
          <div className="flex justify-between items-start mb-4">
            <div>
              <p className="text-xs text-blue-200 font-semibold tracking-wider uppercase mb-1">Unit Anda</p>
              <h3 className="text-xl font-bold text-white leading-none">Blok A-07</h3>
            </div>
            <span className="bg-[#C9A84C] text-[#1A3C5E] text-xs font-bold px-2 py-1 rounded-md">
              LUNAS
            </span>
          </div>
          <div className="flex gap-4 text-sm text-blue-100">
            <div>
              <span className="block text-xs text-blue-300 mb-0.5">Tipe Rumah</span>
              <span className="font-semibold">Tipe 45</span>
            </div>
            <div>
              <span className="block text-xs text-blue-300 mb-0.5">Luas Tanah/Bangunan</span>
              <span className="font-semibold">72m² / 45m²</span>
            </div>
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        {/* Summary Cards */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
          <div>
            <p className="text-sm font-semibold text-gray-500 mb-1">Pengaduan Aktif</p>
            <h3 className="text-3xl font-bold text-gray-900">2</h3>
          </div>
          <div className="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
            <AlertCircle className="w-6 h-6" />
          </div>
        </div>

        <div className="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
          <div>
            <p className="text-sm font-semibold text-gray-500 mb-1">Pengumuman Terbaru</p>
            <h3 className="text-3xl font-bold text-gray-900">1</h3>
          </div>
          <div className="w-12 h-12 bg-[#C9A84C]/10 text-[#C9A84C] rounded-xl flex items-center justify-center">
            <Bell className="w-6 h-6" />
          </div>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {/* Recent Pengaduan */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <div className="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 className="font-bold text-gray-900">Pengaduan Terbaru</h3>
            <button className="text-xs font-semibold text-[#1A3C5E] hover:text-[#C9A84C] flex items-center gap-1 transition-colors">
              Lihat Semua <ArrowRight className="w-3 h-3" />
            </button>
          </div>
          <div className="divide-y divide-gray-100">
            {pengaduanTerbaru.map((item, i) => (
              <div key={i} className="p-5 hover:bg-gray-50 transition-colors flex items-center justify-between gap-4">
                <div className="flex-1">
                  <h4 className="font-bold text-gray-900 text-sm mb-1">{item.judul}</h4>
                  <p className="text-xs text-gray-500 flex items-center gap-1">
                    <Clock className="w-3 h-3" /> {item.tanggal} • {item.id}
                  </p>
                </div>
                <span className={`px-2.5 py-1 rounded-md text-xs font-semibold border ${getStatusBadge(item.status)}`}>
                  {item.status}
                </span>
              </div>
            ))}
          </div>
        </div>

        {/* Recent Pengumuman */}
        <div className="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <div className="p-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <h3 className="font-bold text-gray-900">Pengumuman Terakhir</h3>
            <button className="text-xs font-semibold text-[#1A3C5E] hover:text-[#C9A84C] flex items-center gap-1 transition-colors">
              Lihat Semua <ArrowRight className="w-3 h-3" />
            </button>
          </div>
          <div className="divide-y divide-gray-100">
            {pengumumanTerbaru.map((item) => (
              <div key={item.id} className="p-5 hover:bg-gray-50 transition-colors flex items-start gap-3">
                <div className={`mt-1.5 w-2 h-2 rounded-full shrink-0 ${item.unread ? 'bg-rose-500' : 'bg-transparent'}`}></div>
                <div>
                  <h4 className={`text-sm mb-1 ${item.unread ? 'font-bold text-gray-900' : 'font-semibold text-gray-700'}`}>
                    {item.judul}
                  </h4>
                  <p className="text-xs text-gray-500 flex items-center gap-1">
                    <Bell className="w-3 h-3" /> {item.tanggal}
                  </p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
