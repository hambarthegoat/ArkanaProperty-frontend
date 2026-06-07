import { 
  Bell, 
  Calendar, 
  CheckCircle2, 
  Clock, 
  MessageCircle, 
  ChevronRight,
  Info,
  MapPin,
  FileText,
  ArrowRight
} from "lucide-react";
import { motion } from "motion/react";

const REMINDERS = [
  { 
    id: 1, 
    title: "Jadwal Survey Lokasi", 
    date: "10 Juni 2026", 
    time: "10:00 WIB", 
    desc: "Survey bersama Marketing Dimas di Unit Blok A-12.",
    status: "Upcoming",
    icon: Calendar
  },
  { 
    id: 2, 
    title: "Batas Waktu Pembayaran DP", 
    date: "15 Juni 2026", 
    time: "23:59 WIB", 
    desc: "Segera lakukan pelunasan uang muka sebesar Rp 5.000.000.",
    status: "Pending",
    icon: Clock
  },
  { 
    id: 3, 
    title: "Verifikasi Data Berkas", 
    date: "5 Juni 2026", 
    time: "Selesai", 
    desc: "KTP, KK, dan NPWP telah diverifikasi oleh tim admin.",
    status: "Completed",
    icon: CheckCircle2
  },
];

export function UserPortal() {
  return (
    <div className="max-w-4xl mx-auto space-y-10 relative">
      {/* Welcome Section */}
      <div className="flex flex-col md:flex-row items-center gap-8 bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
        <div className="w-24 h-24 bg-surface-soft rounded-full overflow-hidden border-2 border-accent shrink-0">
          <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=Ahmad" alt="User" />
        </div>
        <div className="text-center md:text-left flex-grow">
          <h1 className="text-3xl font-black text-primary mb-1">Halo, Bapak Ahmad!</h1>
          <p className="text-primary/60">Selamat datang di portal Arkanaproperty. Unit Anda di <span className="font-bold text-accent">Blok A-12</span> sedang dalam tahap persiapan berkas.</p>
        </div>
        <div className="hidden lg:flex gap-4">
          <div className="text-center p-4 bg-surface-soft rounded-2xl min-w-[120px]">
            <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Unit Type</p>
            <p className="font-black text-primary">Tipe 36/60</p>
          </div>
        </div>
      </div>

      {/* Progress Timeline */}
      <section className="space-y-6">
        <div className="flex items-center justify-between">
          <h2 className="text-xl font-black text-primary flex items-center gap-2">
            <Bell size={20} className="text-accent" /> Agenda & Timeline
          </h2>
          <span className="text-xs font-bold text-primary/40 uppercase tracking-widest">Update: 7 Juni 2026</span>
        </div>

        <div className="space-y-4">
          {REMINDERS.map((item, i) => (
            <motion.div 
              initial={{ opacity: 0, x: -20 }}
              animate={{ opacity: 1, x: 0 }}
              transition={{ delay: i * 0.1 }}
              key={item.id} 
              className={`flex gap-6 p-6 bg-white rounded-3xl border ${
                item.status === 'Pending' ? 'border-orange-200 bg-orange-50/30' : 'border-border-subtle'
              } shadow-sm group hover:shadow-md transition-all`}
            >
              <div className={`shrink-0 w-14 h-14 rounded-2xl flex items-center justify-center ${
                item.status === 'Completed' ? 'bg-emerald-100 text-emerald-600' : 
                item.status === 'Pending' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600'
              }`}>
                <item.icon size={24} />
              </div>
              <div className="flex-grow">
                <div className="flex flex-col sm:flex-row sm:items-center justify-between mb-2 gap-2">
                  <h3 className="font-bold text-lg text-primary">{item.title}</h3>
                  <div className="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-primary/40">
                    <Calendar size={12} /> {item.date} • {item.time}
                  </div>
                </div>
                <p className="text-sm text-primary/60 leading-relaxed max-w-xl">{item.desc}</p>
                {item.status === 'Pending' && (
                  <button className="mt-4 flex items-center gap-2 text-xs font-bold text-orange-600 hover:gap-3 transition-all">
                    Lakukan Pembayaran Sekarang <ChevronRight size={14} />
                  </button>
                )}
              </div>
            </motion.div>
          ))}
        </div>
      </section>

      {/* Resource Cards */}
      <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div className="bg-primary text-white p-8 rounded-[32px] relative overflow-hidden group cursor-pointer shadow-xl">
          <div className="relative z-10">
            <FileText className="text-accent mb-4" size={32} />
            <h4 className="font-black text-xl mb-2">Dokumen Digital</h4>
            <p className="text-white/60 text-sm mb-6">Unduh brosur, denah unit, dan salinan berkas verifikasi Anda di sini.</p>
            <div className="inline-flex items-center gap-2 text-xs font-bold py-2 px-4 bg-white/10 rounded-full group-hover:bg-accent transition-colors">
              Lihat Dokumen <ChevronRight size={16} />
            </div>
          </div>
          <div className="absolute bottom-0 right-0 w-40 h-40 bg-white/5 rounded-full translate-y-1/2 translate-x-1/2 group-hover:scale-110 transition-transform"></div>
        </div>

        <div className="bg-white border border-border-subtle p-8 rounded-[32px] group cursor-pointer shadow-sm hover:shadow-xl transition-all">
          <MapPin className="text-accent mb-4" size={32} />
          <h4 className="font-black text-xl text-primary mb-2">Lokasi Unit Anda</h4>
          <p className="text-primary/60 text-sm mb-6">Akses Google Maps menuju lokasi perumahan dan posisi spesifik unit Anda.</p>
          <div className="inline-flex items-center gap-2 text-xs font-bold py-2 px-4 bg-surface-soft text-primary rounded-full group-hover:bg-primary group-hover:text-white transition-colors">
            Buka Maps <ChevronRight size={16} />
          </div>
        </div>
      </div>

      <div className="pt-10 flex items-center justify-center gap-4 text-primary/40">
        <Info size={16} />
        <p className="text-[10px] font-bold uppercase tracking-widest">Butuh bantuan lain? Hubungi marketing agent Anda.</p>
      </div>

      {/* Floating Action Button (FAB) */}
      <motion.button 
        whileHover={{ scale: 1.1 }}
        whileTap={{ scale: 0.9 }}
        className="fixed bottom-10 right-10 w-16 h-16 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-2xl shadow-emerald-custom/40 z-[99] group"
      >
        <MessageCircle size={32} />
        <div className="absolute right-full mr-4 bg-white text-primary px-4 py-2 rounded-xl border border-border-subtle shadow-xl opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap text-sm font-bold pointer-events-none">
          Hubungi Marketing
        </div>
      </motion.button>
    </div>
  );
}
