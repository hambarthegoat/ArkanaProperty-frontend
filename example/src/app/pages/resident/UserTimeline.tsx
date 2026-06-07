import { motion } from "motion/react";
import { 
  CheckCircle2, 
  Circle, 
  Clock, 
  FileText, 
  Home, 
  Key, 
  ShieldCheck, 
  Truck,
  ChevronRight,
  Download
} from "lucide-react";

const TIMELINE_STEPS = [
  {
    title: "Booking Fee & Administrasi",
    date: "12 Mei 2026",
    status: "Completed",
    desc: "Pembayaran tanda jadi dan penyerahan berkas awal (KTP, KK).",
    icon: FileText
  },
  {
    title: "Verifikasi Berkas & Wawancara",
    date: "25 Mei 2026",
    status: "Completed",
    desc: "Analisa kemampuan bayar oleh tim analis dan verifikasi data lapangan.",
    icon: ShieldCheck
  },
  {
    title: "Akad Kredit / Pelunasan",
    date: "15 Juni 2026",
    status: "Current",
    desc: "Penandatanganan akta jual beli dan dokumen perbankan.",
    icon: Key
  },
  {
    title: "Pembangunan Unit",
    date: "Juli - September 2026",
    status: "Upcoming",
    desc: "Proses konstruksi bangunan sesuai spesifikasi teknis.",
    icon: Home
  },
  {
    title: "Serah Terima Kunci",
    date: "Oktober 2026",
    status: "Upcoming",
    desc: "Pemeriksaan akhir unit (checklist) dan penyerahan kunci.",
    icon: Truck
  }
];

export function UserTimeline() {
  return (
    <div className="max-w-4xl mx-auto space-y-8">
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-black text-primary">Timeline Progres</h1>
          <p className="text-primary/60">Pantau setiap tahapan kepemilikan hunian Anda.</p>
        </div>
        <button className="flex items-center gap-2 px-6 py-2 border-2 border-accent text-accent rounded-full font-bold text-xs hover:bg-accent hover:text-white transition-all active:scale-95">
          <Download size={16} /> Unduh Panduan Konsumen
        </button>
      </div>

      <div className="bg-white p-8 md:p-12 rounded-[40px] border border-border-subtle shadow-sm">
        <div className="relative">
          {/* Vertical Line */}
          <div className="absolute left-[27px] top-2 bottom-2 w-0.5 bg-border-subtle md:left-1/2 md:-translate-x-1/2 hidden sm:block"></div>

          <div className="space-y-12 relative">
            {TIMELINE_STEPS.map((step, index) => (
              <motion.div 
                key={index}
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.1 }}
                className={`flex flex-col sm:flex-row items-start gap-8 relative ${
                  index % 2 === 0 ? 'sm:flex-row-reverse' : ''
                }`}
              >
                {/* Content */}
                <div className={`flex-1 w-full sm:w-1/2 ${index % 2 === 0 ? 'sm:pl-12' : 'sm:pr-12 text-left sm:text-right'}`}>
                  <div className={`p-6 rounded-[32px] border transition-all ${
                    step.status === 'Current' 
                    ? 'border-accent bg-accent/5 ring-4 ring-accent/5' 
                    : 'border-border-subtle bg-surface-soft/50'
                  }`}>
                    <div className={`inline-flex items-center gap-2 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest mb-4 ${
                      step.status === 'Completed' ? 'bg-emerald-100 text-emerald-600' :
                      step.status === 'Current' ? 'bg-accent text-white' : 'bg-slate-200 text-slate-500'
                    }`}>
                      {step.status}
                    </div>
                    <h3 className="text-lg font-black text-primary mb-2">{step.title}</h3>
                    <p className="text-sm text-primary/60 leading-relaxed mb-4">{step.desc}</p>
                    <div className="flex items-center gap-2 text-xs font-bold text-primary/40">
                      <Clock size={14} /> Est. {step.date}
                    </div>
                  </div>
                </div>

                {/* Icon/Circle in Middle */}
                <div className="absolute left-0 sm:left-1/2 sm:-translate-x-1/2 flex items-center justify-center">
                  <div className={`w-14 h-14 rounded-2xl flex items-center justify-center z-10 shadow-lg transition-transform hover:scale-110 ${
                    step.status === 'Completed' ? 'bg-emerald-500 text-white' :
                    step.status === 'Current' ? 'bg-accent text-white scale-110' : 'bg-white text-primary/20 border-2 border-border-subtle'
                  }`}>
                    <step.icon size={24} />
                  </div>
                </div>

                {/* Empty space for alignment */}
                <div className="flex-1 hidden sm:block"></div>
              </motion.div>
            ))}
          </div>
        </div>
      </div>

      {/* Info Box */}
      <div className="bg-primary text-white p-8 rounded-[32px] flex flex-col md:flex-row items-center gap-6">
        <div className="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center shrink-0">
          <ShieldCheck size={32} className="text-accent" />
        </div>
        <div className="flex-grow text-center md:text-left">
          <h4 className="font-black text-lg mb-1">Jaminan Kualitas Bangunan</h4>
          <p className="text-white/60 text-sm">Setiap unit Arkanaproperty melalui proses QC ketat dan memiliki garansi konstruksi selama 12 bulan setelah serah terima.</p>
        </div>
        <button className="px-6 py-3 bg-white text-primary rounded-xl font-bold text-sm whitespace-nowrap hover:bg-accent hover:text-white transition-colors">
          Lihat Spesifikasi Teknis
        </button>
      </div>
    </div>
  );
}
