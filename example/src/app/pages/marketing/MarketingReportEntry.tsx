import { 
  ClipboardList, 
  Send, 
  History, 
  ChevronRight,
  User,
  CheckCircle2,
  AlertCircle
} from "lucide-react";
import { useState } from "react";
import { motion } from "motion/react";

export function MarketingReportEntry() {
  const [isSubmitted, setIsSubmitted] = useState(false);

  return (
    <div className="max-w-4xl mx-auto space-y-8">
      <div>
        <h1 className="text-2xl font-black text-primary">Input Laporan Harian</h1>
        <p className="text-primary/60">Laporkan aktivitas follow-up atau survey Anda hari ini.</p>
      </div>

      <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div className="lg:col-span-2">
          <div className="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm">
            {!isSubmitted ? (
              <form className="space-y-6" onSubmit={(e) => { e.preventDefault(); setIsSubmitted(true); }}>
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div className="space-y-2">
                    <label className="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Pilih Konsumen</label>
                    <select className="w-full bg-surface-soft border-none rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-accent">
                      <option>Ahmad Rizky (Blok A-12)</option>
                      <option>Siti Aminah (Cluster Premium)</option>
                      <option>Budi Santoso (Tipe 36/60)</option>
                      <option>Lead Baru / Walk-in</option>
                    </select>
                  </div>
                  <div className="space-y-2">
                    <label className="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Jenis Aktivitas</label>
                    <select className="w-full bg-surface-soft border-none rounded-2xl p-4 text-sm font-bold outline-none focus:ring-2 focus:ring-accent">
                      <option>Survey Lokasi</option>
                      <option>Follow Up WhatsApp</option>
                      <option>Telepon Penawaran</option>
                      <option>Booking Unit</option>
                      <option>Tanda Tangan PPJB</option>
                    </select>
                  </div>
                </div>

                <div className="space-y-2">
                  <label className="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Detail Laporan</label>
                  <textarea 
                    placeholder="Ceritakan detail pembicaraan atau hasil survey..."
                    className="w-full bg-surface-soft border-none rounded-2xl p-6 text-sm font-medium outline-none focus:ring-2 focus:ring-accent min-h-[200px]"
                  ></textarea>
                </div>

                <div className="p-4 bg-accent/5 border border-accent/20 rounded-2xl flex gap-4 items-start">
                  <AlertCircle className="text-accent shrink-0" size={20} />
                  <p className="text-xs text-primary/60 leading-relaxed font-medium">
                    Pastikan data yang Anda masukkan sudah benar. Laporan ini akan langsung tampil di dashboard Administrator untuk divalidasi.
                  </p>
                </div>

                <button type="submit" className="w-full btn-primary py-5 flex items-center justify-center gap-3 text-lg">
                  Kirim Laporan <Send size={20} />
                </button>
              </form>
            ) : (
              <div className="py-20 text-center space-y-6">
                <div className="w-20 h-20 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-xl mx-auto">
                  <CheckCircle2 size={40} />
                </div>
                <h3 className="text-2xl font-black">Laporan Terkirim!</h3>
                <p className="text-primary/60">Terima kasih atas dedikasi Anda hari ini. Terus semangat mengejar closing!</p>
                <button onClick={() => setIsSubmitted(false)} className="btn-gold-outline">Buat Laporan Lagi</button>
              </div>
            )}
          </div>
        </div>

        <div className="space-y-6">
          <div className="bg-white p-6 rounded-[32px] border border-border-subtle shadow-sm">
            <h3 className="font-black text-primary mb-6 flex items-center gap-3 text-sm uppercase tracking-widest">
              <History size={18} className="text-accent" /> History Terbaru
            </h3>
            <div className="space-y-4">
              {[1, 2, 3].map(i => (
                <div key={i} className="p-4 bg-surface-soft rounded-2xl group cursor-pointer hover:bg-white border border-transparent hover:border-border-subtle transition-all">
                  <div className="flex justify-between items-start mb-2">
                    <span className="text-[10px] font-black text-primary/40 uppercase tracking-widest">7 Juni</span>
                    <CheckCircle2 size={14} className="text-emerald-custom" />
                  </div>
                  <h4 className="font-bold text-primary text-xs">Survey Lokasi: Ahmad R.</h4>
                  <p className="text-[10px] text-primary/40 line-clamp-1 mt-1">Klien tertarik dengan hook...</p>
                </div>
              ))}
              <button className="w-full text-center text-[10px] font-black text-accent uppercase tracking-widest pt-2 hover:underline">
                Lihat Semua History
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
