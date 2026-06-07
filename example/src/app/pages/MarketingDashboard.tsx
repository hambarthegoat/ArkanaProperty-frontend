import { 
  Users, 
  Calendar as CalendarIcon, 
  ClipboardList, 
  MessageSquare,
  Plus,
  Send,
  MoreVertical,
  ChevronRight,
  Clock,
  ExternalLink,
  X,
  Phone,
  CheckCircle2,
  Calendar
} from "lucide-react";
import { useState } from "react";
import { motion, AnimatePresence } from "motion/react";

const ASSIGNED_LEADS = [
  { 
    id: 1, 
    name: "Ahmad Rizky", 
    phone: "081234567890", 
    property: "Tipe 36/60", 
    lastContact: "2 jam lalu", 
    priority: "High",
    status: "Survey Lokasi",
    email: "ahmad.rizky@email.com",
    notes: "Tertarik dengan unit hook, rencana survey minggu ini."
  },
  { 
    id: 2, 
    name: "Siti Aminah", 
    phone: "089876543210", 
    property: "Premium Cluster", 
    lastContact: "1 hari lalu", 
    priority: "Medium",
    status: "Follow Up",
    email: "siti.a@email.com",
    notes: "Menunggu persetujuan suami untuk booking fee."
  },
  { 
    id: 3, 
    name: "Budi Santoso", 
    phone: "081122334455", 
    property: "Tipe 36/60", 
    lastContact: "3 hari lalu", 
    priority: "Low",
    status: "Pikir-pikir",
    email: "budi.s@email.com",
    notes: "Masih membandingkan dengan perumahan sebelah."
  },
];

const SCHEDULE = [
  { time: "09:00", title: "Survey Lokasi: Bpk Ahmad", location: "Blok A-12", type: "Survey", date: "2026-06-07" },
  { time: "13:30", title: "Follow Up: Ibu Siti", location: "Telepon/WA", type: "Follow Up", date: "2026-06-07" },
  { time: "15:00", title: "Tanda Tangan PPJB", location: "Kantor Pusat", type: "Closing", date: "2026-06-07" },
];

