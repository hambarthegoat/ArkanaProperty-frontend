import { Plus, Edit, Trash2, Filter } from 'lucide-react';

export function KavlingView() {
  const dummyData = [
    { id: 1, blok: 'A', nomor: '01', tipe: 'Tipe 36/60', status: 'Tersedia', penghuni: '-' },
    { id: 2, blok: 'A', nomor: '02', tipe: 'Tipe 45/72', status: 'Terjual', penghuni: 'Budi Santoso' },
    { id: 3, blok: 'A', nomor: '03', tipe: 'Tipe 45/72', status: 'Indent', penghuni: 'Siti Nurhaliza' },
    { id: 4, blok: 'B', nomor: '01', tipe: 'Tipe 60/90', status: 'Tersedia', penghuni: '-' },
    { id: 5, blok: 'B', nomor: '02', tipe: 'Tipe 60/90', status: 'Tersedia', penghuni: '-' },
  ];

  const getStatusBadge = (status: string) => {
    switch (status) {
      case 'Tersedia':
        return 'bg-emerald-100 text-emerald-700 border-emerald-200';
      case 'Indent':
        return 'bg-yellow-100 text-yellow-700 border-yellow-200';
      case 'Terjual':
        return 'bg-rose-100 text-rose-700 border-rose-200';
      default:
        return 'bg-gray-100 text-gray-700 border-gray-200';
    }
  };

  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
      <div className="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h2 className="text-xl font-bold text-gray-900">Manajemen Kavling</h2>
          <p className="text-sm text-gray-500 mt-1">Kelola ketersediaan blok dan nomor kavling.</p>
        </div>
        <button className="bg-[#C9A84C] hover:bg-[#b59640] text-white px-4 py-2.5 rounded-lg font-semibold transition-colors flex items-center gap-2 text-sm shadow-sm whitespace-nowrap">
          <Plus className="w-4 h-4" />
          Tambah Kavling
        </button>
      </div>

      <div className="p-4 bg-gray-50 border-b border-gray-100 flex flex-wrap gap-3 items-center">
        <div className="flex items-center gap-2 text-sm text-gray-600 font-medium mr-2">
          <Filter className="w-4 h-4" />
          Filter:
        </div>
        <select className="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1A3C5E] min-w-[150px]">
          <option>Semua Tipe Rumah</option>
          <option>Tipe 36/60</option>
          <option>Tipe 45/72</option>
          <option>Tipe 60/90</option>
        </select>
        <select className="px-3 py-2 bg-white border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-[#1A3C5E] min-w-[150px]">
          <option>Semua Status</option>
          <option>Tersedia</option>
          <option>Indent</option>
          <option>Terjual</option>
        </select>
      </div>

      <div className="overflow-x-auto flex-1 p-6">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
              <th className="px-6 py-4 font-medium rounded-tl-lg">Blok</th>
              <th className="px-6 py-4 font-medium">Nomor</th>
              <th className="px-6 py-4 font-medium">Tipe Rumah</th>
              <th className="px-6 py-4 font-medium">Status</th>
              <th className="px-6 py-4 font-medium">Penghuni</th>
              <th className="px-6 py-4 font-medium rounded-tr-lg text-right">Aksi</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-100 text-sm">
            {dummyData.map((item) => (
              <tr key={item.id} className="hover:bg-gray-50 transition-colors">
                <td className="px-6 py-4 font-bold text-gray-900">{item.blok}</td>
                <td className="px-6 py-4 font-medium text-gray-900">{item.nomor}</td>
                <td className="px-6 py-4 text-gray-600">{item.tipe}</td>
                <td className="px-6 py-4">
                  <span className={`px-3 py-1.5 rounded-full text-xs font-semibold border ${getStatusBadge(item.status)}`}>
                    {item.status}
                  </span>
                </td>
                <td className="px-6 py-4 text-gray-500">{item.penghuni}</td>
                <td className="px-6 py-4 text-right">
                  <div className="flex justify-end gap-2">
                    <button className="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                      <Edit className="w-4 h-4" />
                    </button>
                    <button className="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors">
                      <Trash2 className="w-4 h-4" />
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
