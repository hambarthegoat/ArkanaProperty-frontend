import { Download, Filter, Search, MoreVertical, Eye } from 'lucide-react';

export function LeadsView() {
  const dummyLeads = [
    { id: 1, nama: 'Andi Pratama', hp: '08123456789', tipe: 'Tipe 45/72', tanggal: '15 Mar 2026', status: 'Baru' },
    { id: 2, nama: 'Siti Nurhaliza', hp: '08567890123', tipe: 'Tipe 60/90', tanggal: '14 Mar 2026', status: 'Survei' },
    { id: 3, nama: 'Budi Santoso', hp: '08112233445', tipe: 'Tipe 36/60', tanggal: '14 Mar 2026', status: 'Deal' },
    { id: 4, nama: 'Rina Kusuma', hp: '08998877665', tipe: 'Tipe 45/72', tanggal: '13 Mar 2026', status: 'Dihubungi' },
    { id: 5, nama: 'Dimas Anggara', hp: '08776655443', tipe: 'Tipe 60/90', tanggal: '12 Mar 2026', status: 'Batal' },
    { id: 6, nama: 'Ayu Lestari', hp: '08223344556', tipe: 'Tipe 36/60', tanggal: '11 Mar 2026', status: 'Dihubungi' },
  ];

  const getStatusBadge = (status: string) => {
    switch (status) {
      case 'Baru': return 'bg-blue-100 text-blue-700';
      case 'Dihubungi': return 'bg-purple-100 text-purple-700';
      case 'Survei': return 'bg-yellow-100 text-yellow-700';
      case 'Deal': return 'bg-emerald-100 text-emerald-700';
      case 'Batal': return 'bg-gray-100 text-gray-700';
      default: return 'bg-gray-100 text-gray-700';
    }
  };

  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
      <div className="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h2 className="text-xl font-bold text-gray-900">Data Leads</h2>
          <p className="text-sm text-gray-500 mt-1">Pantau dan kelola prospek calon pembeli.</p>
        </div>
        <button className="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 px-4 py-2.5 rounded-lg font-semibold transition-colors flex items-center gap-2 text-sm shadow-sm whitespace-nowrap">
          <Download className="w-4 h-4" />
          Export Excel
        </button>
      </div>

      <div className="p-4 bg-gray-50 border-b border-gray-100 flex flex-wrap gap-3 items-center justify-between">
        <div className="flex flex-wrap items-center gap-3">
          <div className="relative">
            <Search className="w-4 h-4 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" />
            <input 
              type="text" 
              placeholder="Cari nama atau no HP..." 
              className="pl-9 pr-4 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1A3C5E] w-full sm:w-64"
            />
          </div>
          <select className="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1A3C5E]">
            <option>Semua Status</option>
            <option>Baru</option>
            <option>Dihubungi</option>
            <option>Survei</option>
            <option>Deal</option>
            <option>Batal</option>
          </select>
          <select className="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1A3C5E]">
            <option>Semua Tipe</option>
            <option>Tipe 36/60</option>
            <option>Tipe 45/72</option>
            <option>Tipe 60/90</option>
          </select>
        </div>
      </div>

      <div className="overflow-x-auto flex-1 p-6">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
              <th className="px-6 py-4 font-medium rounded-tl-lg">Nama Prospek</th>
              <th className="px-6 py-4 font-medium">No. HP</th>
              <th className="px-6 py-4 font-medium">Tipe Diminati</th>
              <th className="px-6 py-4 font-medium">Tanggal Masuk</th>
              <th className="px-6 py-4 font-medium">Status</th>
              <th className="px-6 py-4 font-medium rounded-tr-lg text-right">Aksi</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-100 text-sm">
            {dummyLeads.map((item) => (
              <tr key={item.id} className="hover:bg-gray-50 transition-colors">
                <td className="px-6 py-4 font-bold text-gray-900">{item.nama}</td>
                <td className="px-6 py-4 text-gray-600">{item.hp}</td>
                <td className="px-6 py-4 text-gray-600">{item.tipe}</td>
                <td className="px-6 py-4 text-gray-500">{item.tanggal}</td>
                <td className="px-6 py-4">
                  <span className={`px-3 py-1 rounded-full text-xs font-semibold ${getStatusBadge(item.status)}`}>
                    {item.status}
                  </span>
                </td>
                <td className="px-6 py-4 text-right">
                  <div className="flex justify-end gap-2">
                    <button className="p-2 text-gray-400 hover:text-[#1A3C5E] hover:bg-blue-50 rounded-lg transition-colors flex items-center gap-1 text-xs font-semibold">
                      <Eye className="w-4 h-4" /> Detail
                    </button>
                    <button className="p-2 text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                      <MoreVertical className="w-4 h-4" />
                    </button>
                  </div>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      </div>
    </div>
  );
}
