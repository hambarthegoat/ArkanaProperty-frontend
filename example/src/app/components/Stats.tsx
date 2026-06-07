export function Stats() {
  const stats = [
    { label: 'Tipe Rumah Tersedia', value: '3' },
    { label: 'Unit Total', value: '120' },
    { label: 'Sejak', value: '2023' },
    { label: 'Lokasi Strategis', value: 'Premium' },
  ];

  return (
    <div id="stats" className="bg-[#EEF3F8] py-12 border-b border-gray-200">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x divide-gray-300/50">
          {stats.map((stat, index) => (
            <div key={index} className="text-center px-4">
              <div className="text-3xl md:text-4xl font-extrabold text-[#C9A84C] font-['Plus_Jakarta_Sans'] mb-2">
                {stat.value}
              </div>
              <div className="text-sm md:text-base font-semibold text-[#1F2937] font-['Plus_Jakarta_Sans'] uppercase tracking-wider">
                {stat.label}
              </div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
