import { motion } from 'motion/react';
import { Send } from 'lucide-react';

export function Contact() {
  return (
    <div id="kontak" className="py-24 bg-[#1A3C5E]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl font-extrabold text-white sm:text-4xl font-['Plus_Jakarta_Sans']">
            Tertarik? Hubungi Kami Sekarang
          </h2>
          <p className="mt-4 text-xl text-gray-300 font-['Plus_Jakarta_Sans']">
            Isi form berikut dan tim kami akan segera menghubungi Anda
          </p>
        </div>

        <motion.div 
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8 }}
          className="max-w-2xl mx-auto"
        >
          <div className="bg-white rounded-2xl shadow-2xl p-8 md:p-12">
            <form className="space-y-6">
              <div>
                <label htmlFor="name" className="block text-sm font-medium text-[#1F2937] font-['Plus_Jakarta_Sans'] mb-2">
                  Nama Lengkap
                </label>
                <input
                  type="text"
                  name="name"
                  id="name"
                  className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#1A3C5E] focus:border-[#1A3C5E] transition-colors font-['Plus_Jakarta_Sans']"
                  placeholder="Masukkan nama lengkap"
                  required
                />
              </div>

              <div>
                <label htmlFor="phone" className="block text-sm font-medium text-[#1F2937] font-['Plus_Jakarta_Sans'] mb-2">
                  Nomor Handphone
                </label>
                <input
                  type="tel"
                  name="phone"
                  id="phone"
                  className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#1A3C5E] focus:border-[#1A3C5E] transition-colors font-['Plus_Jakarta_Sans']"
                  placeholder="08xxxxxxxxxx"
                  required
                />
              </div>

              <div>
                <label htmlFor="type" className="block text-sm font-medium text-[#1F2937] font-['Plus_Jakarta_Sans'] mb-2">
                  Tipe Rumah yang Diminati
                </label>
                <select
                  id="type"
                  name="type"
                  className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#1A3C5E] focus:border-[#1A3C5E] transition-colors font-['Plus_Jakarta_Sans'] bg-white text-[#1F2937]"
                  required
                  defaultValue=""
                >
                  <option value="" disabled>Pilih tipe rumah</option>
                  <option value="Tipe 36/60">Tipe 36/60</option>
                  <option value="Tipe 45/72">Tipe 45/72</option>
                  <option value="Tipe 72/90">Tipe 72/90</option>
                </select>
              </div>

              <div>
                <label htmlFor="message" className="block text-sm font-medium text-[#1F2937] font-['Plus_Jakarta_Sans'] mb-2">
                  Pesan (Opsional)
                </label>
                <textarea
                  id="message"
                  name="message"
                  rows={4}
                  className="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-[#1A3C5E] focus:border-[#1A3C5E] transition-colors font-['Plus_Jakarta_Sans']"
                  placeholder="Tulis pertanyaan atau pesan Anda..."
                ></textarea>
              </div>

              <div>
                <button
                  type="submit"
                  className="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-lg shadow-md text-lg font-bold text-white bg-[#C9A84C] hover:bg-[#b59640] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#C9A84C] transition-colors font-['Plus_Jakarta_Sans'] group"
                >
                  Kirim Sekarang
                  <Send className="ml-2 w-5 h-5 group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform" />
                </button>
              </div>
            </form>
            
            <div className="mt-6 text-center">
              <p className="text-xs text-[#6B7280] font-['Plus_Jakarta_Sans']">
                *Data Anda aman dan tidak akan disebarluaskan kepada pihak ketiga
              </p>
            </div>
          </div>
        </motion.div>
      </div>
    </div>
  );
}
