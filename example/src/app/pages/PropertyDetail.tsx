import { useParams, Link } from "react-router";
import { 
  ChevronLeft, 
  MapPin, 
  Home, 
  Wallet, 
  Calendar, 
  CheckCircle2, 
  ArrowRight,
  Phone,
  MessageCircle,
  Share2,
  Heart,
  Maximize,
  Compass,
  Zap,
  Droplet
} from "lucide-react";
import { motion } from "motion/react";
import { useState } from "react";

// Using the same mock data as LandingPage
const PROPERTIES = [
  {
    id: 1,
    name: "Arkanaproperty Residence - Tipe 36/60",
    price: "162.000.000",
    dp: "5.000.000",
    installment: "900rb-an",
    type: "Subsidi",
    location: "Kec. Mayangan, Probolinggo",
    specs: "2 KT, 1 KM, Dapur, Carport",
    desc: "Hunian subsidi ternyaman di Probolinggo dengan kualitas bangunan komersil. Lokasi strategis dekat dengan pusat kota, sekolah, dan area perbelanjaan. Cocok untuk keluarga muda yang ingin memiliki rumah pertama.",
    image: "https://images.unsplash.com/photo-1721815693498-cc28507c0ba2?q=80&w=2070",
  },
  // Add others if needed
];

export function PropertyDetail() {
  const { id } = useParams();
  const [isFormSubmitted, setIsFormSubmitted] = useState(false);
  const property = PROPERTIES.find(p => p.id === Number(id)) || PROPERTIES[0];

  return (
    <div className="bg-surface-soft min-h-screen pb-20 pt-24">
      <div className="max-w-7xl mx-auto px-4">
        {/* Breadcrumb / Back */}
        <Link to="/" className="inline-flex items-center gap-2 text-primary/40 hover:text-accent font-bold text-xs uppercase tracking-widest mb-8 transition-colors group">
          <ChevronLeft size={16} className="group-hover:-translate-x-1 transition-transform" /> Kembali ke Katalog
        </Link>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-12">
          {/* Main Content */}
          <div className="lg:col-span-2 space-y-10">
            {/* Image Gallery */}
            <div className="relative rounded-[40px] overflow-hidden shadow-2xl h-[500px]">
              <img src={property.image} className="w-full h-full object-cover" alt={property.name} />
              <div className="absolute bottom-8 right-8 flex gap-3">
                <button className="p-4 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl text-white hover:bg-white hover:text-primary transition-all">
                  <Maximize size={20} />
                </button>
                <button className="p-4 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl text-white hover:bg-white hover:text-primary transition-all">
                  <Share2 size={20} />
                </button>
                <button className="p-4 bg-accent text-white rounded-2xl shadow-xl shadow-accent/20">
                  <Heart size={20} fill="currentColor" />
                </button>
              </div>
            </div>

            {/* Title & Info */}
            <div className="bg-white p-10 rounded-[40px] border border-border-subtle shadow-sm">
              <div className="flex items-center gap-2 text-accent text-xs font-bold uppercase tracking-widest mb-4">
                <Home size={14} /> {property.type} Unit
              </div>
              <h1 className="text-4xl font-black text-primary mb-6">{property.name}</h1>
              <div className="flex items-center gap-2 text-primary/40 font-bold text-sm mb-8">
                <MapPin size={16} className="text-accent" /> {property.location}
              </div>

              <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mb-10 pt-10 border-t border-border-subtle">
                <div className="space-y-1">
                  <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Harga Mulai</p>
                  <p className="text-xl font-black text-accent">Rp {property.price}</p>
                </div>
                <div className="space-y-1">
                  <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Cicilan</p>
                  <p className="text-xl font-black text-primary">{property.installment}</p>
                </div>
                <div className="space-y-1">
                  <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Uang Muka</p>
                  <p className="text-xl font-black text-primary">Rp {property.dp}</p>
                </div>
                <div className="space-y-1">
                  <p className="text-[10px] font-bold text-primary/40 uppercase tracking-widest">Booking</p>
                  <p className="text-xl font-black text-primary">Rp 1jt</p>
                </div>
              </div>

              <div className="prose prose-slate max-w-none">
                <h4 className="font-black text-primary text-xl mb-4">Deskripsi Properti</h4>
                <p className="text-primary/60 leading-relaxed text-lg">{property.desc}</p>
              </div>
            </div>

            {/* Specifications */}
            <div className="bg-white p-10 rounded-[40px] border border-border-subtle shadow-sm">
              <h4 className="font-black text-primary text-xl mb-8">Spesifikasi Bangunan</h4>
              <div className="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                {[
                  { label: "Luas Tanah", value: "60 m²", icon: Maximize },
                  { label: "Luas Bangunan", value: "36 m²", icon: Home },
                  { label: "Kamar Tidur", value: "2 Ruangan", icon: Home },
                  { label: "Kamar Mandi", value: "1 Ruangan", icon: Droplet },
                  { label: "Daya Listrik", value: "1300 Watt", icon: Zap },
                  { label: "Arah Bangunan", value: "Utara / Selatan", icon: Compass },
                ].map((spec, i) => (
                  <div key={i} className="flex items-center justify-between py-4 border-b border-border-subtle last:border-0">
                    <div className="flex items-center gap-4">
                      <div className="w-10 h-10 bg-surface-soft rounded-xl flex items-center justify-center text-accent">
                        <spec.icon size={20} />
                      </div>
                      <span className="text-sm font-bold text-primary/60">{spec.label}</span>
                    </div>
                    <span className="font-black text-primary">{spec.value}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>

          {/* Sidebar: Form */}
          <div className="space-y-8">
            <div className="sticky top-24 bg-primary text-white p-10 rounded-[40px] shadow-2xl">
              {!isFormSubmitted ? (
                <>
                  <h3 className="text-2xl font-black mb-4">Konsultasi Gratis</h3>
                  <p className="text-white/60 text-sm mb-8">Dapatkan penawaran cicilan khusus dan jadwal survey lokasi gratis hari ini.</p>
                  
                  <form className="space-y-4" onSubmit={(e) => { e.preventDefault(); setIsFormSubmitted(true); }}>
                    <div className="space-y-1">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-widest px-2">Nama Lengkap</label>
                      <input 
                        required 
                        type="text" 
                        placeholder="Ahmad Rizky"
                        className="w-full bg-white/10 border border-white/10 rounded-2xl py-4 px-6 focus:bg-white/20 focus:ring-2 focus:ring-accent outline-none font-medium transition-all" 
                      />
                    </div>
                    <div className="space-y-1">
                      <label className="text-[10px] font-bold text-white/40 uppercase tracking-widest px-2">Nomor WhatsApp</label>
                      <input 
                        required 
                        type="tel" 
                        placeholder="0812xxxxxxxx"
                        className="w-full bg-white/10 border border-white/10 rounded-2xl py-4 px-6 focus:bg-white/20 focus:ring-2 focus:ring-accent outline-none font-medium transition-all" 
                      />
                    </div>
                    <button type="submit" className="w-full bg-accent text-white py-5 rounded-2xl font-black text-lg shadow-xl shadow-accent/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                      Hubungi Marketing <ArrowRight size={22} />
                    </button>
                  </form>
                  <p className="text-[10px] text-center text-white/30 mt-8 leading-relaxed uppercase tracking-tighter">
                    Tanpa biaya pendaftaran. Marketing kami akan memandu Anda sepenuhnya.
                  </p>
                </>
              ) : (
                <div className="text-center py-10 space-y-6">
                  <div className="w-20 h-20 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-xl mx-auto">
                    <CheckCircle2 size={40} />
                  </div>
                  <h3 className="text-2xl font-black">Berhasil!</h3>
                  <p className="text-white/60">Terima kasih atas minat Anda. Tim kami akan menghubungi melalui WhatsApp dalam waktu dekat.</p>
                  <button onClick={() => setIsFormSubmitted(false)} className="text-accent font-bold hover:underline">Kirim pesan lain</button>
                </div>
              )}
            </div>

            <div className="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm flex items-center gap-6 group cursor-pointer">
              <div className="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                <MessageCircle size={32} />
              </div>
              <div>
                <h4 className="font-black text-primary">Chat WhatsApp</h4>
                <p className="text-xs text-primary/40">Respon cepat via WA Marketing</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
