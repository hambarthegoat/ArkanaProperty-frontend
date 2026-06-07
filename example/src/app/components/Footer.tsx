import { Home, Facebook, Instagram, Twitter, Mail, Phone, MapPin } from 'lucide-react';
import { Link } from 'react-router';

export function Footer() {
  return (
    <footer className="bg-[#112840] pt-16 pb-8 border-t border-white/10">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
          
          {/* Logo & Tagline */}
          <div className="lg:col-span-1">
            <Link to="/" className="flex items-center gap-2 mb-4">
              <Home className="w-8 h-8 text-white" />
              <span className="font-['Plus_Jakarta_Sans'] font-bold text-2xl tracking-tight text-white">
                Arkana<span className="text-[#C9A84C]">property</span>
              </span>
            </Link>
            <p className="text-gray-400 font-['Plus_Jakarta_Sans'] text-sm leading-relaxed mb-6">
              Mewujudkan impian keluarga Anda memiliki hunian nyaman, aman, dan strategis dengan harga terbaik.
            </p>
            <div className="flex space-x-4">
              <a href="#" className="text-gray-400 hover:text-[#C9A84C] transition-colors">
                <span className="sr-only">Facebook</span>
                <Facebook className="h-5 w-5" />
              </a>
              <a href="#" className="text-gray-400 hover:text-[#C9A84C] transition-colors">
                <span className="sr-only">Instagram</span>
                <Instagram className="h-5 w-5" />
              </a>
              <a href="#" className="text-gray-400 hover:text-[#C9A84C] transition-colors">
                <span className="sr-only">Twitter</span>
                <Twitter className="h-5 w-5" />
              </a>
            </div>
          </div>

          {/* Navigation */}
          <div>
            <h3 className="text-white font-bold font-['Plus_Jakarta_Sans'] mb-4 tracking-wider uppercase text-sm">Navigasi</h3>
            <ul className="space-y-3">
              <li><a href="#beranda" className="text-gray-400 hover:text-white transition-colors text-sm font-['Plus_Jakarta_Sans']">Beranda</a></li>
              <li><a href="#tentang" className="text-gray-400 hover:text-white transition-colors text-sm font-['Plus_Jakarta_Sans']">Tentang Kami</a></li>
              <li><a href="#tipe-rumah" className="text-gray-400 hover:text-white transition-colors text-sm font-['Plus_Jakarta_Sans']">Tipe Rumah</a></li>
              <li><a href="#kavling" className="text-gray-400 hover:text-white transition-colors text-sm font-['Plus_Jakarta_Sans']">Ketersediaan Kavling</a></li>
              <li><a href="#galeri" className="text-gray-400 hover:text-white transition-colors text-sm font-['Plus_Jakarta_Sans']">Galeri</a></li>
            </ul>
          </div>

          {/* Contact */}
          <div className="lg:col-span-2">
            <h3 className="text-white font-bold font-['Plus_Jakarta_Sans'] mb-4 tracking-wider uppercase text-sm">Kontak Kami</h3>
            <ul className="space-y-4">
              <li className="flex items-start gap-3 text-gray-400 text-sm font-['Plus_Jakarta_Sans']">
                <MapPin className="h-5 w-5 text-[#C9A84C] shrink-0 mt-0.5" />
                <span>Jl. Raya Probolinggo No. 123, Kecamatan Kanigaran, Kota Probolinggo, Jawa Timur 67211</span>
              </li>
              <li className="flex items-center gap-3 text-gray-400 text-sm font-['Plus_Jakarta_Sans']">
                <Phone className="h-5 w-5 text-[#C9A84C] shrink-0" />
                <span>+62 812 3456 7890</span>
              </li>
              <li className="flex items-center gap-3 text-gray-400 text-sm font-['Plus_Jakarta_Sans']">
                <Mail className="h-5 w-5 text-[#C9A84C] shrink-0" />
                <span>halo@arkanaproperty.com</span>
              </li>
            </ul>
          </div>
        </div>

        {/* Bottom Bar */}
        <div className="border-t border-white/10 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center gap-4">
          <p className="text-gray-500 text-sm font-['Plus_Jakarta_Sans']">
            &copy; {new Date().getFullYear()} Arkanaproperty. Hak cipta dilindungi.
          </p>
          <div className="flex gap-4">
            <Link to="/admin" className="text-gray-500 hover:text-white text-xs font-['Plus_Jakarta_Sans'] transition-colors">Admin Login</Link>
            <Link to="/portal" className="text-gray-500 hover:text-white text-xs font-['Plus_Jakarta_Sans'] transition-colors">Portal Penghuni</Link>
          </div>
        </div>
      </div>
    </footer>
  );
}
