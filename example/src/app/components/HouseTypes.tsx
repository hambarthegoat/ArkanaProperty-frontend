import { useState } from 'react';
import { motion, AnimatePresence } from 'motion/react';
import { X, CheckCircle2, BedDouble, Bath, Car, Maximize, Ruler } from 'lucide-react';

const houseTypes = [
  {
    id: 1,
    name: 'Tipe 36/60',
    image: 'https://images.unsplash.com/photo-1768832034516-e019de2cf44f?q=80&w=800&auto=format&fit=crop',
    landArea: '60 m²',
    buildArea: '36 m²',
    price: 'Mulai Rp 350 Jutaan',
    status: 'Tersedia',
    statusColor: 'bg-[#0F6E56] text-white',
  },
  {
    id: 2,
    name: 'Tipe 45/72',
    image: 'https://images.unsplash.com/photo-1648147870253-c45f6f430528?q=80&w=800&auto=format&fit=crop',
    landArea: '72 m²',
    buildArea: '45 m²',
    price: 'Mulai Rp 450 Jutaan',
    status: 'Indent',
    statusColor: 'bg-yellow-500 text-white',
  },
  {
    id: 3,
    name: 'Tipe 72/90',
    image: 'https://images.unsplash.com/photo-1766603636562-531bb3e1dda8?q=80&w=800&auto=format&fit=crop',
    landArea: '90 m²',
    buildArea: '72 m²',
    price: 'Mulai Rp 650 Jutaan',
    status: 'Terjual Habis',
    statusColor: 'bg-red-500 text-white',
  },
];

