import { Outlet, Link, useLocation, useNavigate } from "react-router";
import { 
  LayoutDashboard, 
  Home, 
  Users, 
  FileText, 
  Settings, 
  LogOut, 
  Menu, 
  Bell,
  Calendar,
  MessageSquare,
  ClipboardList
} from "lucide-react";
import { useState } from "react";

interface DashboardLayoutProps {
  role: "admin" | "marketing" | "user";
}

export function DashboardLayout({ role }: DashboardLayoutProps) {
  const [isSidebarOpen, setSidebarOpen] = useState(true);
  const location = useLocation();
  const navigate = useNavigate();

  const menuItems = {
    admin: [
      { path: "/admin", icon: LayoutDashboard, label: "Dashboard" },
      { path: "/admin/perumahan", icon: Home, label: "Kelola Perumahan" },
      { path: "/admin/kavling", icon: ClipboardList, label: "Kelola Kavling" },
      { path: "/admin/leads", icon: Users, label: "Data Leads" },
      { path: "/admin/reports", icon: FileText, label: "Report Marketing" },
    ],
    marketing: [
      { path: "/marketing", icon: LayoutDashboard, label: "Leads Saya" },
      { path: "/marketing/calendar", icon: Calendar, label: "Jadwal/Kalender" },
      { path: "/marketing/reports", icon: FileText, label: "Report Harian" },
    ],
    user: [
      { path: "/portal", icon: LayoutDashboard, label: "Dashboard" },
      { path: "/portal/reminders", icon: Bell, label: "Timeline" },
      { path: "/portal/support", icon: MessageSquare, label: "Bantuan" },
    ],
  };

  const currentMenu = menuItems[role];

  return (
    <div className="flex h-screen bg-surface-soft overflow-hidden text-sm">
      {/* Sidebar */}
      <aside 
        className={`${
          isSidebarOpen ? "w-64" : "w-20"
        } bg-primary text-white transition-all duration-300 flex flex-col z-50`}
      >
        <div className="p-6 flex items-center gap-3">
          <div className="w-8 h-8 bg-accent rounded-lg shrink-0 flex items-center justify-center font-bold text-white">A</div>
          {isSidebarOpen && <span className="font-bold tracking-tight text-lg">ARKANA PANEL</span>}
        </div>

        <nav className="flex-grow mt-6 px-3 space-y-2">
          {currentMenu.map((item) => {
            const isActive = location.pathname === item.path;
            return (
              <Link
                key={item.path}
                to={item.path}
                className={`flex items-center gap-3 p-3 rounded-xl transition-all ${
                  isActive 
                    ? "bg-accent text-white" 
                    : "text-white/60 hover:bg-white/10 hover:text-white"
                }`}
              >
                <item.icon size={20} />
                {isSidebarOpen && <span>{item.label}</span>}
              </Link>
            );
          })}
        </nav>

        <div className="p-4 border-t border-white/10">
          <button 
            onClick={() => navigate("/")}
            className="flex items-center gap-3 p-3 w-full text-white/60 hover:text-white transition-colors"
          >
            <LogOut size={20} />
            {isSidebarOpen && <span>Keluar</span>}
          </button>
        </div>
      </aside>

      {/* Main Content */}
      <div className="flex-grow flex flex-col min-w-0">
        <header className="h-16 bg-white border-b border-border-subtle flex items-center justify-between px-6 shrink-0">
          <button onClick={() => setSidebarOpen(!isSidebarOpen)} className="p-2 hover:bg-surface-soft rounded-lg">
            <Menu size={20} />
          </button>
          
          <div className="flex items-center gap-4">
            <button className="p-2 hover:bg-surface-soft rounded-full relative">
              <Bell size={20} />
              <span className="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <div className="flex items-center gap-3 pl-4 border-l border-border-subtle">
              <div className="text-right hidden sm:block">
                <p className="font-bold text-xs uppercase opacity-50">{role}</p>
                <p className="font-medium">Sistem User</p>
              </div>
              <div className="w-10 h-10 bg-surface-soft rounded-full border border-border-subtle overflow-hidden">
                <img src={`https://api.dicebear.com/7.x/avataaars/svg?seed=${role}`} alt="Avatar" />
              </div>
            </div>
          </div>
        </header>

        <main className="flex-grow overflow-y-auto p-6 lg:p-10">
          <Outlet />
        </main>
      </div>
    </div>
  );
}
