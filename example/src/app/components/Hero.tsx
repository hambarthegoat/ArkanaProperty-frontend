import { motion } from 'motion/react';
import { ArrowDown } from 'lucide-react';

export function Hero() {
  return (
    <div id="beranda" className="relative min-h-screen flex flex-col justify-center items-center overflow-hidden">
      {/* Background Image with Dark Overlay */}
      <div 
        className="absolute inset-0 z-0 bg-cover bg-center bg-no-repeat"
        style={{ 
          backgroundImage: 'url("https://images.unsplash.com/photo-1766603636562-531bb3e1dda8?q=80&w=2000&auto=format&fit=crop")',
        }}
      >
        <div className="absolute inset-0 bg-black/60"></div>
      </div>

      <div className="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center w-full mt-20">
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
        >
          <h1 className="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold text-white tracking-tight mb-6 font-['Plus_Jakarta_Sans']">
            Hunian Modern,<br className="hidden sm:block" /> Harga Terjangkau
          </h1>
          <p className="mt-4 text-lg sm:text-xl md:text-2xl text-gray-200 max-w-3xl mx-auto font-['Plus_Jakarta_Sans'] leading-relaxed mb-10">
            Arkanaproperty — Perumahan konsep minimalis modern di lokasi strategis dengan fasilitas lengkap untuk keluarga Anda.
          </p>

          <div className="flex flex-col sm:flex-row justify-center items-center gap-4">
            <a 
              href="#tipe-rumah" 
              className="w-full sm:w-auto px-8 py-4 bg-[#C9A84C] hover:bg-[#b59640] text-white font-semibold rounded-lg text-lg transition-colors font-['Plus_Jakarta_Sans']"
            >
              Lihat Tipe Rumah
            </a>
            <a 
              href="#kontak" 
              className="w-full sm:w-auto px-8 py-4 bg-transparent border-2 border-white text-white hover:bg-white/10 font-semibold rounded-lg text-lg transition-colors font-['Plus_Jakarta_Sans']"
            >
              Hubungi Sales
            </a>
          </div>
        </motion.div>
      </div>

      {/* Scroll indicator */}
      <motion.div 
        initial={{ opacity: 0 }}
        animate={{ opacity: 1, y: [0, 10, 0] }}
        transition={{ duration: 2, repeat: Infinity, delay: 1 }}
        className="absolute bottom-10 left-1/2 transform -translate-x-1/2 z-10"
      >
        <a href="#stats" className="text-white/70 hover:text-white transition-colors">
          <ArrowDown className="w-8 h-8" />
        </a>
      </motion.div>
    </div>
  );
}