export function HouseTypes() {
  const [selectedHouse, setSelectedHouse] = useState<number | null>(null);

  // Data detail khusus untuk Tipe 36/60 sebagai contoh popup
  const exampleDetail = {
    features: ["2 Kamar Tidur", "1 Kamar Mandi", "Ruang Tamu & Keluarga", "Dapur", "Carport 1 Mobil", "Taman Depan & Belakang"],
    specs: [
      { label: "Pondasi", value: "Batu Kali" },
      { label: "Dinding", value: "Bata Merah (Diplester & Dicat)" },
      { label: "Lantai", value: "Granit 60x60" },
      { label: "Atap", value: "Rangka Baja Ringan, Genteng Beton" },
      { label: "Sanitari", value: "Kloset Duduk & Shower" },
      { label: "Listrik", value: "1300 Watt" }
    ]
  };

  return (
    <div id="tipe-rumah" className="py-24 bg-[#F8F9FA]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl font-extrabold text-[#1A3C5E] sm:text-4xl font-['Plus_Jakarta_Sans']">
            Tipe Rumah
          </h2>
          <p className="mt-4 text-xl text-[#6B7280] font-['Plus_Jakarta_Sans']">
            Pilih hunian yang sesuai dengan kebutuhan dan gaya hidup Anda
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {houseTypes.map((type, index) => (
            <motion.div
              key={type.id}
              initial={{ opacity: 0, y: 20 }}
              whileInView={{ opacity: 1, y: 0 }}
              viewport={{ once: true }}
              transition={{ duration: 0.5, delay: index * 0.1 }}
              className="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-shadow duration-300 flex flex-col h-full"
            >
              <div className="relative h-64 overflow-hidden">
                <img 
                  src={type.image} 
                  alt={type.name} 
                  className="w-full h-full object-cover transform hover:scale-105 transition-transform duration-500"
                />
                <div className={`absolute top-4 right-4 px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-md font-['Plus_Jakarta_Sans'] shadow-md ${type.statusColor}`}>
                  {type.status}
                </div>
              </div>
              
              <div className="p-6 flex-grow flex flex-col">
                <h3 className="text-2xl font-bold text-[#1A3C5E] font-['Plus_Jakarta_Sans'] mb-2">
                  {type.name}
                </h3>
                
                <div className="grid grid-cols-2 gap-4 mb-6 pt-4 border-t border-gray-100">
                  <div>
                    <p className="text-xs text-[#6B7280] font-medium uppercase font-['Plus_Jakarta_Sans']">Luas Tanah</p>
                    <p className="text-lg font-semibold text-[#1F2937] font-['Plus_Jakarta_Sans']">{type.landArea}</p>
                  </div>
                  <div>
                    <p className="text-xs text-[#6B7280] font-medium uppercase font-['Plus_Jakarta_Sans']">Luas Bangunan</p>
                    <p className="text-lg font-semibold text-[#1F2937] font-['Plus_Jakarta_Sans']">{type.buildArea}</p>
                  </div>
                </div>
                
                <div className="mt-auto">
                  <div className="mb-6">
                    <p className="text-sm text-[#6B7280] font-medium font-['Plus_Jakarta_Sans']">Harga</p>
                    <p className="text-xl font-bold text-[#C9A84C] font-['Plus_Jakarta_Sans']">{type.price}</p>
                  </div>
                  
                  <button 
                    onClick={() => type.id === 1 ? setSelectedHouse(1) : alert("Demo: Popup lihat detail ini hanya tersedia untuk contoh 'Tipe 36/60'.")}
                    className="w-full py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-[#1A3C5E] hover:bg-[#1A3C5E]/90 focus:outline-none transition-colors font-['Plus_Jakarta_Sans']"
                  >
                    Lihat Detail
                  </button>
                </div>
              </div>
            </motion.div>
          ))}
        </div>
      </div>

      {/* Popup / Modal Detail (Contoh Tipe 36/60) */}
      <AnimatePresence>
        {selectedHouse === 1 && (
          <>
            {/* Backdrop */}
            <motion.div
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => setSelectedHouse(null)}
              className="fixed inset-0 z-50 bg-black/60 backdrop-blur-sm"
            />
            
            {/* Modal Content */}
            <div className="fixed inset-0 z-50 flex items-center justify-center p-4 pointer-events-none">
              <motion.div
                initial={{ opacity: 0, scale: 0.95, y: 20 }}
                animate={{ opacity: 1, scale: 1, y: 0 }}
                exit={{ opacity: 0, scale: 0.95, y: 20 }}
                className="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden pointer-events-auto flex flex-col max-h-[90vh] relative"
              >
                {/* Tombol Close Floating */}
                <button 
                  onClick={() => setSelectedHouse(null)}
                  className="absolute top-4 right-4 z-[60] p-2 bg-white/90 backdrop-blur-sm text-gray-500 hover:text-[#1A3C5E] hover:bg-white rounded-full shadow-lg transition-all border border-gray-100 flex items-center justify-center"
                >
                  <X className="w-6 h-6" />
                </button>

                <div className="flex flex-col lg:flex-row h-full overflow-hidden">
                  {/* Bagian Gambar */}
                  <div className="lg:w-1/2 relative bg-gray-100">
                    <img 
                      src={houseTypes[0].image} 
                      alt={houseTypes[0].name}
                      className="w-full h-64 lg:h-full object-cover"
                    />
                    <div className="absolute top-4 left-4 px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-md font-['Plus_Jakarta_Sans'] shadow-md bg-[#0F6E56] text-white z-10">
                      Tersedia
                    </div>
                  </div>

                  {/* Bagian Info */}
                  <div className="lg:w-1/2 p-6 md:p-8 flex flex-col overflow-y-auto">
                    <div className="mb-2 pr-10">
                      <h3 className="text-3xl font-bold text-[#1A3C5E] font-['Plus_Jakarta_Sans']">{houseTypes[0].name}</h3>
                    </div>
                    
                    <p className="text-2xl font-bold text-[#C9A84C] font-['Plus_Jakarta_Sans'] mb-6">
                      {houseTypes[0].price}
                    </p>

                    {/* Quick Stats */}
                    <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
                      <div className="bg-gray-50 p-3 rounded-xl flex flex-col items-center justify-center text-center">
                        <Maximize className="w-5 h-5 text-[#1A3C5E] mb-1.5" />
                        <span className="text-[10px] text-gray-500 uppercase font-bold">L. Tanah</span>
                        <span className="text-sm font-semibold text-gray-900">{houseTypes[0].landArea}</span>
                      </div>
                      <div className="bg-gray-50 p-3 rounded-xl flex flex-col items-center justify-center text-center">
                        <Ruler className="w-5 h-5 text-[#1A3C5E] mb-1.5" />
                        <span className="text-[10px] text-gray-500 uppercase font-bold">L. Bangunan</span>
                        <span className="text-sm font-semibold text-gray-900">{houseTypes[0].buildArea}</span>
                      </div>
                      <div className="bg-gray-50 p-3 rounded-xl flex flex-col items-center justify-center text-center">
                        <BedDouble className="w-5 h-5 text-[#1A3C5E] mb-1.5" />
                        <span className="text-[10px] text-gray-500 uppercase font-bold">Kamar</span>
                        <span className="text-sm font-semibold text-gray-900">2</span>
                      </div>
                      <div className="bg-gray-50 p-3 rounded-xl flex flex-col items-center justify-center text-center">
                        <Bath className="w-5 h-5 text-[#1A3C5E] mb-1.5" />
                        <span className="text-[10px] text-gray-500 uppercase font-bold">K. Mandi</span>
                        <span className="text-sm font-semibold text-gray-900">1</span>
                      </div>
                    </div>

                    <div className="space-y-6 flex-grow">
                      {/* Features */}
                      <div>
                        <h4 className="text-lg font-bold text-gray-900 mb-3 font-['Plus_Jakarta_Sans']">Fasilitas Utama</h4>
                        <ul className="grid grid-cols-1 sm:grid-cols-2 gap-2">
                          {exampleDetail.features.map((feature, idx) => (
                            <li key={idx} className="flex items-center text-sm text-gray-600">
                              <CheckCircle2 className="w-4 h-4 text-[#C9A84C] mr-2 shrink-0" />
                              {feature}
                            </li>
                          ))}
                        </ul>
                      </div>

                      {/* Spesifikasi */}
                      <div>
                        <h4 className="text-lg font-bold text-gray-900 mb-3 font-['Plus_Jakarta_Sans']">Spesifikasi Teknis</h4>
                        <div className="space-y-2">
                          {exampleDetail.specs.map((spec, idx) => (
                            <div key={idx} className="flex flex-col sm:flex-row sm:justify-between py-2 border-b border-gray-100 last:border-0">
                              <span className="text-sm text-gray-500 font-medium mb-1 sm:mb-0">{spec.label}</span>
                              <span className="text-sm text-gray-900 font-semibold sm:text-right">{spec.value}</span>
                            </div>
                          ))}
                        </div>
                      </div>
                    </div>

                    {/* Action Button */}
                    <div className="mt-8 pt-6 border-t border-gray-100">
                      <a 
                        href="#kontak" 
                        onClick={() => setSelectedHouse(null)}
                        className="w-full flex items-center justify-center py-3.5 px-4 rounded-lg shadow-md text-sm font-bold text-[#1A3C5E] bg-[#C9A84C] hover:bg-[#b59540] focus:outline-none transition-all font-['Plus_Jakarta_Sans']"
                      >
                        Hubungi Kami untuk Penawaran
                      </a>
                    </div>
                  </div>
                </div>
              </motion.div>
            </div>
          </>
        )}
      </AnimatePresence>
    </div>
  );
}
