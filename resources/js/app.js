import './bootstrap'; // jika ada bootstrap.js dari Laravel
import Alpine from 'alpinejs';
window.Alpine = Alpine;

function layout() {
  return {
    sidebarOpen: window.innerWidth >= 768, // default: desktop = open
    darkMode: localStorage.getItem('darkMode') === 'true',

    init() {
      // init dark mode
      if (this.darkMode) document.documentElement.classList.add('dark');
      else document.documentElement.classList.remove('dark');

      // keep responsive state on resize
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) this.sidebarOpen = true;
      });
    },

    toggleDarkMode() {
      this.darkMode = !this.darkMode;
      if (this.darkMode) document.documentElement.classList.add('dark');
      else document.documentElement.classList.remove('dark');
      localStorage.setItem('darkMode', this.darkMode);
    }
  };
}

window.layout = layout;

Alpine.start();
