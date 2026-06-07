import { useState } from "react";
import { 
  Search, 
  Filter, 
  Download, 
  MoreHorizontal, 
  Phone, 
  MessageCircle, 
  Mail,
  UserPlus,
  ArrowUpDown,
  CheckCircle2,
  XCircle,
  Clock
} from "lucide-react";
import { motion } from "motion/react";

const INITIAL_LEADS = [
  { id: 1, name: "Ahmad Rizky", phone: "081234567890", email: "ahmad@example.com", property: "Tipe 36/60", status: "Hot Prospect", source: "Website", date: "7 Juni 2026" },
  { id: 2, name: "Siti Aminah", phone: "089876543210", email: "siti@example.com", property: "Premium Cluster", status: "New Lead", source: "WhatsApp", date: "7 Juni 2026" },
  { id: 3, name: "Budi Santoso", phone: "081122334455", email: "budi@example.com", property: "Tipe 36/60", status: "Cold Lead", source: "Facebook Ads", date: "6 Juni 2026" },
  { id: 4, name: "Dewi Lestari", phone: "085566778899", email: "dewi@example.com", property: "Premium Cluster", status: "Interested", source: "Instagram", date: "6 Juni 2026" },
  { id: 5, name: "Fajri Hidayat", phone: "081299887766", email: "fajri@example.com", property: "Tipe 36/60", status: "Lost", source: "Walk-in", date: "5 Juni 2026" },
  { id: 6, name: "Lina Marlina", phone: "087755443322", email: "lina@example.com", property: "Premium Cluster", status: "Hot Prospect", source: "Website", date: "5 Juni 2026" },
];

