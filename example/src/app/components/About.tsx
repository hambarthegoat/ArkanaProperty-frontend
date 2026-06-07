import { motion } from 'motion/react';

export function About() {
  return (
    <div id="tentang" className="py-24 bg-white overflow-hidden">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="lg:grid lg:grid-cols-2 lg:gap-16 items-center">
          
          <motion.div 
            initial={{ opacity: 0, x: -20 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.6 }}
            className="mb-12 lg:mb-0"
          >
            <h2 className="text-3xl font-extrabold text-[#1A3C5E] tracking-tight sm:text-4xl font-['Plus_Jakarta_Sans'] mb-6">
              Tentang Arkanaproperty
            </h2>
            <div className="prose prose-lg text-[#6B7280] font-['Plus_Jakarta_Sans']">
              <p className="mb-6 leading-relaxed">
                Kami menghadirkan perumahan dengan konsep minimalis modern yang dirancang khusus untuk kenyamanan keluarga Anda. Berlokasi di area strategis yang terus berkembang, Arkanaproperty menawarkan akses mudah ke berbagai fasilitas umum dengan harga yang sangat terjangkau.
              </p>
              <p className="mb-8 leading-relaxed">
                Setiap unit dibangun dengan material berkualitas tinggi dan desain arsitektur yang memaksimalkan sirkulasi udara serta pencahayaan alami. Menjadikannya hunian ideal untuk masa depan yang lebih baik.
              </p>
            </div>

            <div className="mt-8">
              <h3 className="text-lg font-bold text-[#1F2937] font-['Plus_Jakarta_Sans'] mb-4">Konsep Utama</h3>
              <div className="flex flex-wrap gap-3">
                <span className="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-[#1A3C5E]/10 text-[#1A3C5E] font-['Plus_Jakarta_Sans']">
                  Minimalis
                </span>
                <span className="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-[#1A3C5E]/10 text-[#1A3C5E] font-['Plus_Jakarta_Sans']">
                  Family Friendly
                </span>
                <span className="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-[#C9A84C]/10 text-[#C9A84C] font-['Plus_Jakarta_Sans']">
                  KPR Ready
                </span>
              </div>
            </div>

            <div className="mt-8 pt-8 border-t border-gray-100 flex gap-12">
              <div>
                <p className="text-sm font-medium text-[#6B7280] font-['Plus_Jakarta_Sans'] mb-1">Developer</p>
                <p className="text-lg font-bold text-[#1F2937] font-['Plus_Jakarta_Sans']">PT Arkana Dev</p>
              </div>
              <div>
                <p className="text-sm font-medium text-[#6B7280] font-['Plus_Jakarta_Sans'] mb-1">Tahun Dibangun</p>
                <p className="text-lg font-bold text-[#1F2937] font-['Plus_Jakarta_Sans']">2023</p>
              </div>
            </div>
          </motion.div>

          <motion.div 
            initial={{ opacity: 0, x: 20 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
            className="relative rounded-2xl overflow-hidden shadow-2xl"
          >
            <div className="absolute inset-0 bg-gradient-to-tr from-[#1A3C5E]/20 to-transparent z-10 rounded-2xl"></div>
            <img 
              src="https://images.unsplash.com/photo-1623674043631-af1a3c94e707?q=80&w=1200&auto=format&fit=crop" 
              alt="Perumahan Arkanaproperty" 
              className="w-full h-[500px] object-cover rounded-2xl transform hover:scale-105 transition-transform duration-700"
            />
          </motion.div>
        </div>
      </div>
    </div>
  );
}
