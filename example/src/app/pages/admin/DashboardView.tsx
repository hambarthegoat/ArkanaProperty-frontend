import { Users, Home, AlertCircle, TrendingUp, CheckCircle, Clock } from 'lucide-react';

export function DashboardView() {
  return (
    <div className="space-y-6">
      {/* 4 Stat Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
          <div className="flex justify-between items-start mb-4">
            <div className="p-3 bg-blue-50 text-blue-600 rounded-lg">
              <TrendingUp className="w-6 h-6" />
            </div>
            <span className="text-sm font-medium text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md flex items-center gap-1">
              +12%
            </span>
          </div>
          <p className="text-sm text-gray-500 font-medium mb-1">Total Leads</p>
          <h3 className="text-3xl font-bold text-gray-900">156</h3>
        </div>

        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
          <div className="flex justify-between items-start mb-4">
            <div className="p-3 bg-emerald-50 text-emerald-600 rounded-lg">
              <Home className="w-6 h-6" />
            </div>
          </div>
          <p className="text-sm text-gray-500 font-medium mb-1">Kavling Tersedia</p>
          <h3 className="text-3xl font-bold text-gray-900">24</h3>
        </div>

        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
          <div className="flex justify-between items-start mb-4">
            <div className="p-3 bg-rose-50 text-rose-600 rounded-lg">
              <AlertCircle className="w-6 h-6" />
            </div>
            <span className="text-sm font-medium text-rose-600 bg-rose-50 px-2 py-1 rounded-md">
              Perlu Tindakan
            </span>
          </div>
          <p className="text-sm text-gray-500 font-medium mb-1">Pengaduan Aktif</p>
          <h3 className="text-3xl font-bold text-gray-900">5</h3>
        </div>

        <div className="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col">
          <div className="flex justify-between items-start mb-4">
            <div className="p-3 bg-purple-50 text-purple-600 rounded-lg">
              <Users className="w-6 h-6" />
            </div>
          </div>
          <p className="text-sm text-gray-500 font-medium mb-1">Total Penghuni</p>
          <h3 className="text-3xl font-bold text-gray-900">82</h3>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {/* Recent Leads Table */}
        <div className="col-span-1 lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <div className="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 className="text-lg font-bold text-gray-900">Leads Terbaru</h3>
            <button className="text-sm font-semibold text-[#C9A84C] hover:text-[#b59640]">Lihat Semua</button>
          </div>
          <div className="overflow-x-auto">
            <table className="w-full text-left border-collapse">
              <thead>
                <tr className="bg-gray-50 text-gray-500 text-sm border-b border-gray-100">
                  <th className="px-6 py-4 font-medium">Nama</th>
                  <th className="px-6 py-4 font-medium">No HP</th>
                  <th className="px-6 py-4 font-medium">Tipe Diminati</th>
                  <th className="px-6 py-4 font-medium">Status</th>
                  <th className="px-6 py-4 font-medium">Tanggal</th>
                </tr>
              </thead>
              <tbody className="text-sm divide-y divide-gray-100">
                {[
                  { name: 'Andi Pratama', phone: '08123456789', type: 'Tipe 45/72', status: 'Baru', date: '15 Mar 2026', color: 'bg-blue-100 text-blue-700' },
                  { name: 'Siti Nurhaliza', phone: '08567890123', type: 'Tipe 60/90', status: 'Survei', date: '14 Mar 2026', color: 'bg-yellow-100 text-yellow-700' },
                  { name: 'Budi Santoso', phone: '08112233445', type: 'Tipe 36/60', status: 'Deal', date: '14 Mar 2026', color: 'bg-emerald-100 text-emerald-700' },
                  { name: 'Rina Kusuma', phone: '08998877665', type: 'Tipe 45/72', status: 'Dihubungi', date: '13 Mar 2026', color: 'bg-purple-100 text-purple-700' },
                  { name: 'Dimas Anggara', phone: '08776655443', type: 'Tipe 60/90', status: 'Batal', date: '12 Mar 2026', color: 'bg-gray-100 text-gray-700' },
                ].map((lead, i) => (
                  <tr key={i} className="hover:bg-gray-50 transition-colors">
                    <td className="px-6 py-4 font-medium text-gray-900">{lead.name}</td>
                    <td className="px-6 py-4 text-gray-500">{lead.phone}</td>
                    <td className="px-6 py-4 text-gray-500">{lead.type}</td>
                    <td className="px-6 py-4">
                      <span className={`px-3 py-1 rounded-full text-xs font-semibold ${lead.color}`}>
                        {lead.status}
                      </span>
                    </td>
                    <td className="px-6 py-4 text-gray-500">{lead.date}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Recent Pengaduan List */}
        <div className="col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col">
          <div className="p-6 border-b border-gray-100 flex justify-between items-center">
            <h3 className="text-lg font-bold text-gray-900">Pengaduan Aktif</h3>
            <button className="text-sm font-semibold text-[#C9A84C] hover:text-[#b59640]">Lihat Semua</button>
          </div>
          <div className="p-6 flex-1 flex flex-col gap-4">
            {[
              { title: 'Atap garasi bocor', resident: 'Budi (A-01)', status: 'Diterima', icon: <AlertCircle className="w-5 h-5 text-rose-500" /> },
              { title: 'Lampu taman mati', resident: 'Siti (B-05)', status: 'Diproses', icon: <Clock className="w-5 h-5 text-yellow-500" /> },
              { title: 'Saluran air mampet', resident: 'Agus (C-12)', status: 'Selesai', icon: <CheckCircle className="w-5 h-5 text-emerald-500" /> },
            ].map((item, i) => (
              <div key={i} className="flex items-start gap-4 p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-colors">
                <div className="mt-1">{item.icon}</div>
                <div>
                  <h4 className="font-semibold text-gray-900 text-sm">{item.title}</h4>
                  <p className="text-xs text-gray-500 mt-1">Pelapor: {item.resident}</p>
                  <span className={`inline-block mt-2 text-xs font-semibold px-2 py-0.5 rounded-md ${
                    item.status === 'Diterima' ? 'bg-rose-100 text-rose-700' :
                    item.status === 'Diproses' ? 'bg-yellow-100 text-yellow-700' : 'bg-emerald-100 text-emerald-700'
                  }`}>
                    {item.status}
                  </span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
