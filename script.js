function updateClock() {
    const now = new Date();
    const hours = now.getHours().toString().padStart(2, '0');
    const minutes = now.getMinutes().toString().padStart(2, '0');
    const seconds = now.getSeconds().toString().padStart(2, '0');
    const timeString = `${hours}:${minutes}:${seconds}`;
    document.getElementById('clock').textContent = timeString;
  }

  setInterval(updateClock, 1000);

  document.getElementById('clock').addEventListener('click', function() {
    const clock = document.getElementById('clock');
    const currentFormat = clock.dataset.format;
    if (currentFormat === '12') {
      clock.dataset.format = '24';
    } else {
      clock.dataset.format = '12';
    }
    updateClock();
  });

  updateClock();


const navLinks = document.querySelector('.nav-links');
        
  function onToggleMenu(e) {
      e.name = e.name === 'menu' ? 'close' : 'menu';
      navLinks.classList.toggle('top-[10%]');    
  }

