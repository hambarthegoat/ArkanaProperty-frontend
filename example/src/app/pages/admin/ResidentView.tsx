import { Plus, Edit, UserX } from 'lucide-react';

export function ResidentView() {
  const dummyResidents = [
    { id: 1, nama: 'Budi Santoso', email: 'budi.s@email.com', unit: 'A-02', tipe: 'Tipe 45/72', tanggal: '10 Jan 2026', status: 'Aktif' },
    { id: 2, nama: 'Siti Nurhaliza', email: 'siti.nur@email.com', unit: 'A-03', tipe: 'Tipe 45/72', tanggal: '15 Feb 2026', status: 'Aktif' },
    { id: 3, nama: 'Agus Setiawan', email: 'agus.set@email.com', unit: 'C-12', tipe: 'Tipe 60/90', tanggal: '05 Mar 2026', status: 'Nonaktif' },
  ];

  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
      <div className="p-6 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
          <h2 className="text-xl font-bold text-gray-900">Manajemen Akun Resident</h2>
          <p className="text-sm text-gray-500 mt-1">Buat dan kelola akses portal penghuni.</p>
        </div>
        <button className="bg-[#1A3C5E] hover:bg-[#112840] text-white px-4 py-2.5 rounded-lg font-semibold transition-colors flex items-center gap-2 text-sm shadow-sm whitespace-nowrap">
          <Plus className="w-4 h-4" />
          Buat Akun Resident
        </button>
      </div>

      <div className="overflow-x-auto flex-1 p-6">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
              <th className="px-6 py-4 font-medium rounded-tl-lg">Nama Penghuni</th>
              <th className="px-6 py-4 font-medium">Email</th>
              <th className="px-6 py-4 font-medium">No Unit / Blok</th>
              <th className="px-6 py-4 font-medium">Tipe Rumah</th>
              <th className="px-6 py-4 font-medium">Tanggal Masuk</th>
              <th className="px-6 py-4 font-medium">Status Akun</th>
              <th className="px-6 py-4 font-medium rounded-tr-lg text-right">Aksi</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-100 text-sm">
            {dummyResidents.map((item) => (
              <tr key={item.id} className="hover:bg-gray-50 transition-colors">
                <td className="px-6 py-4 font-bold text-gray-900">{item.nama}</td>
                <td className="px-6 py-4 text-gray-600">{item.email}</td>
                <td className="px-6 py-4 font-medium text-gray-900">{item.unit}</td>
                <td className="px-6 py-4 text-gray-600">{item.tipe}</td>
                <td className="px-6 py-4 text-gray-500">{item.tanggal}</td>
                <td className="px-6 py-4">
                  <span className={`px-3 py-1 rounded-full text-xs font-semibold ${
                    item.status === 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600'
                  }`}>
                    {item.status}
                  </span>
                </td>
                <td className="px-6 py-4 text-right">
                  <div className="flex justify-end gap-2">
                    <button className="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                      <Edit className="w-4 h-4" />
                    </button>
                    <button className="p-2 text-gray-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Nonaktifkan">
                      <UserX className="w-4 h-4" />
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
