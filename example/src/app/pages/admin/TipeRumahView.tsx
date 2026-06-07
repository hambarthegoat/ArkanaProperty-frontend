import { Plus, Edit, Trash2, Image as ImageIcon } from 'lucide-react';

export function TipeRumahView() {
  const dummyData = [
    { id: 1, nama: 'Tipe 36/60', lt: 60, lb: 36, harga: 'Rp 450.000.000', aktif: true },
    { id: 2, nama: 'Tipe 45/72', lt: 72, lb: 45, harga: 'Rp 650.000.000', aktif: true },
    { id: 3, nama: 'Tipe 60/90', lt: 90, lb: 60, harga: 'Rp 850.000.000', aktif: false },
  ];

  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
      <div className="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
          <h2 className="text-xl font-bold text-gray-900">Manajemen Tipe Rumah</h2>
          <p className="text-sm text-gray-500 mt-1">Kelola varian tipe rumah yang ditawarkan ke konsumen.</p>
        </div>
        <button className="bg-[#C9A84C] hover:bg-[#b59640] text-white px-4 py-2.5 rounded-lg font-semibold transition-colors flex items-center gap-2 text-sm shadow-sm">
          <Plus className="w-4 h-4" />
          Tambah Tipe
        </button>
      </div>

      <div className="overflow-x-auto flex-1 p-6">
        <table className="w-full text-left border-collapse">
          <thead>
            <tr className="bg-gray-50 text-gray-500 text-sm border-b border-gray-200">
              <th className="px-6 py-4 font-medium rounded-tl-lg">Foto</th>
              <th className="px-6 py-4 font-medium">Nama Tipe</th>
              <th className="px-6 py-4 font-medium">Luas Tanah</th>
              <th className="px-6 py-4 font-medium">Luas Bangunan</th>
              <th className="px-6 py-4 font-medium">Harga Dasar</th>
              <th className="px-6 py-4 font-medium">Status</th>
              <th className="px-6 py-4 font-medium rounded-tr-lg text-right">Aksi</th>
            </tr>
          </thead>
          <tbody className="divide-y divide-gray-100 text-sm">
            {dummyData.map((item) => (
              <tr key={item.id} className="hover:bg-gray-50 transition-colors">
                <td className="px-6 py-4">
                  <div className="w-16 h-12 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                    <ImageIcon className="w-5 h-5" />
                  </div>
                </td>
                <td className="px-6 py-4 font-bold text-gray-900">{item.nama}</td>
                <td className="px-6 py-4 text-gray-600">{item.lt} m²</td>
                <td className="px-6 py-4 text-gray-600">{item.lb} m²</td>
                <td className="px-6 py-4 font-medium text-gray-900">{item.harga}</td>
                <td className="px-6 py-4">
                  <label className="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" className="sr-only peer" defaultChecked={item.aktif} />
                    <div className="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#1A3C5E]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1A3C5E]"></div>
                  </label>
                </td>
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

        {dummyData.length === 0 && (
          <div className="text-center py-16">
            <div className="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
              <Building className="w-10 h-10 text-gray-300" />
            </div>
            <h3 className="text-lg font-bold text-gray-900 mb-1">Belum ada tipe rumah</h3>
            <p className="text-gray-500 text-sm mb-6">Tambahkan tipe rumah pertama Anda untuk mulai mengelola.</p>
            <button className="bg-[#1A3C5E] text-white px-5 py-2.5 rounded-lg font-semibold inline-flex items-center gap-2 text-sm">
              <Plus className="w-4 h-4" /> Tambah Tipe
            </button>
          </div>
        )}
      </div>
    </div>
  );
}
