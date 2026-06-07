import { useState } from "react";
import { 
  Search, 
  MapPin, 
  Home, 
  Wallet, 
  Clock, 
  ArrowRight, 
  X, 
  Phone, 
  User, 
  MessageCircle,
  ShieldCheck,
  CheckCircle2
} from "lucide-react";
import { motion, AnimatePresence } from "motion/react";
import { useNavigate } from "react-router";
import { ImageWithFallback } from "../components/figma/ImageWithFallback";

// Mock Data
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
    image: "https://images.unsplash.com/photo-1721815693498-cc28507c0ba2?q=80&w=2070",
  },
  {
    id: 2,
    name: "Arkana Premium Cluster",
    price: "450.000.000",
    dp: "45.000.000",
    installment: "3jt-an",
    type: "Cluster Premium",
    location: "Kec. Kanigaran, Probolinggo",
    specs: "3 KT, 2 KM, Private Garden, Smart Home",
    image: "https://images.unsplash.com/photo-1628744876497-eb30460be9f6?q=80&w=2070",
  },
  {
    id: 3,
    name: "Scandinavian Hill - Phase 2",
    price: "575.000.000",
    dp: "57.000.000",
    installment: "4jt-an",
    type: "Cluster Premium",
    location: "Kec. Wonoasih, Probolinggo",
    specs: "3 KT, 2 KM, Attic Room, Balcony",
    image: "https://images.unsplash.com/photo-1660361338485-c926a27d4eb8?q=80&w=2070",
  },
];

