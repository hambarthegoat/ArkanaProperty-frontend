import { useState } from 'react';
import { useNavigate } from 'react-router';
import { 
  Home, Building, Grid, Image as ImageIcon, Users, 
  UserCheck, Megaphone, AlertCircle, Bell, LogOut, Menu, X 
} from 'lucide-react';

import { DashboardView } from './admin/DashboardView';
import { TipeRumahView } from './admin/TipeRumahView';
import { KavlingView } from './admin/KavlingView';
import { GaleriView } from './admin/GaleriView';
import { LeadsView } from './admin/LeadsView';
import { ResidentView } from './admin/ResidentView';
import { PengumumanView } from './admin/PengumumanView';
import { PengaduanView } from './admin/PengaduanView';

export function AdminPanel() {
  const [activeTab, setActiveTab] = useState('dashboard');
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);
  const navigate = useNavigate();

  const navItems = [
    { id: 'dashboard', label: 'Dashboard', icon: Home },
    { id: 'tipe-rumah', label: 'Tipe Rumah', icon: Building },
    { id: 'kavling', label: 'Kavling', icon: Grid },
    { id: 'galeri', label: 'Galeri', icon: ImageIcon },
    { id: 'leads', label: 'Leads', icon: Users },
    { id: 'resident', label: 'Akun Resident', icon: UserCheck },
    { id: 'pengumuman', label: 'Pengumuman', icon: Megaphone },
    { id: 'pengaduan', label: 'Pengaduan', icon: AlertCircle },
  ];

  const handleLogout = () => {
    navigate('/login');
  };

  const renderActiveView = () => {
    switch (activeTab) {
      case 'dashboard': return <DashboardView />;
      case 'tipe-rumah': return <TipeRumahView />;
      case 'kavling': return <KavlingView />;
      case 'galeri': return <GaleriView />;
      case 'leads': return <LeadsView />;
      case 'resident': return <ResidentView />;
      case 'pengumuman': return <PengumumanView />;
      case 'pengaduan': return <PengaduanView />;
      default: return <DashboardView />;
    }
  };

  const activeLabel = navItems.find(item => item.id === activeTab)?.label || 'Dashboard';

  return (
    <div className="flex h-screen bg-[#F8F9FA] font-['Plus_Jakarta_Sans']">
      
      {/* Mobile Sidebar Overlay */}
      {isSidebarOpen && (
        <div 
          className="fixed inset-0 bg-black/50 z-40 lg:hidden"
          onClick={() => setIsSidebarOpen(false)}
        />
      )}

      {/* Sidebar */}
      <aside 
        className={`fixed lg:static inset-y-0 left-0 z-50 w-64 bg-[#1A3C5E] text-white flex flex-col transition-transform duration-300 ease-in-out ${
          isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        }`}
      >
        <div className="h-20 flex items-center justify-between px-6 border-b border-white/10 shrink-0">
          <div className="flex items-center gap-2">
            <Building className="w-8 h-8 text-[#C9A84C]" />
            <div>
              <span className="font-extrabold text-2xl tracking-tight">
                Arkana<span className="text-[#C9A84C]">property</span>
              </span>
              <span className="block text-[10px] uppercase tracking-widest text-[#A3B8CC] font-bold">Admin Panel</span>
            </div>
          </div>
          {/* Mobile close button */}
          <button 
            onClick={() => setIsSidebarOpen(false)}
            className="lg:hidden p-2 -mr-2 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-colors"
          >
            <X className="w-5 h-5" />
          </button>
        </div>

        <nav className="flex-1 overflow-y-auto py-6 px-4 space-y-1">
          {navItems.map((item) => {
            const Icon = item.icon;
            const isActive = activeTab === item.id;
            return (
              <button
                key={item.id}
                onClick={() => {
                  setActiveTab(item.id);
                  setIsSidebarOpen(false);
                }}
                className={`w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all font-medium text-sm ${
                  isActive 
                    ? 'bg-white/10 text-white border-l-4 border-[#C9A84C]' 
                    : 'text-[#A3B8CC] hover:bg-white/5 hover:text-white border-l-4 border-transparent'
                }`}
              >
                <Icon className={`w-5 h-5 ${isActive ? 'text-[#C9A84C]' : ''}`} />
                {item.label}
              </button>
            );
          })}
        </nav>

        <div className="p-4 border-t border-white/10 shrink-0">
          <div className="bg-[#112840] rounded-xl p-3 flex flex-col gap-3">
            <div className="flex items-center gap-3">
              <div className="w-10 h-10 bg-[#C9A84C] rounded-lg flex items-center justify-center font-bold text-[#1A3C5E] text-sm shrink-0">
                AD
              </div>
              <div className="text-left overflow-hidden">
                <p className="text-sm font-bold text-white leading-tight truncate">Admin Utama</p>
                <p className="text-[11px] text-[#A3B8CC] truncate mt-0.5">admin@arkanaproperty.id</p>
              </div>
            </div>
            
            <div className="h-px bg-white/10 w-full"></div>
            
            <button 
              onClick={handleLogout}
              className="flex items-center justify-center gap-2 w-full py-2 px-3 rounded-lg text-rose-400 hover:text-white hover:bg-rose-500/20 transition-all font-medium text-sm border border-transparent hover:border-rose-500/30"
            >
              <LogOut className="w-4 h-4" />
              Keluar Akun
            </button>
          </div>
        </div>
      </aside>

      {/* Main Content Area */}
      <div className="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
        
        {/* Header Bar */}
        <header className="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-6 lg:px-8 shrink-0 shadow-sm relative z-10">
          <div className="flex items-center gap-4">
            <button 
              className="lg:hidden text-gray-500 hover:text-gray-900"
              onClick={() => setIsSidebarOpen(true)}
            >
              <Menu className="w-6 h-6" />
            </button>
            <h1 className="text-2xl font-bold text-[#1A3C5E] hidden sm:block">{activeLabel}</h1>
          </div>

          <div className="flex items-center gap-6">
            <button className="relative text-gray-400 hover:text-gray-600 transition-colors">
              <Bell className="w-6 h-6" />
              <span className="absolute top-0 right-0 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white"></span>
            </button>
            <div className="hidden sm:flex items-center gap-3 pl-6 border-l border-gray-200">
              <div className="text-right">
                <p className="text-sm font-bold text-gray-900 leading-none mb-1">Admin Utama</p>
                <p className="text-xs text-gray-500 font-medium">Developer Role</p>
              </div>
              <div className="w-10 h-10 bg-[#C9A84C]/20 text-[#C9A84C] rounded-full flex items-center justify-center font-bold">
                AD
              </div>
            </div>
          </div>
        </header>

        {/* Dynamic Page Content */}
        <main className="flex-1 overflow-auto p-4 sm:p-6 lg:p-8">
          <div className="max-w-7xl mx-auto h-full pb-8">
            {renderActiveView()}
          </div>
        </main>
      </div>

    </div>
  );
}