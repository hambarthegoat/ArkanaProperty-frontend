import { motion } from 'motion/react';
import { MapPin } from 'lucide-react';

export function Location() {
  const pois = [
    { name: 'RSUD Probolinggo', distance: '2 km' },
    { name: 'Pusat Kota', distance: '3 km' },
    { name: 'Sekolah Dasar & Menengah', distance: '500 m' },
    { name: 'Pasar Tradisional', distance: '1.5 km' },
    { name: 'Supermarket', distance: '2.5 km' },
    { name: 'Stasiun Kereta', distance: '4 km' },
  ];

  return (
    <div id="lokasi" className="py-24 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl font-extrabold text-[#1A3C5E] sm:text-4xl font-['Plus_Jakarta_Sans']">
            Lokasi Strategis
          </h2>
          <p className="mt-4 text-xl text-[#6B7280] font-['Plus_Jakarta_Sans']">
            Akses mudah ke berbagai fasilitas umum untuk menunjang aktivitas Anda
          </p>
        </div>

        <div className="lg:grid lg:grid-cols-2 lg:gap-16 items-start">
          <motion.div 
            initial={{ opacity: 0, x: -20 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6 }}
            className="w-full h-[400px] rounded-2xl overflow-hidden shadow-lg border border-gray-100 mb-12 lg:mb-0"
          >
            {/* Maps placeholder since iframe can have issues */}
            <div className="w-full h-full bg-gray-200 relative group cursor-pointer">
              <img 
                src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1200&auto=format&fit=crop" 
                alt="Map"
                className="w-full h-full object-cover opacity-70 group-hover:opacity-90 transition-opacity duration-300"
              />
              <div className="absolute inset-0 flex items-center justify-center">
                <div className="bg-white/90 p-4 rounded-full shadow-xl transform group-hover:scale-110 transition-transform duration-300">
                  <MapPin className="w-8 h-8 text-[#1A3C5E]" />
                </div>
              </div>
            </div>
          </motion.div>

          <motion.div 
            initial={{ opacity: 0, x: 20 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
          >
            <h3 className="text-2xl font-bold text-[#1F2937] font-['Plus_Jakarta_Sans'] mb-4">
              Arkanaproperty
            </h3>
            <p className="text-lg text-[#6B7280] font-['Plus_Jakarta_Sans'] mb-8">
              Jl. Raya Probolinggo No. 123, Kecamatan Kanigaran, Kota Probolinggo, Jawa Timur 67211
            </p>

            <h4 className="text-xl font-bold text-[#1F2937] font-['Plus_Jakarta_Sans'] mb-6 border-b border-gray-100 pb-4">
              Akses Sekitar
            </h4>
            
            <ul className="space-y-4">
              {pois.map((poi, index) => (
                <li key={index} className="flex justify-between items-center bg-[#F8F9FA] p-4 rounded-xl border border-gray-100">
                  <span className="font-semibold text-[#1A3C5E] font-['Plus_Jakarta_Sans']">{poi.name}</span>
                  <span className="font-bold text-[#C9A84C] font-['Plus_Jakarta_Sans'] bg-[#C9A84C]/10 px-3 py-1 rounded-lg text-sm">{poi.distance}</span>
                </li>
              ))}
            </ul>
          </motion.div>
        </div>
      </div>
    </div>
  );
}
