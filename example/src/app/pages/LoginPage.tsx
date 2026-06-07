import { useNavigate } from "react-router";
import { ImageWithFallback } from "../components/figma/ImageWithFallback";
import { motion } from "motion/react";
import { LogIn, ArrowRight } from "lucide-react";
import { useEffect, useState } from "react";

export function LoginPage() {
  const navigate = useNavigate();
  const [bgImage, setBgImage] = useState("");

  const roles = [
    { id: "admin", label: "Panel Admin", path: "/admin", description: "Kelola data, leads & marketing", color: "bg-slate-900" },
    { id: "marketing", label: "Dashboard Marketing", path: "/marketing", description: "Kelola leads & laporan harian", color: "bg-emerald-600" },
    { id: "user", label: "Portal Penghuni", path: "/portal", description: "Pantau progres unit Anda", color: "bg-accent" },
  ];

  return (
    <div className="flex min-h-screen bg-surface-soft font-sans">
      {/* Left side: Form/Navigation */}
      <div className="w-full lg:w-1/2 flex items-center justify-center p-8 lg:p-20">
        <motion.div 
          initial={{ opacity: 0, x: -20 }}
          animate={{ opacity: 1, x: 0 }}
          className="max-w-md w-full"
        >
          <div className="mb-12">
            <h1 className="text-4xl font-black text-primary mb-2">
              Arkana<span className="text-accent">Property</span>
            </h1>
            <p className="text-primary/60">Selamat datang kembali. Silakan pilih akses masuk Anda untuk melanjutkan.</p>
          </div>

          <div className="space-y-4">
            {roles.map((role) => (
              <button
                key={role.id}
                onClick={() => navigate(role.path)}
                className="group w-full flex items-center justify-between p-6 bg-white border border-border-subtle rounded-2xl hover:border-accent hover:shadow-xl hover:shadow-accent/5 transition-all text-left"
              >
                <div>
                  <h3 className="font-bold text-lg text-primary group-hover:text-accent transition-colors">{role.label}</h3>
                  <p className="text-sm text-primary/60">{role.description}</p>
                </div>
                <div className="w-10 h-10 rounded-full bg-surface-soft flex items-center justify-center group-hover:bg-accent group-hover:text-white transition-all">
                  <ArrowRight size={20} />
                </div>
              </button>
            ))}
          </div>

          <div className="mt-12 pt-8 border-t border-border-subtle text-center">
            <p className="text-sm text-primary/40">
              Butuh bantuan akses? Hubungi Admin IT Kami
            </p>
          </div>
        </motion.div>
      </div>

      {/* Right side: Visual */}
      <div className="hidden lg:block lg:w-1/2 bg-primary relative overflow-hidden">
        <div className="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070')] bg-cover bg-center opacity-40 mix-blend-overlay"></div>
        <div className="absolute inset-0 bg-gradient-to-tr from-primary via-transparent to-transparent"></div>
        
        <div className="absolute bottom-20 left-20 right-20">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.5 }}
          >
            <h2 className="text-4xl font-bold text-white mb-4 italic">"Rumah bukan hanya sekadar tempat tinggal, tapi investasi masa depan."</h2>
            <div className="flex items-center gap-4 text-white/60">
              <div className="w-12 h-[2px] bg-accent"></div>
              <span>Arkanaproperty Team</span>
            </div>
          </motion.div>
        </div>
      </div>
    </div>
  );
}
