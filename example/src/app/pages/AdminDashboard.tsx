import { 
  Users, 
  Home, 
  TrendingUp, 
  Clock, 
  CheckCircle2, 
  MoreHorizontal, 
  Plus,
  ArrowUpRight,
  Filter,
  ArrowRight
} from "lucide-react";
import { motion } from "motion/react";

const LEADS = [
  { id: 1, name: "Ahmad Rizky", phone: "081234567890", property: "Tipe 36/60", status: "Hot Prospect", date: "7 Juni 2026" },
  { id: 2, name: "Siti Aminah", phone: "089876543210", property: "Premium Cluster", status: "New Lead", date: "7 Juni 2026" },
  { id: 3, name: "Budi Santoso", phone: "081122334455", property: "Tipe 36/60", status: "Cold Lead", date: "6 Juni 2026" },
  { id: 4, name: "Dewi Lestari", phone: "085566778899", property: "Premium Cluster", status: "Interested", date: "6 Juni 2026" },
];

const KAVLING_STATS = [
  { label: "Total Unit", value: 120, color: "bg-primary" },
  { label: "Terjual", value: 85, color: "bg-emerald-custom" },
  { label: "Booking", value: 12, color: "bg-accent" },
  { label: "Tersedia", value: 23, color: "bg-slate-200 text-primary" },
];

export function AdminDashboard() {
  return (
    <div className="space-y-8">
      {/* Header */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-black text-primary">Overview Dashboard</h1>
          <p className="text-primary/60">Selamat pagi, Administrator. Berikut ringkasan hari ini.</p>
        </div>
        <div className="flex gap-3">
          <button className="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
            <Filter size={16} /> Filter Data
          </button>
          <button className="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
            <Plus size={16} /> Tambah Unit
          </button>
        </div>
      </div>

      {/* Quick Stats */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        {KAVLING_STATS.map((stat, i) => (
          <motion.div 
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: i * 0.1 }}
            key={stat.label} 
            className="bg-white p-6 rounded-3xl border border-border-subtle shadow-sm flex items-center justify-between"
          >
            <div>
              <p className="text-xs font-bold text-primary/40 uppercase tracking-widest mb-1">{stat.label}</p>
              <h3 className="text-3xl font-black text-primary">{stat.value}</h3>
            </div>
            <div className={`w-12 h-12 rounded-2xl ${stat.color} flex items-center justify-center text-white font-bold`}>
              {stat.label === 'Total Unit' ? <Home size={24} /> : stat.value}
            </div>
          </motion.div>
        ))}
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {/* Recent Leads Table */}
        <div className="lg:col-span-2 bg-white rounded-3xl border border-border-subtle shadow-sm overflow-hidden flex flex-col">
          <div className="p-6 border-b border-border-subtle flex items-center justify-between">
            <h3 className="font-black text-primary flex items-center gap-2">
              <Users size={18} className="text-accent" /> Data Leads Terbaru
            </h3>
            <button className="text-accent text-xs font-bold hover:underline">Lihat Semua</button>
          </div>
          <div className="overflow-x-auto">
            <table className="w-full text-left">
              <thead>
                <tr className="bg-surface-soft border-b border-border-subtle">
                  <th className="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Customer</th>
                  <th className="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Property</th>
                  <th className="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Status</th>
                  <th className="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Aksi</th>
                </tr>
              </thead>
              <tbody className="divide-y divide-border-subtle">
                {LEADS.map((lead) => (
                  <tr key={lead.id} className="hover:bg-surface-soft/50 transition-colors">
                    <td className="px-6 py-4">
                      <div className="font-bold text-primary">{lead.name}</div>
                      <div className="text-[10px] text-primary/40">{lead.phone}</div>
                    </td>
                    <td className="px-6 py-4 text-xs font-medium text-primary/70">{lead.property}</td>
                    <td className="px-6 py-4">
                      <span className={`px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-tighter ${
                        lead.status === 'Hot Prospect' ? 'bg-orange-100 text-orange-600' :
                        lead.status === 'New Lead' ? 'bg-blue-100 text-blue-600' :
                        'bg-slate-100 text-slate-500'
                      }`}>
                        {lead.status}
                      </span>
                    </td>
                    <td className="px-6 py-4">
                      <div className="flex gap-2">
                        <button className="p-2 hover:bg-white rounded-lg border border-transparent hover:border-border-subtle transition-all">
                          <CheckCircle2 size={16} className="text-emerald-custom" />
                        </button>
                        <button className="p-2 hover:bg-white rounded-lg border border-transparent hover:border-border-subtle transition-all">
                          <MoreHorizontal size={16} className="text-primary/40" />
                        </button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>

        {/* Marketing Activity Feed */}
        <div className="bg-white rounded-3xl border border-border-subtle shadow-sm p-6">
          <h3 className="font-black text-primary mb-6 flex items-center gap-2">
            <TrendingUp size={18} className="text-accent" /> Laporan Marketing
          </h3>
          <div className="space-y-6">
            {[1, 2, 3].map((i) => (
              <div key={i} className="relative pl-6 pb-6 border-l-2 border-surface-soft last:pb-0">
                <div className="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-accent border-4 border-white"></div>
                <div className="flex items-center justify-between mb-1">
                  <p className="text-xs font-black text-primary">Dimas Marketing</p>
                  <span className="text-[10px] text-primary/40">10:30 AM</span>
                </div>
                <p className="text-xs text-primary/60 leading-relaxed">
                  Menyelesaikan survey lokasi dengan Bapak Ahmad di unit Premium Cluster Blok A-12.
                </p>
                <div className="mt-2 flex gap-2">
                  <span className="px-2 py-0.5 bg-emerald-50 text-emerald-600 text-[9px] font-bold rounded">Selesai Survey</span>
                </div>
              </div>
            ))}
          </div>
        </div>
      </div>
    </div>
  );
}