export function LandingPage() {
  const [selectedProperty, setSelectedProperty] = useState<any>(null);
  const [isFormSubmitted, setIsFormSubmitted] = useState(false);
  const [filterType, setFilterType] = useState("Semua Jenis");
  const [isSearching, setIsSearching] = useState(false);
  const navigate = useNavigate();

  const handleSearch = () => {
    setIsSearching(true);
    setTimeout(() => setIsSearching(false), 800);
  };

  const filteredProperties = filterType === "Semua Jenis" 
    ? PROPERTIES 
    : PROPERTIES.filter(p => p.type === filterType);

  return (
    <div className="bg-surface-soft pb-20">
      {/* Hero Section */}
      <section className="relative h-[85vh] flex items-center overflow-hidden">
        <div className="absolute inset-0">
          <img 
            src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070" 
            className="w-full h-full object-cover"
            alt="Hero Background"
          />
          <div className="absolute inset-0 bg-primary/60 mix-blend-multiply"></div>
          <div className="absolute inset-0 bg-gradient-to-t from-primary via-primary/20 to-transparent"></div>
        </div>

        <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-white">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            className="max-w-3xl"
          >
            <span className="inline-block px-4 py-1 bg-accent text-white rounded-full text-xs font-bold tracking-widest uppercase mb-6">
              Pilihan Terpercaya di Probolinggo
            </span>
            <h1 className="text-5xl md:text-7xl font-black mb-6 leading-[1.1]">
              Wujudkan Hunian Impian Keluarga Anda.
            </h1>
            <p className="text-xl text-white/80 mb-10 max-w-2xl">
              Temukan berbagai pilihan rumah subsidi dan cluster premium dengan akses strategis dan lingkungan asri di jantung kota Probolinggo.
            </p>
            <div className="flex flex-wrap gap-4 mb-12">
              <a href="#katalog" className="btn-primary flex items-center gap-2">
                Lihat Katalog Properti <ArrowRight size={20} />
              </a>
              <button className="btn-gold-outline !text-white border-white hover:bg-white hover:text-primary">
                Konsultasi Gratis
              </button>
            </div>

            {/* Adjusted Stats Position */}
            <div className="flex gap-8 border-t border-white/10 pt-8">
              <div>
                <p className="text-accent text-3xl font-black">500+</p>
                <p className="text-white/60 text-xs font-bold uppercase tracking-widest">Unit Terjual</p>
              </div>
              <div className="w-[1px] h-12 bg-white/10"></div>
              <div>
                <p className="text-accent text-3xl font-black">12+</p>
                <p className="text-white/60 text-xs font-bold uppercase tracking-widest">Proyek Berjalan</p>
              </div>
            </div>
          </motion.div>
        </div>
      </section>

      {/* Filter Widget */}
      <section className="relative -mt-20 z-10 px-4">
        <div className="max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl p-8 lg:p-10 border border-border-subtle">
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div className="space-y-2">
              <label className="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                <MapPin size={14} className="text-accent" /> Lokasi
              </label>
              <select className="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-accent outline-none">
                <option>Seluruh Probolinggo</option>
                <option>Kec. Mayangan</option>
                <option>Kec. Kanigaran</option>
                <option>Kec. Wonoasih</option>
              </select>
            </div>

            <div className="space-y-2">
              <label className="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                <Wallet size={14} className="text-accent" /> Kisaran Budget
              </label>
              <div className="flex items-center gap-2">
                <input type="number" placeholder="Min" className="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold text-sm outline-none" />
                <span className="text-primary/20">-</span>
                <input type="number" placeholder="Max" className="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold text-sm outline-none" />
              </div>
            </div>

            <div className="space-y-2">
              <label className="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                <Clock size={14} className="text-accent" /> Lama Angsuran
              </label>
              <select className="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-accent outline-none">
                <option>Pilih Tenor</option>
                <option>5 Tahun</option>
                <option>10 Tahun</option>
                <option>15 Tahun</option>
                <option>20 Tahun</option>
              </select>
            </div>

            <div className="space-y-2">
              <label className="text-xs font-bold text-primary/40 uppercase tracking-widest flex items-center gap-2">
                <Home size={14} className="text-accent" /> Jenis Rumah
              </label>
              <div className="flex gap-2">
                <select 
                  value={filterType}
                  onChange={(e) => setFilterType(e.target.value)}
                  className="w-full bg-surface-soft border-none rounded-xl p-3 font-semibold focus:ring-2 focus:ring-accent outline-none"
                >
                  <option>Semua Jenis</option>
                  <option>Subsidi</option>
                  <option>Cluster Premium</option>
                </select>
                <button 
                  onClick={handleSearch}
                  className="bg-primary text-white p-3 rounded-xl hover:bg-accent transition-colors shrink-0"
                >
                  <Search size={20} />
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Property List */}
      <section id="katalog" className="max-w-7xl mx-auto px-4 mt-24">
        <div className="flex flex-col md:flex-row items-end justify-between mb-12 gap-6">
          <div className="max-w-xl">
            <span className="text-accent text-xs font-black uppercase tracking-[0.3em] mb-4 inline-block">Katalog Properti</span>
            <h2 className="text-4xl md:text-5xl font-black text-primary leading-tight">Temukan Unit Pilihan Untuk Keluarga Anda.</h2>
          </div>
          <div className="flex gap-4 mb-2">
            <button className="p-4 bg-white border border-border-subtle rounded-2xl text-primary hover:border-accent transition-all shadow-sm">
              <ArrowRight size={20} className="rotate-180" />
            </button>
            <button className="p-4 bg-white border border-border-subtle rounded-2xl text-primary hover:border-accent transition-all shadow-sm">
              <ArrowRight size={20} />
            </button>
          </div>
        </div>

        {isSearching ? (
          <div className="py-20 flex flex-col items-center justify-center space-y-4">
            <div className="w-12 h-12 border-4 border-accent border-t-transparent rounded-full animate-spin"></div>
            <p className="font-bold text-primary/40 uppercase tracking-widest text-xs">Mencari Properti Terbaik...</p>
          </div>
        ) : filteredProperties.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {filteredProperties.map((property) => (
              <motion.div 
                key={property.id}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                whileHover={{ y: -10 }}
                className="bg-white rounded-[40px] overflow-hidden border border-border-subtle shadow-sm group hover:shadow-2xl hover:shadow-primary/5 transition-all duration-500 flex flex-col h-full"
              >
                <div className="relative h-72 overflow-hidden shrink-0">
                  <img 
                    src={property.image} 
                    className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" 
                    alt={property.name} 
                  />
                  <div className="absolute top-6 left-6">
                    <span className={`px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest text-white ${
                      property.type === 'Subsidi' ? 'bg-blue-600' : 'bg-accent'
                    }`}>
                      {property.type}
                    </span>
                  </div>
                  <div className="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                </div>

                <div className="p-8 flex flex-col flex-grow">
                  <div className="flex items-center gap-2 text-primary/40 font-bold text-[10px] uppercase tracking-widest mb-3">
                    <MapPin size={12} className="text-accent" /> {property.location}
                  </div>
                  <h3 className="text-xl font-black text-primary mb-4 line-clamp-2 leading-tight group-hover:text-accent transition-colors">
                    {property.name}
                  </h3>
                  
                  <div className="grid grid-cols-2 gap-4 mb-8 pt-6 border-t border-border-subtle">
                    <div>
                      <p className="text-[9px] font-bold text-primary/40 uppercase tracking-widest mb-1">Harga Mulai</p>
                      <p className="text-lg font-black text-primary">Rp {property.price}</p>
                    </div>
                    <div>
                      <p className="text-[9px] font-bold text-primary/40 uppercase tracking-widest mb-1">Cicilan / bln</p>
                      <p className="text-lg font-black text-accent">{property.installment}</p>
                    </div>
                  </div>

                  <div className="mt-auto flex items-center justify-between gap-4">
                    <button 
                      onClick={() => setSelectedProperty(property)}
                      className="flex-grow btn-primary !py-4 text-xs"
                    >
                      Detail Unit
                    </button>
                    <button 
                      onClick={() => navigate(`/property/${property.id}`)}
                      className="p-4 bg-surface-soft text-primary rounded-2xl hover:bg-primary hover:text-white transition-all shadow-sm"
                    >
                      <ArrowRight size={18} />
                    </button>
                  </div>
                </div>
              </motion.div>
            ))}
          </div>
        ) : (
          <div className="py-20 text-center bg-white rounded-[40px] border border-border-subtle">
            <h3 className="text-xl font-black text-primary mb-2">Properti Tidak Ditemukan</h3>
            <p className="text-primary/60">Coba ubah kriteria pencarian atau pilih jenis rumah yang berbeda.</p>
          </div>
        )}

        <div className="mt-16 text-center">
          <button className="btn-gold-outline inline-flex items-center gap-3">
            Lihat Semua Unit Properti <ArrowRight size={18} />
          </button>
        </div>
      </section>

      {/* Why Choose Us */}
      <section className="bg-primary text-white py-24 mt-24">
        <div className="max-w-7xl mx-auto px-4">
          <div className="text-center mb-16">
            <span className="text-accent text-xs font-black uppercase tracking-[0.3em] mb-4 inline-block">Keunggulan Kami</span>
            <h2 className="text-4xl md:text-5xl font-black mb-6">Mengapa Arkanaproperty?</h2>
            <p className="text-white/60 max-w-2xl mx-auto">Kami tidak hanya membangun rumah, kami membangun masa depan keluarga Anda dengan standar kualitas terbaik.</p>
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {[
              { title: "Legalitas Terjamin", desc: "Seluruh unit memiliki sertifikat (SHM) dan perizinan IMB/PBG yang lengkap dan aman.", icon: ShieldCheck },
              { title: "Lokasi Strategis", desc: "Akses mudah menuju pusat kota, sekolah, rumah sakit, dan fasilitas publik lainnya.", icon: MapPin },
              { title: "Kualitas Bangunan", desc: "Material pilihan dan pengawasan konstruksi ketat untuk hunian tahan lama.", icon: CheckCircle2 },
              { title: "Proses Transparan", desc: "Pantau progres berkas dan pembangunan unit Anda secara real-time melalui portal.", icon: Clock },
            ].map((item, i) => (
              <motion.div 
                key={i}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                viewport={{ once: true }}
                transition={{ delay: i * 0.1 }}
                className="bg-white/5 p-8 rounded-[32px] border border-white/10 hover:bg-white/10 transition-all group"
              >
                <div className="w-14 h-14 bg-accent/20 text-accent rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                  <item.icon size={28} />
                </div>
                <h4 className="text-xl font-black mb-3">{item.title}</h4>
                <p className="text-white/60 text-sm leading-relaxed">{item.desc}</p>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-24 max-w-7xl mx-auto px-4">
        <div className="flex flex-col md:flex-row items-center justify-between mb-16 gap-8">
          <div className="text-center md:text-left">
            <h2 className="text-4xl font-black text-primary mb-4">Apa Kata Mereka?</h2>
            <p className="text-primary/60">Lebih dari 500 keluarga telah mempercayakan hunian mereka kepada kami.</p>
          </div>
          <button className="btn-gold-outline">Lihat Semua Review</button>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {[
            { name: "Bpk. Rendi Saputra", role: "Pembeli Tipe 36", content: "Prosesnya sangat cepat dan transparan. Marketing sangat membantu dalam pengurusan berkas KPR sampai akad.", image: "https://api.dicebear.com/7.x/avataaars/svg?seed=Rendi" },
            { name: "Ibu Maya Lestari", role: "Investor Properti", content: "Lokasi perumahan Arkanaproperty selalu strategis. Nilai investasinya naik signifikan setiap tahunnya.", image: "https://api.dicebear.com/7.x/avataaars/svg?seed=Maya" },
            { name: "Bpk. Hendra Kurniawan", role: "Pembeli Premium Cluster", content: "Kualitas bangunan jempolan. Desainnya modern dan lingkungannya sangat asri untuk anak-anak.", image: "https://api.dicebear.com/7.x/avataaars/svg?seed=Hendra" },
          ].map((item, i) => (
            <motion.div 
              key={i}
              whileHover={{ scale: 1.02 }}
              className="bg-white p-8 rounded-[40px] border border-border-subtle shadow-sm relative"
            >
              <div className="flex items-center gap-4 mb-6">
                <img src={item.image} className="w-12 h-12 rounded-full bg-surface-soft border border-border-subtle" alt={item.name} />
                <div>
                  <h4 className="font-bold text-primary text-sm">{item.name}</h4>
                  <p className="text-[10px] text-primary/40 font-bold uppercase tracking-widest">{item.role}</p>
                </div>
              </div>
              <p className="text-primary/70 text-sm italic leading-relaxed">"{item.content}"</p>
            </motion.div>
          ))}
        </div>
      </section>

      {/* Contact CTA */}
      <section className="max-w-7xl mx-auto px-4 mb-24">
        <div className="bg-accent rounded-[48px] p-8 md:p-16 flex flex-col md:flex-row items-center justify-between gap-12 relative overflow-hidden">
          <div className="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full translate-x-1/3 -translate-y-1/3"></div>
          <div className="relative z-10 text-center md:text-left">
            <h2 className="text-4xl md:text-5xl font-black text-white mb-6 leading-tight">Mulai Perjalanan Hunian <br/>Impian Anda Sekarang.</h2>
            <p className="text-white/80 text-lg mb-8 max-w-lg">Konsultasikan kebutuhan hunian Anda dengan tim ahli kami secara gratis.</p>
            <div className="flex flex-wrap justify-center md:justify-start gap-4">
              <button className="px-8 py-4 bg-primary text-white rounded-2xl font-black flex items-center gap-3 hover:scale-105 transition-all shadow-2xl shadow-primary/40">
                <MessageCircle size={24} /> Hubungi Lewat WhatsApp
              </button>
              <button className="px-8 py-4 bg-white text-primary rounded-2xl font-black hover:scale-105 transition-all shadow-xl shadow-white/20">
                Lihat Lokasi Project
              </button>
            </div>
          </div>
          <div className="hidden lg:block relative z-10">
            <div className="w-80 h-80 bg-white/20 backdrop-blur-xl rounded-[60px] p-10 flex flex-col justify-center">
              <Phone size={48} className="text-white mb-6" />
              <p className="text-white/60 text-sm font-bold uppercase tracking-widest mb-2">Layanan 24/7</p>
              <h4 className="text-white text-3xl font-black">(0335) 423-123</h4>
            </div>
          </div>
        </div>
      </section>

      {/* Property Detail Modal & Lead Form */}
      <AnimatePresence>
        {selectedProperty && (
          <div className="fixed inset-0 z-[100] flex items-center justify-center p-4">
            <motion.div 
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => setSelectedProperty(null)}
              className="absolute inset-0 bg-primary/40 backdrop-blur-md"
            ></motion.div>
            
            <motion.div 
              initial={{ opacity: 0, scale: 0.9, y: 20 }}
              animate={{ opacity: 1, scale: 1, y: 0 }}
              exit={{ opacity: 0, scale: 0.9, y: 20 }}
              className="relative w-full max-w-5xl bg-white rounded-[32px] overflow-hidden shadow-2xl flex flex-col lg:flex-row max-h-[90vh]"
            >
              {/* Close Button */}
              <button 
                onClick={() => setSelectedProperty(null)}
                className="absolute top-6 right-6 z-50 p-3 bg-white/10 hover:bg-white/20 backdrop-blur-xl border border-white/20 rounded-full text-white lg:text-primary lg:bg-surface-soft lg:border-border-subtle transition-all"
              >
                <X size={20} />
              </button>

              {/* Left Side: Images & Info */}
              <div className="lg:w-3/5 overflow-y-auto custom-scrollbar">
                <div className="h-80 lg:h-96 w-full">
                  <img src={selectedProperty.image} className="w-full h-full object-cover" alt={selectedProperty.name} />
                </div>
                <div className="p-10">
                  <div className="flex items-center gap-2 text-accent text-xs font-bold uppercase tracking-widest mb-4">
                    <Home size={14} /> {selectedProperty.type} Unit
                  </div>
                  <h2 className="text-3xl font-black text-primary mb-6">{selectedProperty.name}</h2>
                  
                  <div className="grid grid-cols-2 gap-8 mb-10">
                    <div className="p-6 bg-surface-soft rounded-2xl">
                      <p className="text-xs font-bold text-primary/40 uppercase tracking-widest mb-1">Booking Fee</p>
                      <p className="text-xl font-black text-primary">Rp 1.000.000</p>
                    </div>
                    <div className="p-6 bg-surface-soft rounded-2xl">
                      <p className="text-xs font-bold text-primary/40 uppercase tracking-widest mb-1">Uang Muka (DP)</p>
                      <p className="text-xl font-black text-accent">Rp {selectedProperty.dp}</p>
                    </div>
                  </div>

                  <h4 className="font-black text-primary mb-4">Spesifikasi Bangunan</h4>
                  <ul className="grid grid-cols-2 gap-y-3 gap-x-6 text-primary/70 mb-10">
                    <li className="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Pondasi Batu Kali</li>
                    <li className="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Dinding Bata Ringan</li>
                    <li className="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Rangka Atap Galvalum</li>
                    <li className="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Lantai Granit 60x60</li>
                    <li className="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Listrik 1300 Watt</li>
                    <li className="flex items-center gap-2 border-b border-border-subtle pb-2">✓ Air Bersih PDAM</li>
                  </ul>
                </div>
              </div>

              {/* Right Side: Leads Form */}
              <div className="lg:w-2/5 bg-surface-soft p-10 flex flex-col border-l border-border-subtle">
                {!isFormSubmitted ? (
                  <>
                    <div className="mb-8">
                      <h3 className="text-2xl font-black text-primary mb-2">Tertarik dengan Unit Ini?</h3>
                      <p className="text-primary/60 text-sm">Isi data di bawah ini, Marketing kami akan segera menghubungi Anda melalui WhatsApp.</p>
                    </div>

                    <form className="space-y-4" onSubmit={(e) => { e.preventDefault(); setIsFormSubmitted(true); }}>
                      <div className="space-y-1">
                        <label className="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Nama Lengkap</label>
                        <div className="relative">
                          <User size={16} className="absolute left-4 top-1/2 -translate-y-1/2 text-primary/30" />
                          <input 
                            required 
                            type="text" 
                            className="w-full bg-white border border-border-subtle rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium" 
                            placeholder="Contoh: Ahmad Rizky" 
                          />
                        </div>
                      </div>

                      <div className="space-y-1">
                        <label className="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Nomor WhatsApp</label>
                        <div className="relative">
                          <Phone size={16} className="absolute left-4 top-1/2 -translate-y-1/2 text-primary/30" />
                          <input 
                            required 
                            type="tel" 
                            className="w-full bg-white border border-border-subtle rounded-xl py-3 pl-12 pr-4 focus:ring-2 focus:ring-accent outline-none font-medium" 
                            placeholder="0812xxxxxx" 
                          />
                        </div>
                      </div>

                      <div className="space-y-1">
                        <label className="text-[10px] font-bold text-primary/40 uppercase tracking-widest px-2">Pesan Tambahan</label>
                        <textarea 
                          className="w-full bg-white border border-border-subtle rounded-xl py-3 px-4 focus:ring-2 focus:ring-accent outline-none font-medium min-h-[100px]" 
                          placeholder="Ingin tanya jadwal survey lokasi..."
                        ></textarea>
                      </div>

                      <button type="submit" className="w-full btn-primary py-4 flex items-center justify-center gap-2">
                        Kirim Ketertarikan <ArrowRight size={20} />
                      </button>
                    </form>

                    <p className="text-[10px] text-center text-primary/40 mt-6 leading-relaxed uppercase tracking-tighter">
                      Dengan menekan tombol, Anda menyetujui kebijakan privasi kami dan bersedia dihubungi oleh tim marketing.
                    </p>
                  </>
                ) : (
                  <div className="flex-grow flex flex-col items-center justify-center text-center space-y-6">
                    <div className="w-20 h-20 bg-emerald-custom text-white rounded-full flex items-center justify-center shadow-xl shadow-emerald-custom/20">
                      <MessageCircle size={40} />
                    </div>
                    <div>
                      <h3 className="text-2xl font-black text-primary mb-2">Terima Kasih!</h3>
                      <p className="text-primary/60">Data Anda telah kami terima. Marketing kami akan segera menghubungi Anda dalam waktu maksimal 1x24 jam.</p>
                    </div>
                    <button 
                      onClick={() => { setIsFormSubmitted(false); setSelectedProperty(null); }}
                      className="btn-gold-outline"
                    >
                      Kembali ke Beranda
                    </button>
                  </div>
                )}
              </div>
            </motion.div>
          </div>
        )}
      </AnimatePresence>
    </div>
  );
}
