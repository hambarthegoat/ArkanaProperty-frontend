import { Image as ImageIcon } from 'lucide-react';

export function GaleriView() {
  return (
    <div className="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">
      <div className="p-6 border-b border-gray-100 flex justify-between items-center">
        <div>
          <h2 className="text-xl font-bold text-gray-900">Galeri Properti</h2>
          <p className="text-sm text-gray-500 mt-1">Kelola aset gambar untuk landing page dan aplikasi.</p>
        </div>
      </div>
      <div className="flex-1 p-10 flex flex-col items-center justify-center text-center">
        <div className="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
          <ImageIcon className="w-10 h-10 text-gray-300" />
        </div>
        <h3 className="text-lg font-bold text-gray-900 mb-1">Fitur Galeri Sedang Dibangun</h3>
        <p className="text-gray-500 text-sm max-w-sm mx-auto">Modul manajemen aset sedang dalam tahap integrasi dengan cloud storage.</p>
      </div>
    </div>
  );
}
