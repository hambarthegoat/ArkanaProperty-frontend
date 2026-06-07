import { 
  Calendar as CalendarIcon, 
  ChevronLeft, 
  ChevronRight, 
  Clock, 
  MapPin, 
  Plus,
  Filter,
  Users
} from "lucide-react";
import { useState } from "react";
import { motion } from "motion/react";

const EVENTS = [
  { id: 1, title: "Survey Lokasi: Bpk Ahmad", time: "09:00", date: "2026-06-07", location: "Blok A-12", type: "Survey" },
  { id: 2, title: "Follow Up: Ibu Siti", time: "13:30", date: "2026-06-07", location: "Telepon/WA", type: "Follow Up" },
  { id: 3, title: "Tanda Tangan PPJB", time: "15:00", date: "2026-06-07", location: "Kantor Pusat", type: "Closing" },
  { id: 4, title: "Survey Lokasi: Bpk Budi", time: "10:00", date: "2026-06-08", location: "Blok B-05", type: "Survey" },
  { id: 5, title: "Meeting Progress Project", time: "14:00", date: "2026-06-09", location: "Meeting Room", type: "Internal" },
];

export function CalendarManagement() {
  const [currentDate, setCurrentDate] = useState(new Date(2026, 5, 7)); // June 7, 2026

  const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();
  const firstDayOfMonth = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
  
  const monthName = currentDate.toLocaleString('id-ID', { month: 'long' });
  const year = currentDate.getFullYear();

  return (
    <div className="space-y-8">
      <div className="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
          <h1 className="text-2xl font-black text-primary">Jadwal & Kalender</h1>
          <p className="text-primary/60">Kelola janji temu survey dan aktivitas harian Anda.</p>
        </div>
        <button className="btn-primary !py-2 !px-4 text-xs flex items-center gap-2">
          <Plus size={16} /> Tambah Jadwal
        </button>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {/* Calendar View */}
        <div className="lg:col-span-2 bg-white rounded-[40px] border border-border-subtle shadow-sm overflow-hidden">
          <div className="p-8 border-b border-border-subtle flex items-center justify-between">
            <h3 className="font-black text-primary text-lg">{monthName} {year}</h3>
            <div className="flex gap-2">
              <button className="p-2 hover:bg-surface-soft rounded-xl transition-colors"><ChevronLeft size={20} /></button>
              <button className="p-2 hover:bg-surface-soft rounded-xl transition-colors"><ChevronRight size={20} /></button>
            </div>
          </div>
          
          <div className="p-8">
            <div className="grid grid-cols-7 gap-4 mb-4">
              {['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'].map(day => (
                <div key={day} className="text-center text-[10px] font-black text-primary/30 uppercase tracking-[0.2em]">{day}</div>
              ))}
            </div>
            <div className="grid grid-cols-7 gap-2">
              {[...Array(firstDayOfMonth)].map((_, i) => (
                <div key={`empty-${i}`} className="aspect-square"></div>
              ))}
              {[...Array(daysInMonth)].map((_, i) => {
                const day = i + 1;
                const isToday = day === 7;
                return (
                  <div 
                    key={day} 
                    className={`aspect-square rounded-2xl flex flex-col items-center justify-center relative border transition-all cursor-pointer ${
                      isToday 
                      ? "bg-primary border-primary text-white shadow-xl shadow-primary/20" 
                      : "bg-surface-soft border-transparent hover:border-accent group"
                    }`}
                  >
                    <span className={`text-sm font-black ${isToday ? "" : "text-primary"}`}>{day}</span>
                    {day === 7 && <div className="absolute bottom-2 w-1.5 h-1.5 bg-accent rounded-full"></div>}
                    {day === 8 && <div className="absolute bottom-2 w-1.5 h-1.5 bg-primary/20 rounded-full group-hover:bg-accent transition-colors"></div>}
                  </div>
                );
              })}
            </div>
          </div>
        </div>

        {/* Schedule Sidebar */}
        <div className="space-y-6">
          <div className="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
            <h3 className="font-black text-primary mb-6 flex items-center gap-2 text-sm uppercase tracking-widest">
              <Clock size={16} className="text-accent" /> Detail Jadwal
            </h3>
            <div className="space-y-6">
              {EVENTS.filter(e => e.date === '2026-06-07').map((event) => (
                <div key={event.id} className="relative pl-6 pb-6 border-l-2 border-surface-soft last:pb-0">
                  <div className="absolute -left-[9px] top-0 w-4 h-4 rounded-full bg-accent border-4 border-white"></div>
                  <div className="flex items-center justify-between mb-1">
                    <span className="text-[10px] font-black text-accent uppercase tracking-widest">{event.time}</span>
                    <span className={`px-2 py-0.5 rounded-[4px] text-[8px] font-black uppercase ${
                      event.type === 'Closing' ? 'bg-emerald-100 text-emerald-600' : 'bg-blue-100 text-blue-600'
                    }`}>
                      {event.type}
                    </span>
                  </div>
                  <h4 className="font-bold text-primary text-sm mb-1">{event.title}</h4>
                  <p className="text-[10px] text-primary/40 flex items-center gap-1 font-bold">
                    <MapPin size={10} /> {event.location}
                  </p>
                </div>
              ))}
            </div>
          </div>

          <div className="bg-primary text-white p-8 rounded-[40px] shadow-xl relative overflow-hidden">
            <div className="relative z-10">
              <Users size={32} className="text-accent mb-4" />
              <h4 className="text-xl font-black mb-2 italic">Siap Survey?</h4>
              <p className="text-white/60 text-sm leading-relaxed mb-6">Jangan lupa konfirmasi ulang konsumen 1 jam sebelum jadwal dimulai.</p>
              <button className="w-full py-3 bg-white text-primary rounded-2xl font-black text-xs hover:bg-accent hover:text-white transition-all">
                Cek Data Konsumen
              </button>
            </div>
            <div className="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
          </div>
        </div>
      </div>
    </div>
  );
}
