import { Outlet, Link } from "react-router";
import { ImageWithFallback } from "../components/figma/ImageWithFallback";
import { Search, Phone, Menu, X } from "lucide-react";
import { useState } from "react";

export function MainLayout() {
  const [isMenuOpen, setIsMenuOpen] = useState(false);

  return (
    <div className="min-h-screen flex flex-col">
      <nav className="fixed w-full z-50 bg-white/90 backdrop-blur-sm border-b border-border-subtle">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between h-20 items-center">
            <Link to="/" className="flex items-center gap-2">
              <span className="text-2xl font-black text-primary tracking-tighter">
                Arkana<span className="text-accent">Property</span>
              </span>
            </Link>

            <div className="hidden md:flex items-center gap-8">
              <Link to="/" className="text-primary font-medium hover:text-accent transition-colors">Beranda</Link>
              <a href="#katalog" className="text-primary font-medium hover:text-accent transition-colors">Katalog</a>
              <Link to="/tentang" className="text-primary font-medium hover:text-accent transition-colors">Tentang Kami</Link>
              <Link to="/login" className="text-primary font-medium hover:text-accent transition-colors">Akses Panel</Link>
              <Link to="/login" className="btn-gold-outline flex items-center gap-2">
                Hubungi Kami
              </Link>
            </div>

            <button className="md:hidden p-2" onClick={() => setIsMenuOpen(!isMenuOpen)}>
              {isMenuOpen ? <X size={24} /> : <Menu size={24} />}
            </button>
          </div>
        </div>

        {/* Mobile Menu */}
        {isMenuOpen && (
          <div className="md:hidden bg-white border-b border-border-subtle p-4 space-y-4">
            <Link to="/" className="block text-primary font-medium" onClick={() => setIsMenuOpen(false)}>Beranda</Link>
            <a href="#katalog" className="block text-primary font-medium" onClick={() => setIsMenuOpen(false)}>Katalog Properti</a>
            <Link to="/tentang" className="block text-primary font-medium" onClick={() => setIsMenuOpen(false)}>Tentang Kami</Link>
            <Link to="/login" className="block text-primary font-medium" onClick={() => setIsMenuOpen(false)}>Akses Panel</Link>
            <Link to="/login" className="btn-gold-outline w-full text-center block" onClick={() => setIsMenuOpen(false)}>Hubungi Kami</Link>
          </div>
        )}
      </nav>

      <main className="flex-grow pt-20">
        <Outlet />
      </main>

      <footer className="bg-primary text-white py-12">
        <div className="max-w-7xl mx-auto px-4 text-center sm:text-left grid grid-cols-1 md:grid-cols-3 gap-8">
          <div>
            <h3 className="text-xl font-bold mb-4 italic">ArkanaProperty</h3>
            <p className="text-white/60 text-sm">
              Solusi hunian modern dan investasi properti terpercaya di Probolinggo dan sekitarnya.
            </p>
          </div>
          <div>
            <h4 className="font-bold mb-4">Tautan Cepat</h4>
            <ul className="space-y-2 text-sm text-white/60">
              <li><Link to="/">Beranda</Link></li>
              <li><a href="#katalog">Katalog Properti</a></li>
              <li><Link to="/tentang">Tentang Kami</Link></li>
              <li><Link to="/login">Akses Panel (Admin/Marketing)</Link></li>
            </ul>
          </div>
          <div>
            <h4 className="font-bold mb-4">Portal Konsumen</h4>
            <ul className="space-y-2 text-sm text-white/60">
              <li><Link to="/login">Login Portal</Link></li>
              <li><Link to="/login">Pantau Progres Unit</Link></li>
              <li><Link to="/login">Bantuan Konsumen</Link></li>
            </ul>
          </div>
          <div>
            <h4 className="font-bold mb-4">Hubungi Kami</h4>
            <p className="text-sm text-white/60 mb-2">Jl. Raya Arkanaproperty No. 1</p>
            <p className="text-sm text-white/60 mb-4">Probolinggo, Jawa Timur</p>
            <a href="https://wa.me/628123456789" className="btn-gold-outline !text-white border-white/20 hover:border-accent inline-block text-center">
              WhatsApp Marketing
            </a>
          </div>
        </div>
        <div className="max-w-7xl mx-auto px-4 mt-12 pt-8 border-t border-white/10 text-center text-xs text-white/40">
          © 2026 Arkanaproperty. Seluruh hak cipta dilindungi.
        </div>
      </footer>
    </div>
  );
}
