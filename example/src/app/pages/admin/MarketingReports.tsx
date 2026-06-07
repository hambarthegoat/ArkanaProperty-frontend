import { 
  FileText, 
  Calendar, 
  User, 
  TrendingUp, 
  ArrowRight,
  MoreVertical,
  Download,
  CheckCircle2,
  Clock
} from "lucide-react";
import { motion } from "motion/react";

const REPORTS = [
  { 
    id: 1, 
    agent: "Dimas Marketing", 
    date: "7 Juni 2026", 
    time: "10:30", 
    client: "Ahmad Rizky", 
    activity: "Survey Lokasi", 
    status: "Completed",
    note: "Klien sangat tertarik dengan Blok A-12, menanyakan skema cicilan 15 tahun."
  },
  { 
    id: 2, 
    agent: "Santi Agent", 
    date: "7 Juni 2026", 
    time: "09:15", 
    client: "Ibu Siti", 
    activity: "Follow Up WA", 
    status: "In Progress",
    note: "Menunggu konfirmasi jadwal kunjungan hari Sabtu depan."
  },
  { 
    id: 3, 
    agent: "Dimas Marketing", 
    date: "6 Juni 2026", 
    time: "16:00", 
    client: "Bpk Budi", 
    activity: "Closing Unit", 
    status: "Completed",
    note: "Tanda tangan PPJB selesai. Berkas sudah diserahkan ke Admin."
  },
  { 
    id: 4, 
    agent: "Rian Sales", 
    date: "6 Juni 2026", 
    time: "14:20", 
    client: "Dewi Lestari", 
    activity: "Survey Lokasi", 
    status: "Completed",
    note: "Klien ingin membandingkan Tipe 36 dengan Tipe 45."
  },
];

export function MarketingReports() {
  return (
    <div className="space-y-8">
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-black text-primary">Laporan Aktivitas Marketing</h1>
          <p className="text-primary/60">Pantau performa dan catatan harian dari seluruh tim lapangan.</p>
        </div>
        <div className="flex gap-2">
          <button className="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
            <Calendar size={16} /> Filter Tanggal
          </button>
          <button className="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
            <Download size={16} /> Download Report
          </button>
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {[
          { label: "Total Aktivitas", value: "342", icon: TrendingUp, color: "text-blue-600" },
          { label: "Survey Lokasi", value: "128", icon: Calendar, color: "text-accent" },
          { label: "Closing / Booking", value: "15", icon: CheckCircle2, color: "text-emerald-custom" },
        ].map((stat, i) => (
          <div key={i} className="bg-white p-6 rounded-3xl border border-border-subtle shadow-sm flex items-center justify-between">
            <div>
              <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">{stat.label}</p>
              <h3 className="text-3xl font-black text-primary">{stat.value}</h3>
            </div>
            <div className={`p-4 rounded-2xl bg-surface-soft ${stat.color}`}>
              <stat.icon size={24} />
            </div>
          </div>
        ))}
      </div>

      <div className="bg-white rounded-[40px] border border-border-subtle shadow-sm overflow-hidden">
        <div className="p-8 border-b border-border-subtle">
          <h3 className="font-black text-primary flex items-center gap-3">
            <FileText size={20} className="text-accent" /> Feed Laporan Terbaru
          </h3>
        </div>
        
        <div className="divide-y divide-border-subtle">
          {REPORTS.map((report) => (
            <motion.div 
              key={report.id}
              whileHover={{ backgroundColor: "rgba(248, 250, 252, 0.5)" }}
              className="p-8 flex flex-col lg:flex-row gap-8 lg:items-center"
            >
              <div className="lg:w-1/4">
                <div className="flex items-center gap-3 mb-2">
                  <div className="w-8 h-8 rounded-full bg-surface-soft flex items-center justify-center font-bold text-[10px] text-primary">
                    {report.agent.split(' ').map(n => n[0]).join('')}
                  </div>
                  <span className="font-bold text-primary text-sm">{report.agent}</span>
                </div>
                <div className="flex items-center gap-2 text-[10px] font-bold text-primary/30 uppercase tracking-widest">
                  <Clock size={12} /> {report.date} • {report.time}
                </div>
              </div>

              <div className="lg:w-1/4">
                <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Konsumen</p>
                <p className="font-black text-primary">{report.client}</p>
                <div className="inline-flex items-center gap-2 px-2 py-0.5 bg-surface-soft rounded text-[10px] font-bold text-accent mt-1">
                  {report.activity}
                </div>
              </div>

              <div className="lg:w-1/3">
                <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Catatan</p>
                <p className="text-sm text-primary/60 leading-relaxed italic">"{report.note}"</p>
              </div>

              <div className="lg:w-1/6 flex items-center justify-between lg:justify-end gap-4">
                <span className={`px-2 py-1 rounded text-[9px] font-black uppercase tracking-tighter ${
                  report.status === 'Completed' ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600'
                }`}>
                  {report.status}
                </span>
                <button className="p-2 hover:bg-white rounded-lg transition-all text-primary/20 hover:text-primary">
                  <MoreVertical size={18} />
                </button>
              </div>
            </motion.div>
          ))}
        </div>

        <div className="p-8 border-t border-border-subtle text-center">
          <button className="text-accent text-xs font-black uppercase tracking-widest hover:gap-3 transition-all flex items-center gap-2 mx-auto">
            Lihat Laporan Lebih Lama <ArrowRight size={14} />
          </button>
        </div>
      </div>
    </div>
  );
}
