import { 
  Building2, 
  MapPin, 
  Home, 
  Plus, 
  Search, 
  MoreVertical, 
  ArrowRight,
  TrendingUp,
  LayoutGrid,
  List
} from "lucide-react";
import { motion } from "motion/react";
import { useState } from "react";

const PROJECTS = [
  {
    id: 1,
    name: "Arkana Residence Mayangan",
    location: "Kec. Mayangan, Probolinggo",
    units: 120,
    sold: 85,
    available: 35,
    status: "Active",
    type: "Subsidi & Komersil",
    image: "https://images.unsplash.com/photo-1592595894519-575e510d936a?q=80&w=2070"
  },
  {
    id: 2,
    name: "Arkana Premium Kanigaran",
    location: "Kec. Kanigaran, Probolinggo",
    units: 45,
    sold: 12,
    available: 33,
    status: "Active",
    type: "Premium Cluster",
    image: "https://images.unsplash.com/photo-1628744876497-eb30460be9f6?q=80&w=2070"
  },
  {
    id: 3,
    name: "Scandinavian Hill Phase 2",
    location: "Kec. Wonoasih, Probolinggo",
    units: 60,
    sold: 5,
    available: 55,
    status: "Pre-Launch",
    type: "Premium Cluster",
    image: "https://images.unsplash.com/photo-1660361338485-c926a27d4eb8?q=80&w=2070"
  }
];

export function HousingManagement() {
  const [viewMode, setViewMode] = useState<"grid" | "list">("grid");

  return (
    <div className="space-y-8">
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-black text-primary">Kelola Perumahan</h1>
          <p className="text-primary/60">Daftar proyek perumahan aktif dan pengembangan mendatang.</p>
        </div>
        <div className="flex gap-2">
          <div className="bg-white border border-border-subtle rounded-xl p-1 flex">
            <button 
              onClick={() => setViewMode("grid")}
              className={`p-2 rounded-lg transition-all ${viewMode === "grid" ? "bg-surface-soft text-primary shadow-sm" : "text-primary/40 hover:text-primary"}`}
            >
              <LayoutGrid size={18} />
            </button>
            <button 
              onClick={() => setViewMode("list")}
              className={`p-2 rounded-lg transition-all ${viewMode === "list" ? "bg-surface-soft text-primary shadow-sm" : "text-primary/40 hover:text-primary"}`}
            >
              <List size={18} />
            </button>
          </div>
          <button className="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
            <Plus size={16} /> Proyek Baru
          </button>
        </div>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {PROJECTS.map((project) => (
          <motion.div 
            key={project.id}
            whileHover={{ y: -5 }}
            className="bg-white rounded-[32px] overflow-hidden border border-border-subtle shadow-sm flex flex-col h-full"
          >
            <div className="relative h-48 overflow-hidden">
              <img src={project.image} className="w-full h-full object-cover" alt={project.name} />
              <div className="absolute top-4 left-4">
                <span className={`px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest text-white ${
                  project.status === 'Active' ? 'bg-emerald-custom' : 'bg-accent'
                }`}>
                  {project.status}
                </span>
              </div>
            </div>

            <div className="p-6 flex flex-col flex-grow">
              <div className="flex items-center gap-2 text-primary/40 font-bold text-[9px] uppercase tracking-widest mb-2">
                <MapPin size={12} className="text-accent" /> {project.location}
              </div>
              <h3 className="text-lg font-black text-primary mb-2 leading-tight">{project.name}</h3>
              <p className="text-xs text-primary/40 font-bold uppercase tracking-tighter mb-6">{project.type}</p>

              <div className="grid grid-cols-3 gap-4 mb-6">
                <div className="text-center p-3 bg-surface-soft rounded-2xl">
                  <p className="text-[8px] font-black text-primary/40 uppercase tracking-widest mb-1">Total</p>
                  <p className="text-sm font-black text-primary">{project.units}</p>
                </div>
                <div className="text-center p-3 bg-emerald-50 rounded-2xl">
                  <p className="text-[8px] font-black text-emerald-600/60 uppercase tracking-widest mb-1">Terjual</p>
                  <p className="text-sm font-black text-emerald-600">{project.sold}</p>
                </div>
                <div className="text-center p-3 bg-orange-50 rounded-2xl">
                  <p className="text-[8px] font-black text-orange-600/60 uppercase tracking-widest mb-1">Sisa</p>
                  <p className="text-sm font-black text-orange-600">{project.available}</p>
                </div>
              </div>

              <div className="mt-auto pt-6 border-t border-border-subtle flex items-center justify-between">
                <div className="flex items-center gap-2">
                  <div className="w-8 h-8 rounded-full bg-surface-soft flex items-center justify-center">
                    <TrendingUp size={14} className="text-accent" />
                  </div>
                  <span className="text-[10px] font-bold text-primary/60">72% Sold Out</span>
                </div>
                <button className="p-2 hover:bg-surface-soft rounded-xl transition-colors">
                  <ArrowRight size={18} className="text-primary/40" />
                </button>
              </div>
            </div>
          </motion.div>
        ))}
      </div>
    </div>
  );
}