export function LeadsManagement() {
  const [searchTerm, setSearchTerm] = useState("");
  const [statusFilter, setStatusFilter] = useState("All");

  const filteredLeads = INITIAL_LEADS.filter(lead => {
    const matchesSearch = lead.name.toLowerCase().includes(searchTerm.toLowerCase()) || 
                         lead.phone.includes(searchTerm);
    const matchesStatus = statusFilter === "All" || lead.status === statusFilter;
    return matchesSearch && matchesStatus;
  });

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'Hot Prospect': return 'bg-orange-100 text-orange-600';
      case 'New Lead': return 'bg-blue-100 text-blue-600';
      case 'Interested': return 'bg-emerald-100 text-emerald-600';
      case 'Cold Lead': return 'bg-slate-100 text-slate-500';
      case 'Lost': return 'bg-red-100 text-red-600';
      default: return 'bg-slate-100 text-slate-500';
    }
  };

  return (
    <div className="space-y-6">
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-black text-primary">Manajemen Leads</h1>
          <p className="text-primary/60">Kelola dan pantau seluruh prospek konsumen Arkanaproperty.</p>
        </div>
        <div className="flex gap-2">
          <button className="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
            <Download size={16} /> Export CSV
          </button>
          <button className="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
            <UserPlus size={16} /> Tambah Lead
          </button>
        </div>
      </div>

      {/* Stats Overview */}
      <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {[
          { label: "Total Prospek", value: "1,284", icon: UserPlus, color: "text-blue-600" },
          { label: "Hot Prospect", value: "42", icon: CheckCircle2, color: "text-orange-600" },
          { label: "Follow Up", value: "156", icon: Clock, color: "text-accent" },
          { label: "Closing Bulan Ini", value: "12", icon: CheckCircle2, color: "text-emerald-custom" },
        ].map((stat, i) => (
          <div key={i} className="bg-white p-5 rounded-2xl border border-border-subtle shadow-sm flex items-center gap-4">
            <div className={`p-3 rounded-xl bg-surface-soft ${stat.color}`}>
              <stat.icon size={20} />
            </div>
            <div>
              <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">{stat.label}</p>
              <p className="text-xl font-black text-primary">{stat.value}</p>
            </div>
          </div>
        ))}
      </div>

      {/* Filters & Table */}
      <div className="bg-white rounded-[32px] border border-border-subtle shadow-sm overflow-hidden">
        <div className="p-6 border-b border-border-subtle flex flex-col md:flex-row gap-4 justify-between items-center">
          <div className="relative w-full md:w-96">
            <Search className="absolute left-4 top-1/2 -translate-y-1/2 text-primary/30" size={18} />
            <input 
              type="text" 
              placeholder="Cari nama atau nomor telepon..."
              className="w-full bg-surface-soft border-none rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium"
              value={searchTerm}
              onChange={(e) => setSearchTerm(e.target.value)}
            />
          </div>
          <div className="flex gap-2 w-full md:w-auto overflow-x-auto pb-2 md:pb-0">
            {["All", "New Lead", "Hot Prospect", "Interested", "Cold Lead", "Lost"].map((status) => (
              <button 
                key={status}
                onClick={() => setStatusFilter(status)}
                className={`px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all ${
                  statusFilter === status 
                  ? "bg-primary text-white shadow-lg shadow-primary/20" 
                  : "bg-surface-soft text-primary/60 hover:bg-border-subtle"
                }`}
              >
                {status}
              </button>
            ))}
          </div>
        </div>

        <div className="overflow-x-auto">
          <table className="w-full text-left">
            <thead>
              <tr className="bg-surface-soft border-b border-border-subtle">
                <th className="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">
                  <div className="flex items-center gap-2">Konsumen <ArrowUpDown size={12} /></div>
                </th>
                <th className="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Minat Unit</th>
                <th className="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Sumber</th>
                <th className="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest">Status</th>
                <th className="px-6 py-4 text-[10px] font-bold text-primary/40 uppercase tracking-widest text-right">Aksi</th>
              </tr>
            </thead>
            <tbody className="divide-y divide-border-subtle">
              {filteredLeads.map((lead) => (
                <tr key={lead.id} className="hover:bg-surface-soft/30 transition-colors group">
                  <td className="px-6 py-4">
                    <div className="flex items-center gap-3">
                      <div className="w-10 h-10 rounded-full bg-surface-soft border border-border-subtle flex items-center justify-center font-black text-primary text-xs shrink-0">
                        {lead.name.split(' ').map(n => n[0]).join('')}
                      </div>
                      <div>
                        <div className="font-bold text-primary group-hover:text-accent transition-colors">{lead.name}</div>
                        <div className="text-[10px] text-primary/40">{lead.phone} • {lead.email}</div>
                      </div>
                    </div>
                  </td>
                  <td className="px-6 py-4">
                    <div className="text-xs font-bold text-primary/70">{lead.property}</div>
                    <div className="text-[9px] text-primary/40 uppercase tracking-tighter">Terdaftar: {lead.date}</div>
                  </td>
                  <td className="px-6 py-4">
                    <span className="text-xs font-medium text-primary/60">{lead.source}</span>
                  </td>
                  <td className="px-6 py-4">
                    <span className={`px-2 py-1 rounded-md text-[9px] font-black uppercase tracking-tighter ${getStatusColor(lead.status)}`}>
                      {lead.status}
                    </span>
                  </td>
                  <td className="px-6 py-4">
                    <div className="flex justify-end gap-1">
                      <button className="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors" title="WhatsApp">
                        <MessageCircle size={18} />
                      </button>
                      <button className="p-2 text-primary/40 hover:bg-surface-soft rounded-lg transition-colors">
                        <MoreHorizontal size={18} />
                      </button>
                    </div>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        <div className="p-6 border-t border-border-subtle bg-surface-soft/30 flex items-center justify-between">
          <p className="text-xs text-primary/40 font-medium">Menampilkan {filteredLeads.length} dari {INITIAL_LEADS.length} leads</p>
          <div className="flex gap-2">
            <button className="px-3 py-1 bg-white border border-border-subtle rounded-lg text-xs font-bold opacity-50 cursor-not-allowed">Prev</button>
            <button className="px-3 py-1 bg-white border border-border-subtle rounded-lg text-xs font-bold hover:border-accent">Next</button>
          </div>
        </div>
      </div>
    </div>
  );
}
