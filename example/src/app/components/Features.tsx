import { motion } from 'motion/react';
import { MapPin, Route, ShieldCheck, TreePine, Landmark, FileText } from 'lucide-react';

const features = [
  {
    icon: MapPin,
    title: 'Lokasi Strategis',
    description: 'Dekat dengan pusat kota, sekolah, rumah sakit, dan pusat perbelanjaan.'
  },
  {
    icon: Route,
    title: 'Akses Jalan Lebar',
    description: 'Jalan utama lebar dengan paving block yang rapi dan nyaman dilalui.'
  },
  {
    icon: ShieldCheck,
    title: 'Keamanan 24 Jam',
    description: 'One gate system, CCTV, dan security yang berjaga sepanjang hari.'
  },
  {
    icon: TreePine,
    title: 'Area Hijau',
    description: 'Dilengkapi taman bermain anak dan area hijau yang asri.'
  },
  {
    icon: Landmark,
    title: 'KPR Berbagai Bank',
    description: 'Bekerja sama dengan berbagai bank ternama untuk kemudahan KPR.'
  },
  {
    icon: FileText,
    title: 'Sertifikat SHM',
    description: 'Legalitas aman dan terjamin, sertifikat Hak Milik sudah pecah per kavling.'
  }
];

export function Features() {
  return (
    <div id="keunggulan" className="py-24 bg-[#F8F9FA]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl font-extrabold text-[#1A3C5E] sm:text-4xl font-['Plus_Jakarta_Sans']">
            Mengapa Arkanaproperty?
          </h2>
          <p className="mt-4 text-xl text-[#6B7280] font-['Plus_Jakarta_Sans']">
            Keunggulan yang menjadikan perumahan kami pilihan terbaik untuk Anda
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          {features.map((feature, index) => {
            const Icon = feature.icon;
            return (
              <motion.div
                key={index}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ duration: 0.5, delay: index * 0.1 }}
                className="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 group"
              >
                <div className="w-14 h-14 bg-[#1A3C5E]/5 rounded-xl flex items-center justify-center mb-6 group-hover:bg-[#C9A84C]/10 group-hover:text-[#C9A84C] transition-colors duration-300">
                  <Icon className="w-7 h-7 text-[#1A3C5E] group-hover:text-[#C9A84C] transition-colors duration-300" />
                </div>
                <h3 className="text-xl font-bold text-[#1F2937] font-['Plus_Jakarta_Sans'] mb-3">
                  {feature.title}
                </h3>
                <p className="text-[#6B7280] font-['Plus_Jakarta_Sans'] leading-relaxed">
                  {feature.description}
                </p>
              </motion.div>
            );
          })}
        </div>
      </div>
    </div>
  );
}
