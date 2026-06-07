import { useState } from "react";
import { 
  Home, 
  Search, 
  Plus, 
  Filter, 
  MapPin, 
  Tag, 
  CheckCircle2, 
  XCircle, 
  Clock,
  ChevronRight,
  MoreVertical,
  Maximize2,
  Building2
} from "lucide-react";
import { motion } from "motion/react";

const PROJECTS = [
  "Arkana Residence Mayangan",
  "Arkana Premium Kanigaran",
  "Scandinavian Hill Phase 2"
];

const BLOCKS = {
  "Arkana Residence Mayangan": ["Blok A", "Blok B", "Blok C", "Blok D"],
  "Arkana Premium Kanigaran": ["Blok Premium 1", "Blok Premium 2"],
  "Scandinavian Hill Phase 2": ["Blok Scandi A", "Blok Scandi B"]
};

const HOUSE_TYPES = {
  "Arkana Residence Mayangan": ["Tipe 36/60", "Tipe 45/84"],
  "Arkana Premium Kanigaran": ["Tipe 60/100", "Tipe 72/120"],
  "Scandinavian Hill Phase 2": ["Tipe Nordic 50", "Tipe Nordic 70"]
};

const KAVLING_DATA = [
  { id: "A-01", project: "Arkana Residence Mayangan", block: "Blok A", type: "Tipe 36/60", price: "162jt", status: "Sold", customer: "Ahmad Rizky" },
  { id: "A-02", project: "Arkana Residence Mayangan", block: "Blok A", type: "Tipe 36/60", price: "162jt", status: "Available", customer: null },
  { id: "A-03", project: "Arkana Residence Mayangan", block: "Blok A", type: "Tipe 36/60", price: "162jt", status: "Booking", customer: "Siti Aminah" },
  { id: "A-04", project: "Arkana Residence Mayangan", block: "Blok A", type: "Tipe 36/60", price: "162jt", status: "Available", customer: null },
  { id: "A-05", project: "Arkana Residence Mayangan", block: "Blok A", type: "Tipe 45/84", price: "245jt", status: "Sold", customer: "Budi S." },
  { id: "A-06", project: "Arkana Residence Mayangan", block: "Blok A", type: "Tipe 45/84", price: "245jt", status: "Available", customer: null },
  { id: "B-01", project: "Arkana Residence Mayangan", block: "Blok B", type: "Tipe 36/60", price: "162jt", status: "Available", customer: null },
  { id: "B-02", project: "Arkana Residence Mayangan", block: "Blok B", type: "Tipe 36/60", price: "162jt", status: "Booking", customer: "Rani M." },
  { id: "P1-01", project: "Arkana Premium Kanigaran", block: "Blok Premium 1", type: "Tipe 60/100", price: "450jt", status: "Available", customer: null },
  { id: "P1-02", project: "Arkana Premium Kanigaran", block: "Blok Premium 1", type: "Tipe 72/120", price: "550jt", status: "Sold", customer: "Irwan H." },
  { id: "S1-01", project: "Scandinavian Hill Phase 2", block: "Blok Scandi A", type: "Tipe Nordic 50", price: "385jt", status: "Booking", customer: "Rian F." },
  { id: "S2-01", project: "Scandinavian Hill Phase 2", block: "Blok Scandi B", type: "Tipe Nordic 70", price: "495jt", status: "Available", customer: null },
];

