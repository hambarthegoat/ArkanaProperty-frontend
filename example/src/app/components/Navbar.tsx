import { useState, useEffect } from 'react';
import { Home, Menu, X, LogIn } from 'lucide-react';
import { Link, useLocation } from 'react-router';

export function Navbar() {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const location = useLocation();

  // Handle smooth scrolling for anchor links
  const handleScroll = (e: React.MouseEvent<HTMLAnchorElement>, targetId: string) => {
    // Only intercept if we are on the landing page
    if (location.pathname === '/') {
      e.preventDefault();
      const element = document.getElementById(targetId);
      if (element) {
        element.scrollIntoView({ behavior: 'smooth' });
      }
      setIsMobileMenuOpen(false); // Close mobile menu after clicking
    }
  };

  const navLinks = [
    { name: 'Beranda', href: '#beranda', id: 'beranda' },
    { name: 'Tipe Rumah', href: '#tipe-rumah', id: 'tipe-rumah' },
    { name: 'Kavling', href: '#kavling', id: 'kavling' },
    { name: 'Lokasi', href: '#lokasi', id: 'lokasi' },
    { name: 'Galeri', href: '#galeri', id: 'galeri' },
  ];

  return (
    <nav className="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center h-20">
          {/* Logo */}
          <Link to="/" className="flex items-center gap-2">
            <Home className="w-8 h-8 text-[#1A3C5E]" />
            <span className="font-['Plus_Jakarta_Sans'] font-bold text-2xl tracking-tight text-[#1A3C5E]">
              Arkana<span className="text-[#C9A84C]">property</span>
            </span>
          </Link>

          {/* Desktop Navigation */}
          <div className="hidden lg:flex items-center space-x-6">
            {navLinks.map((link) => (
              <a
                key={link.name}
                href={link.href}
                onClick={(e) => handleScroll(e, link.id)}
                className="text-[#1F2937] hover:text-[#C9A84C] font-semibold transition-colors font-['Plus_Jakarta_Sans'] text-[15px]"
              >
                {link.name}
              </a>
            ))}
          </div>

          {/* Actions */}
          <div className="hidden lg:flex items-center space-x-4">
            <a 
              href="#kontak" 
              onClick={(e) => handleScroll(e, 'kontak')}
              className="px-5 py-2.5 rounded-lg border-2 border-[#C9A84C] text-[#C9A84C] font-semibold text-sm hover:bg-[#C9A84C] hover:text-white transition-all font-['Plus_Jakarta_Sans']"
            >
              Hubungi Kami
            </a>
            <Link 
              to="/login" 
              className="flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#1A3C5E] text-white font-semibold text-sm hover:bg-[#112840] transition-colors shadow-sm font-['Plus_Jakarta_Sans']"
            >
              <LogIn className="w-4 h-4" />
              Masuk
            </Link>
          </div>

          {/* Mobile menu button */}
          <div className="lg:hidden flex items-center">
            <button 
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
              className="text-[#1F2937] hover:text-[#C9A84C] focus:outline-none p-2"
            >
              {isMobileMenuOpen ? (
                <X className="h-7 w-7" />
              ) : (
                <Menu className="h-7 w-7" />
              )}
            </button>
          </div>
        </div>
      </div>

      {/* Mobile Navigation Dropdown */}
      {isMobileMenuOpen && (
        <div className="lg:hidden bg-white border-b border-gray-100 shadow-lg absolute w-full">
          <div className="px-4 pt-2 pb-6 space-y-2">
            {navLinks.map((link) => (
              <a
                key={link.name}
                href={link.href}
                onClick={(e) => handleScroll(e, link.id)}
                className="block px-3 py-3 rounded-md text-base font-medium text-[#1F2937] hover:text-[#C9A84C] hover:bg-gray-50"
              >
                {link.name}
              </a>
            ))}
            <div className="mt-6 pt-6 border-t border-gray-100 flex flex-col gap-3 px-3">
              <a 
                href="#kontak" 
                onClick={(e) => handleScroll(e, 'kontak')}
                className="w-full text-center px-5 py-3 rounded-lg border-2 border-[#C9A84C] text-[#C9A84C] font-semibold text-base hover:bg-[#C9A84C] hover:text-white transition-all"
              >
                Hubungi Kami
              </a>
              <Link 
                to="/login"
                onClick={() => setIsMobileMenuOpen(false)}
                className="w-full flex justify-center items-center gap-2 px-5 py-3 rounded-lg bg-[#1A3C5E] text-white font-semibold text-base hover:bg-[#112840] transition-colors"
              >
                <LogIn className="w-5 h-5" />
                Masuk Portal
              </Link>
            </div>
          </div>
        </div>
      )}
    </nav>
  );
}