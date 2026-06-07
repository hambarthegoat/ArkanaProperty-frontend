import { motion } from 'motion/react';
import { useState, useEffect } from 'react';

// Generates dummy data for kavling blocks
const generateKavlings = () => {
  const blocks = ['A', 'B', 'C', 'D'];
  const data = [];
  
  for (let i = 0; i < blocks.length; i++) {
    for (let j = 1; j <= 12; j++) {
      // Randomly assign statuses
      const rand = Math.random();
      let status = 'Tersedia';
      if (rand > 0.7) status = 'Terjual';
      else if (rand > 0.5) status = 'Indent';
      
      data.push({
        id: `${blocks[i]}-${j.toString().padStart(2, '0')}`,
        block: blocks[i],
        number: j,
        status,
      });
    }
  }
  return data;
};

export function Kavling() {
  const [kavlings, setKavlings] = useState<any[]>([]);
  const [counts, setCounts] = useState({ tersedia: 0, total: 0 });

  useEffect(() => {
    const data = generateKavlings();
    setKavlings(data);
    
    const tersediaCount = data.filter(k => k.status === 'Tersedia').length;
    setCounts({ tersedia: tersediaCount, total: data.length });
  }, []);

  const getStatusColor = (status: string) => {
    switch(status) {
      case 'Tersedia': return 'bg-[#0F6E56] hover:bg-[#0c5945]';
      case 'Indent': return 'bg-yellow-500 hover:bg-yellow-600';
      case 'Terjual': return 'bg-red-500 cursor-not-allowed';
      default: return 'bg-gray-300';
    }
  };

  return (
    <div id="kavling" className="py-24 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl font-extrabold text-[#1A3C5E] sm:text-4xl font-['Plus_Jakarta_Sans']">
            Ketersediaan Kavling
          </h2>
          <p className="mt-4 text-xl text-[#6B7280] font-['Plus_Jakarta_Sans']">
            Pilih lokasi kavling impian Anda sebelum kehabisan
          </p>
        </div>

        {/* Legend */}
        <div className="flex justify-center items-center gap-6 mb-12 flex-wrap">
          <div className="flex items-center gap-2">
            <div className="w-5 h-5 rounded-md bg-[#0F6E56]"></div>
            <span className="text-sm font-medium text-[#1F2937] font-['Plus_Jakarta_Sans']">Tersedia</span>
          </div>
          <div className="flex items-center gap-2">
            <div className="w-5 h-5 rounded-md bg-yellow-500"></div>
            <span className="text-sm font-medium text-[#1F2937] font-['Plus_Jakarta_Sans']">Indent</span>
          </div>
          <div className="flex items-center gap-2">
            <div className="w-5 h-5 rounded-md bg-red-500"></div>
            <span className="text-sm font-medium text-[#1F2937] font-['Plus_Jakarta_Sans']">Terjual</span>
          </div>
        </div>

        {/* Grid */}
        <motion.div 
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8 }}
          className="bg-gray-50 p-8 rounded-2xl border border-gray-100"
        >
          <div className="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-12 gap-3">
            {kavlings.map((kavling) => (
              <div 
                key={kavling.id}
                title={`${kavling.id} - ${kavling.status}`}
                className={`
                  aspect-square flex items-center justify-center rounded-lg text-white font-bold text-xs sm:text-sm shadow-sm transition-all duration-200 cursor-pointer
                  ${getStatusColor(kavling.status)}
                `}
              >
                {kavling.id}
              </div>
            ))}
          </div>
        </motion.div>

        {/* Summary */}
        <div className="mt-12 text-center">
          <p className="text-lg font-semibold text-[#1A3C5E] font-['Plus_Jakarta_Sans'] bg-[#1A3C5E]/5 inline-block px-6 py-3 rounded-xl border border-[#1A3C5E]/10">
            <span className="text-[#0F6E56] font-bold">{counts.tersedia} unit tersedia</span> dari {counts.total} unit total
          </p>
        </div>
      </div>
    </div>
  );
}