export function KavlingManagement() {
  const [selectedProject, setSelectedProject] = useState(PROJECTS[0]);
  const [selectedBlock, setSelectedBlock] = useState(BLOCKS[PROJECTS[0]][0]);
  const [selectedType, setSelectedType] = useState("All");
  const [statusFilter, setStatusFilter] = useState("All");
  const [searchTerm, setSearchTerm] = useState("");
  const [selectedKavling, setSelectedKavling] = useState<any>(null);

  const filteredKavling = KAVLING_DATA.filter(k => {
    const matchesProject = k.project === selectedProject;
    const matchesBlock = k.block === selectedBlock;
    const matchesType = selectedType === "All" || k.type === selectedType;
    const matchesStatus = statusFilter === "All" || k.status === statusFilter;
    const matchesSearch = k.id.toLowerCase().includes(searchTerm.toLowerCase()) || 
                         (k.customer && k.customer.toLowerCase().includes(searchTerm.toLowerCase()));
    return matchesProject && matchesBlock && matchesType && matchesStatus && matchesSearch;
  });

  const handleProjectChange = (project: string) => {
    setSelectedProject(project);
    const firstBlock = BLOCKS[project as keyof typeof BLOCKS][0];
    setSelectedBlock(firstBlock);
    setSelectedType("All");
  };

  const getStatusStyle = (status: string) => {
    switch (status) {
      case 'Sold': return 'bg-emerald-custom text-white shadow-lg shadow-emerald-custom/20';
      case 'Booking': return 'bg-accent text-white shadow-lg shadow-emerald-custom/20'; // Keep consistent with theme
      case 'Available': return 'bg-white border-2 border-dashed border-border-subtle text-primary/40 hover:border-accent hover:text-accent';
      default: return 'bg-slate-100 text-slate-500';
    }
  };

  return (
    <div className="space-y-8 relative">
      {/* Unit Detail Overlay */}
      {selectedKavling && (
        <motion.div 
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          className="fixed inset-0 bg-primary/20 backdrop-blur-sm z-50 flex items-center justify-center p-4"
          onClick={() => setSelectedKavling(null)}
        >
          <motion.div 
            initial={{ scale: 0.9, opacity: 0 }}
            animate={{ scale: 1, opacity: 1 }}
            className="bg-white rounded-[40px] w-full max-w-lg overflow-hidden shadow-2xl"
            onClick={e => e.stopPropagation()}
          >
            <div className={`p-8 ${selectedKavling.status === 'Sold' ? 'bg-emerald-custom' : selectedKavling.status === 'Booking' ? 'bg-accent' : 'bg-primary'} text-white`}>
              <div className="flex justify-between items-start mb-6">
                <div>
                  <p className="text-[10px] font-black uppercase tracking-[0.2em] opacity-60">Detail Kavling</p>
                  <h2 className="text-4xl font-black">{selectedKavling.id}</h2>
                </div>
                <button 
                  onClick={() => setSelectedKavling(null)}
                  className="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors"
                >
                  <XCircle size={24} />
                </button>
              </div>
              <div className="flex gap-4">
                <div className="px-4 py-2 bg-white/10 rounded-xl text-xs font-bold">{selectedKavling.type}</div>
                <div className="px-4 py-2 bg-white/10 rounded-xl text-xs font-bold">{selectedKavling.price}</div>
              </div>
            </div>
            
            <div className="p-8 space-y-6">
              <div className="grid grid-cols-2 gap-4">
                <div className="space-y-1">
                  <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Status Unit</p>
                  <div className="flex items-center gap-2">
                    <div className={`w-3 h-3 rounded-full ${selectedKavling.status === 'Sold' ? 'bg-emerald-500' : selectedKavling.status === 'Booking' ? 'bg-accent' : 'bg-slate-300'}`}></div>
                    <span className="font-bold text-primary">{selectedKavling.status}</span>
                  </div>
                </div>
                <div className="space-y-1">
                  <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Nama Konsumen</p>
                  <span className="font-bold text-primary">{selectedKavling.customer || "Belum Ada"}</span>
                </div>
              </div>

              <div className="pt-6 border-t border-border-subtle space-y-4">
                <h4 className="text-xs font-black text-primary uppercase tracking-widest">Opsi Manajemen</h4>
                <div className="grid grid-cols-1 gap-2">
                  <button className="flex items-center justify-between p-4 bg-surface-soft rounded-2xl font-bold text-sm text-primary hover:bg-border-subtle transition-all">
                    Update Status Unit <ChevronRight size={16} />
                  </button>
                  <button className="flex items-center justify-between p-4 bg-surface-soft rounded-2xl font-bold text-sm text-primary hover:bg-border-subtle transition-all">
                    Lihat Berkas Konsumen <ChevronRight size={16} />
                  </button>
                  <button className="flex items-center justify-between p-4 bg-surface-soft rounded-2xl font-bold text-sm text-primary hover:bg-border-subtle transition-all">
                    Edit Spesifikasi Kavling <ChevronRight size={16} />
                  </button>
                </div>
              </div>
            </div>
          </motion.div>
        </motion.div>
      )}

      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-black text-primary">Manajemen Kavling</h1>
          <p className="text-primary/60">Monitor ketersediaan unit dan status penjualan secara real-time.</p>
        </div>
        <div className="flex gap-2">
          <button className="flex items-center gap-2 px-4 py-2 bg-white border border-border-subtle rounded-xl font-bold text-xs hover:border-accent transition-colors">
            <Maximize2 size={16} /> Site Plan View
          </button>
          <button className="flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-105 transition-all">
            <Plus size={16} /> Tambah Kavling
          </button>
        </div>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {/* Sidebar Filters */}
        <div className="space-y-6">
          <div className="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
            <h3 className="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
              <Building2 size={16} className="text-accent" /> Pilih Perumahan
            </h3>
            <select 
              value={selectedProject}
              onChange={(e) => handleProjectChange(e.target.value)}
              className="w-full p-4 bg-surface-soft rounded-2xl font-bold text-primary outline-none focus:ring-1 focus:ring-accent appearance-none"
            >
              {PROJECTS.map(p => (
                <option key={p} value={p}>{p}</option>
              ))}
            </select>
          </div>

          <div className="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
            <h3 className="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
              <MapPin size={16} className="text-accent" /> Pilih Blok
            </h3>
            <div className="space-y-2 max-h-[200px] overflow-y-auto pr-2 custom-scrollbar">
              {BLOCKS[selectedProject as keyof typeof BLOCKS].map(block => (
                <button 
                  key={block}
                  onClick={() => setSelectedBlock(block)}
                  className={`w-full flex items-center justify-between p-4 rounded-2xl font-bold transition-all ${
                    selectedBlock === block 
                    ? "bg-primary text-white shadow-xl shadow-primary/20" 
                    : "bg-surface-soft text-primary/60 hover:bg-border-subtle"
                  }`}
                >
                  <span className="text-xs">{block}</span>
                  <ChevronRight size={14} className={selectedBlock === block ? "opacity-100" : "opacity-0"} />
                </button>
              ))}
            </div>
          </div>

          <div className="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
            <h3 className="font-black text-primary mb-4 flex items-center gap-2 text-sm uppercase tracking-widest">
              <Home size={16} className="text-accent" /> Tipe Rumah
            </h3>
            <div className="space-y-2">
              <button 
                onClick={() => setSelectedType("All")}
                className={`w-full p-3 rounded-xl text-xs font-bold transition-all ${
                  selectedType === "All" ? "bg-accent text-white" : "bg-surface-soft text-primary/60"
                }`}
              >
                Semua Tipe
              </button>
              {HOUSE_TYPES[selectedProject as keyof typeof HOUSE_TYPES].map(type => (
                <button 
                  key={type}
                  onClick={() => setSelectedType(type)}
                  className={`w-full p-3 rounded-xl text-xs font-bold transition-all ${
                    selectedType === type ? "bg-accent text-white" : "bg-surface-soft text-primary/60"
                  }`}
                >
                  {type}
                </button>
              ))}
            </div>
          </div>

          <div className="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
            <h3 className="font-black text-primary mb-4 flex items-center gap-2 text-sm uppercase tracking-widest">
              <Tag size={16} className="text-accent" /> Status Unit
            </h3>
            <div className="space-y-3">
              {[
                { label: "All", count: 120, color: "bg-slate-200" },
                { label: "Available", count: 23, color: "bg-white border border-border-subtle" },
                { label: "Booking", count: 12, color: "bg-accent" },
                { label: "Sold", count: 85, color: "bg-emerald-custom" },
              ].map(status => (
                <button 
                  key={status.label}
                  onClick={() => setStatusFilter(status.label)}
                  className={`w-full flex items-center justify-between p-2 rounded-xl text-xs font-bold transition-all ${
                    statusFilter === status.label ? "bg-surface-soft ring-1 ring-accent/30" : "hover:bg-surface-soft"
                  }`}
                >
                  <div className="flex items-center gap-3">
                    <div className={`w-3 h-3 rounded-full ${status.color}`}></div>
                    {status.label}
                  </div>
                  <span className="text-primary/40">{status.count}</span>
                </button>
              ))}
            </div>
          </div>
        </div>

        {/* Kavling Grid */}
        <div className="lg:col-span-3 space-y-6">
          <div className="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
            <div className="flex items-center justify-between mb-8">
              <h2 className="text-xl font-black text-primary">{selectedBlock} <span className="text-accent">—</span> Detail Unit</h2>
              <div className="relative">
                <Search size={16} className="absolute left-3 top-1/2 -translate-y-1/2 text-primary/30" />
                <input 
                  type="text" 
                  placeholder="Cari nomor unit..." 
                  className="bg-surface-soft border-none rounded-xl py-2 pl-10 pr-4 text-xs font-bold outline-none focus:ring-1 focus:ring-accent"
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                />
              </div>
            </div>

            <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
              {filteredKavling.map(k => (
                <motion.div
                  key={k.id}
                  whileHover={{ y: -5 }}
                  onClick={() => setSelectedKavling(k)}
                  className={`aspect-square rounded-3xl p-4 flex flex-col justify-between cursor-pointer transition-all ${getStatusStyle(k.status)}`}
                >
                  <div className="flex justify-between items-start">
                    <span className="text-lg font-black">{k.id}</span>
                    <button className="p-1 hover:bg-black/5 rounded-md transition-colors"><MoreVertical size={14} /></button>
                  </div>
                  <div>
                    <p className={`text-[9px] font-black uppercase tracking-widest mb-1 ${k.status === 'Available' ? 'text-primary/20' : 'text-white/60'}`}>{k.type}</p>
                    <p className="text-[10px] font-bold truncate">{k.customer || "TERSEDIA"}</p>
                  </div>
                </motion.div>
              ))}
            </div>

            {/* Legend */}
            <div className="mt-12 flex flex-wrap gap-6 pt-8 border-t border-border-subtle">
              <div className="flex items-center gap-2">
                <div className="w-4 h-4 rounded-md bg-white border-2 border-dashed border-border-subtle"></div>
                <span className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Available</span>
              </div>
              <div className="flex items-center gap-2">
                <div className="w-4 h-4 rounded-md bg-accent"></div>
                <span className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Booking</span>
              </div>
              <div className="flex items-center gap-2">
                <div className="w-4 h-4 rounded-md bg-emerald-custom"></div>
                <span className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Sold</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
