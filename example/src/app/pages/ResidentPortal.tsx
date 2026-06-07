import { useState } from 'react';
import { useNavigate } from 'react-router';
import { 
  Home, AlertCircle, Bell, LogOut, Menu, X, Building 
} from 'lucide-react';

import { DashboardView } from './resident/DashboardView';
import { PengaduanView } from './resident/PengaduanView';
import { PengumumanView } from './resident/PengumumanView';

export function ResidentPortal() {
  const [activeTab, setActiveTab] = useState('dashboard');
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);
  const navigate = useNavigate();

  const navItems = [
    { id: 'dashboard', label: 'Dashboard', icon: Home },
    { id: 'pengaduan', label: 'Pengaduan Saya', icon: AlertCircle },
    { id: 'pengumuman', label: 'Pengumuman', icon: Bell },
  ];

  const handleLogout = () => {
    navigate('/login');
  };

  const renderActiveView = () => {
    switch (activeTab) {
      case 'dashboard': return <DashboardView />;
      case 'pengaduan': return <PengaduanView />;
      case 'pengumuman': return <PengumumanView />;
      default: return <DashboardView />;
    }
  };

  const activeLabel = navItems.find(item => item.id === activeTab)?.label || 'Dashboard';

  return (
    <div className="flex h-screen bg-[#F8F9FA] font-['Plus_Jakarta_Sans']">
      
      {/* Mobile Sidebar Overlay */}
      {isSidebarOpen && (
        <div 
          className="fixed inset-0 bg-[#1A3C5E]/40 backdrop-blur-sm z-40 lg:hidden transition-opacity"
          onClick={() => setIsSidebarOpen(false)}
        />
      )}

      {/* Sidebar - Lighter theme for resident */}
      <aside 
        className={`fixed lg:static inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-200 text-[#1A3C5E] flex flex-col transition-transform duration-300 ease-in-out shadow-xl lg:shadow-none ${
          isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
        }`}
      >
        <div className="h-20 flex items-center justify-between px-6 border-b border-gray-100 shrink-0">
          <div className="flex items-center gap-2">
            <div className="p-1.5 bg-[#1A3C5E] rounded-lg">
              <Building className="w-6 h-6 text-[#C9A84C]" />
            </div>
            <div>
              <span className="font-extrabold text-2xl tracking-tight text-[#1A3C5E]">
                Arkana<span className="text-[#C9A84C]">property</span>
              </span>
              <span className="inline-block ml-2 px-2 py-0.5 bg-[#C9A84C]/10 text-[#C9A84C] text-[10px] font-bold uppercase tracking-wider rounded-md align-middle border border-[#C9A84C]/20">
                Resident
              </span>
            </div>
          </div>
          {/* Mobile close button */}
          <button className="lg:hidden text-gray-400 hover:text-gray-900 bg-gray-50 rounded-lg p-2 transition-colors" onClick={() => setIsSidebarOpen(false)}>
            <X className="w-5 h-5" />
          </button>
        </div>

        <nav className="flex-1 overflow-y-auto py-6 px-4 space-y-1.5">
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
                className={`w-full flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all font-semibold text-sm ${
                  isActive 
                    ? 'bg-[#F4F7F9] text-[#1A3C5E] shadow-sm ring-1 ring-gray-200/50' 
                    : 'text-gray-500 hover:bg-gray-50 hover:text-[#1A3C5E]'
                }`}
              >
                {/* Active Indicator Line */}
                {isActive && (
                  <div className="absolute left-4 w-1 h-5 bg-[#C9A84C] rounded-full"></div>
                )}
                <Icon className={`w-5 h-5 ml-1 ${isActive ? 'text-[#C9A84C]' : 'text-gray-400'}`} />
                {item.label}
              </button>
            );
          })}
        </nav>

        {/* Resident Unit Info at bottom */}
        <div className="p-4 border-t border-gray-100 shrink-0">
          <div className="bg-gray-50 rounded-2xl p-4 border border-gray-200 shadow-sm">
            <div className="flex items-center justify-between mb-4 pb-4 border-b border-gray-200/60">
              <div className="flex items-center gap-3">
                <div className="w-10 h-10 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center font-bold text-[#1A3C5E] text-sm">
                  BS
                </div>
                <div className="text-left">
                  <p className="text-sm font-bold text-[#1A3C5E] leading-tight">Budi Santoso</p>
                  <p className="text-xs text-gray-500 font-medium mt-0.5">Blok A-07 • Tipe 45</p>
                </div>
              </div>
            </div>
            <button 
              onClick={handleLogout}
              className="w-full flex items-center justify-center gap-2 text-sm font-semibold text-gray-500 hover:text-rose-600 transition-colors py-2 rounded-lg hover:bg-rose-50"
            >
              <LogOut className="w-4 h-4" /> Keluar Akun
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
              className="lg:hidden p-2 text-gray-500 hover:text-[#1A3C5E] hover:bg-gray-50 rounded-lg transition-colors"
              onClick={() => setIsSidebarOpen(true)}
            >
              <Menu className="w-6 h-6" />
            </button>
            <h1 className="text-2xl font-bold text-[#1A3C5E] hidden sm:block">{activeLabel}</h1>
          </div>

          <div className="flex items-center gap-5">
            <button className="relative p-2 text-gray-400 hover:text-[#C9A84C] hover:bg-[#C9A84C]/10 rounded-full transition-all">
              <Bell className="w-6 h-6" />
              <span className="absolute top-2 right-2.5 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white"></span>
            </button>
            <div className="hidden sm:flex items-center gap-3 pl-5 border-l border-gray-200">
              <div className="text-right">
                <p className="text-sm font-bold text-[#1A3C5E] leading-none mb-1">Budi Santoso</p>
                <p className="text-xs text-[#C9A84C] font-bold tracking-wide uppercase">Penghuni</p>
              </div>
              <div className="w-10 h-10 bg-[#1A3C5E] text-white shadow-md rounded-full flex items-center justify-center font-bold border-2 border-white">
                BS
              </div>
            </div>
          </div>
        </header>

        {/* Dynamic Page Content */}
        <main className="flex-1 overflow-auto p-4 sm:p-6 lg:p-8">
          <div className="max-w-5xl mx-auto h-full pb-8 animate-in fade-in duration-300">
            {renderActiveView()}
          </div>
        </main>
      </div>

    </div>
  );
}