export function MarketingDashboard() {
  const [report, setReport] = useState("");
  const [selectedLead, setSelectedLead] = useState<any>(null);

  return (
    <div className="space-y-8">
      {/* Lead Detail Modal */}
      <AnimatePresence>
        {selectedLead && (
          <div className="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <motion.div 
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => setSelectedLead(null)}
              className="absolute inset-0 bg-primary/40 backdrop-blur-md"
            ></motion.div>
            <motion.div 
              initial={{ opacity: 0, scale: 0.9, y: 20 }}
              animate={{ opacity: 1, scale: 1, y: 0 }}
              exit={{ opacity: 0, scale: 0.9, y: 20 }}
              className="relative w-full max-w-2xl bg-white rounded-[40px] overflow-hidden shadow-2xl"
            >
              <div className="p-10">
                <div className="flex justify-between items-start mb-8">
                  <div className="flex items-center gap-4">
                    <div className="w-16 h-16 bg-surface-soft rounded-3xl flex items-center justify-center text-primary font-black text-xl">
                      {selectedLead.name.split(' ').map((n: string) => n[0]).join('')}
                    </div>
                    <div>
                      <h2 className="text-2xl font-black text-primary">{selectedLead.name}</h2>
                      <span className={`px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest ${
                        selectedLead.priority === 'High' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600'
                      }`}>
                        {selectedLead.priority} Priority
                      </span>
                    </div>
                  </div>
                  <button 
                    onClick={() => setSelectedLead(null)}
                    className="p-3 bg-surface-soft hover:bg-border-subtle rounded-full text-primary transition-all"
                  >
                    <X size={20} />
                  </button>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                  <div className="space-y-6">
                    <div>
                      <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Status Saat Ini</p>
                      <div className="flex items-center gap-2">
                        <CheckCircle2 size={16} className="text-emerald-custom" />
                        <span className="font-bold text-primary">{selectedLead.status}</span>
                      </div>
                    </div>
                    <div>
                      <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Unit Diminati</p>
                      <p className="font-bold text-primary">{selectedLead.property}</p>
                    </div>
                  </div>
                  <div className="space-y-6">
                    <div>
                      <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Kontak Person</p>
                      <p className="font-bold text-primary">{selectedLead.phone}</p>
                      <p className="text-xs text-primary/40">{selectedLead.email}</p>
                    </div>
                    <div>
                      <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest mb-1">Catatan</p>
                      <p className="text-sm text-primary/60 italic">"{selectedLead.notes}"</p>
                    </div>
                  </div>
                </div>

                <div className="flex gap-4 pt-8 border-t border-border-subtle">
                  <button className="flex-grow btn-primary flex items-center justify-center gap-2">
                    <Phone size={18} /> Hubungi Telepon
                  </button>
                  <button className="flex-grow py-4 bg-emerald-500 text-white rounded-2xl font-black flex items-center justify-center gap-2 hover:bg-emerald-600 transition-all">
                    <MessageSquare size={18} /> Chat WhatsApp
                  </button>
                </div>
              </div>
            </motion.div>
          </div>
        )}
      </AnimatePresence>

      {/* Welcome Header */}
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-black text-primary">Leads Saya</h1>
          <p className="text-primary/60">Semangat pagi! Hari ini Anda memiliki {SCHEDULE.length} jadwal pertemuan.</p>
        </div>
        <button className="btn-primary !py-2 !px-4 text-xs flex items-center gap-2">
          <Plus size={16} /> Lead Baru
        </button>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {/* Assigned Leads Section */}
        <div className="lg:col-span-2 space-y-6">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            {ASSIGNED_LEADS.map((lead) => (
              <motion.div 
                key={lead.id}
                whileHover={{ scale: 1.02 }}
                className="bg-white p-6 rounded-3xl border border-border-subtle shadow-sm flex flex-col justify-between"
              >
                <div>
                  <div className="flex justify-between items-start mb-4">
                    <span className={`px-2 py-0.5 rounded text-[9px] font-black uppercase ${
                      lead.priority === 'High' ? 'bg-red-100 text-red-600' : 
                      lead.priority === 'Medium' ? 'bg-orange-100 text-orange-600' : 'bg-slate-100 text-slate-500'
                    }`}>
                      {lead.priority} Priority
                    </span>
                    <button className="text-primary/20 hover:text-primary"><MoreVertical size={16} /></button>
                  </div>
                  <h3 className="font-bold text-lg text-primary">{lead.name}</h3>
                  <p className="text-xs text-primary/40 mb-4">{lead.property}</p>
                </div>
                <div className="space-y-3 pt-4 border-t border-border-subtle">
                  <div className="flex items-center justify-between text-[10px] font-bold">
                    <span className="text-primary/40 uppercase tracking-widest">Terakhir Kontak</span>
                    <span className="text-primary/60">{lead.lastContact}</span>
                  </div>
                  <div className="flex gap-2">
                    <button 
                      onClick={() => setSelectedLead(lead)}
                      className="flex-grow py-2 bg-surface-soft text-primary rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-primary hover:text-white transition-all group"
                    >
                      <ExternalLink size={14} className="group-hover:scale-110 transition-transform" /> Detail
                    </button>
                    <button className="flex-grow py-2 bg-emerald-500 text-white rounded-xl text-xs font-bold flex items-center justify-center gap-2 hover:bg-emerald-600 transition-colors">
                      <MessageSquare size={14} /> WhatsApp
                    </button>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>

          {/* Daily Report Input */}
          <div className="bg-white rounded-3xl border border-border-subtle shadow-sm p-8">
            <h3 className="font-black text-primary mb-4 flex items-center gap-2">
              <ClipboardList size={20} className="text-accent" /> Input Report Harian
            </h3>
            <div className="space-y-4">
              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div className="space-y-1">
                  <label className="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Pilih Lead</label>
                  <select className="w-full bg-surface-soft border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-accent">
                    {ASSIGNED_LEADS.map(l => <option key={l.id}>{l.name}</option>)}
                    <option>Lead Baru / Walk-in</option>
                  </select>
                </div>
                <div className="space-y-1">
                  <label className="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Status Progress</label>
                  <select className="w-full bg-surface-soft border-none rounded-xl p-3 text-sm font-semibold outline-none focus:ring-2 focus:ring-accent">
                    <option>Survey Lokasi Selesai</option>
                    <option>Follow Up via Telepon</option>
                    <option>Minat / Booking Unit</option>
                    <option>Pembatalan / Tidak Minat</option>
                  </select>
                </div>
              </div>
              <div className="space-y-1">
                <label className="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Keterangan Detail</label>
                <textarea 
                  value={report}
                  onChange={(e) => setReport(e.target.value)}
                  placeholder="Ceritakan detail aktivitas Anda..."
                  className="w-full bg-surface-soft border-none rounded-xl p-4 text-sm font-semibold outline-none focus:ring-2 focus:ring-accent min-h-[100px]"
                ></textarea>
              </div>
              <div className="flex justify-end">
                <button className="btn-primary !px-8 flex items-center gap-2">
                  Kirim Laporan <Send size={18} />
                </button>
              </div>
            </div>
          </div>
        </div>

        {/* Sidebar: Calendar/Schedule */}
        <div className="space-y-6">
          <div className="bg-white rounded-3xl border border-border-subtle shadow-sm p-6">
            <h3 className="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
              <Calendar size={18} className="text-accent" /> Jadwal Hari Ini
            </h3>
            <div className="space-y-4">
              {SCHEDULE.map((item, i) => (
                <div key={i} className="flex gap-4 p-4 rounded-2xl hover:bg-surface-soft transition-colors group cursor-pointer border border-transparent hover:border-border-subtle">
                  <div className="shrink-0 flex flex-col items-center justify-center w-14 h-14 bg-surface-soft rounded-xl group-hover:bg-accent group-hover:text-white transition-colors">
                    <span className="text-[10px] font-black opacity-50 uppercase leading-none">Pkl</span>
                    <span className="text-sm font-black">{item.time}</span>
                  </div>
                  <div>
                    <h4 className="font-bold text-primary text-sm">{item.title}</h4>
                    <p className="text-[10px] text-primary/40 font-medium uppercase tracking-wider mb-1">{item.location}</p>
                    <span className={`px-2 py-0.5 rounded text-[8px] font-black uppercase ${
                      item.type === 'Closing' ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600'
                    }`}>
                      {item.type}
                    </span>
                  </div>
                </div>
              ))}
              <div className="pt-4 mt-4 border-t border-border-subtle">
                <button 
                  onClick={() => window.location.href = '/marketing/calendar'}
                  className="w-full py-3 text-xs font-black text-accent hover:bg-accent hover:text-white border border-accent rounded-xl transition-all uppercase tracking-widest"
                >
                  Buka Kalender Lengkap
                </button>
              </div>
            </div>
          </div>

          <div className="bg-primary text-white rounded-3xl p-8 relative overflow-hidden shadow-xl">
            <div className="relative z-10">
              <Clock className="text-accent mb-4" size={32} />
              <h4 className="font-black text-xl mb-2 italic">Ingat!</h4>
              <p className="text-white/60 text-sm leading-relaxed">
                Laporan harian maksimal dikirimkan pukul 20:00 WIB setiap harinya untuk sinkronisasi data Admin.
              </p>
            </div>
            <div className="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
          </div>
        </div>
      </div>
    </div>
  );
}

