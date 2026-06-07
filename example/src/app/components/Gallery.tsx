import { motion } from 'motion/react';
import Masonry, { ResponsiveMasonry } from 'react-responsive-masonry';

const galleryImages = [
  'https://images.unsplash.com/photo-1768832034516-e019de2cf44f?q=80&w=600&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1648147870253-c45f6f430528?q=80&w=600&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1766603636562-531bb3e1dda8?q=80&w=600&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1623674043631-af1a3c94e707?q=80&w=600&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1766603636562-531bb3e1dda8?q=80&w=600&auto=format&fit=crop',
  'https://images.unsplash.com/photo-1648147870253-c45f6f430528?q=80&w=600&auto=format&fit=crop',
];

export function Gallery() {
  return (
    <div id="galeri" className="py-24 bg-[#F8F9FA]">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-3xl mx-auto mb-16">
          <h2 className="text-3xl font-extrabold text-[#1A3C5E] sm:text-4xl font-['Plus_Jakarta_Sans']">
            Galeri Kawasan
          </h2>
          <p className="mt-4 text-xl text-[#6B7280] font-['Plus_Jakarta_Sans']">
            Intip suasana dan keindahan lingkungan Arkanaproperty
          </p>
        </div>

        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 0.8 }}
        >
          <ResponsiveMasonry
            columnsCountBreakPoints={{ 350: 1, 750: 2, 900: 3 }}
          >
            <Masonry gutter="16px">
              {galleryImages.map((image, i) => (
                <div key={i} className="overflow-hidden rounded-2xl group cursor-pointer relative shadow-sm hover:shadow-xl transition-shadow duration-300">
                  <img
                    src={image}
                    className="w-full block transform group-hover:scale-110 transition-transform duration-700 ease-in-out"
                    alt={`Galeri ${i + 1}`}
                  />
                  <div className="absolute inset-0 bg-[#1A3C5E]/0 group-hover:bg-[#1A3C5E]/20 transition-colors duration-300"></div>
                </div>
              ))}
            </Masonry>
          </ResponsiveMasonry>
        </motion.div>
      </div>
    </div>
  );
}
