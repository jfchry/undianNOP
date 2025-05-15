<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Undian NOP Pajak</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body class="bg-gray-100 dark:bg-gray-900 min-h-screen flex flex-col items-center p-4 transition-colors duration-500">
  <header class="mb-6 text-center">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Undian NOP Pajak</h1>
    <p class="text-gray-700 dark:text-gray-300 mt-1 text-sm sm:text-base">Sistem Pengundian Nomor Objek Pajak</p>
  </header>

  <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 w-full max-w-xl transition-colors duration-500">
    <div class="mb-4 text-center">
      <p id="displayText" class="text-lg font-semibold text-gray-700 dark:text-gray-300 min-h-[1.5rem] transition-colors duration-500"></p>
    </div>

    <div class="flex flex-col items-center space-y-4 mb-6">
      <div class="text-center">
        <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-500">Nomor Objek Pajak(NOP)</p>
        <p id="winnerNOP" class="text-2xl font-mono font-bold text-indigo-600 dark:text-indigo-400 transition-colors duration-500">-</p>
      </div>
      <div class="text-center">
        <p class="text-sm text-gray-500 dark:text-gray-400 transition-colors duration-500">Name</p>
        <p id="winnerName" class="text-2xl font-semibold text-indigo-600 dark:text-indigo-400 transition-colors duration-500">-</p>
      </div>
    </div>

    <div class="flex justify-center space-x-4 mb-6">
      <button id="startDraw" class="bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white font-semibold py-2 px-6 rounded transition">
        <i class="fas fa-play mr-2"></i> Start Draw
      </button>
      <button id="resetDraw" class="bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white font-semibold py-2 px-6 rounded transition">
        <i class="fas fa-redo-alt mr-2"></i> Reset
      </button>
    </div>

    <div class="overflow-x-auto">
      <table id="winnersTable" class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md transition-colors duration-500">
        <thead class="bg-indigo-100 dark:bg-indigo-900">
          <tr>
            <th class="py-3 px-3 border-b border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-indigo-700 dark:text-indigo-300">#</th>
            <th class="py-3 px-3 border-b border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-indigo-700 dark:text-indigo-300">NOP</th>
            <th class="py-3 px-3 border-b border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-indigo-700 dark:text-indigo-300">Name</th>
            <th class="py-3 px-3 border-b border-gray-300 dark:border-gray-600 text-left text-sm font-semibold text-indigo-700 dark:text-indigo-300">Time</th>
          </tr>
        </thead>
        <tbody class="text-gray-700 dark:text-gray-300 transition-colors duration-500">
          <tr><td class="py-3 px-3 text-center" colspan="4">Belum ada pemenang</td></tr>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const participants = [
        { nop: '12345', name: 'John Doe' },
        { nop: '67890', name: 'Jane Smith' },
        { nop: '54321', name: 'Alice Johnson' },
        { nop: '98765', name: 'Bob Brown' }
      ];

      const winnerNOP = document.getElementById('winnerNOP');
      const winnerName = document.getElementById('winnerName');
      const displayText = document.getElementById('displayText');
      const winnersTableBody = document.querySelector('#winnersTable tbody');
      const startButton = document.getElementById('startDraw');
      const resetButton = document.getElementById('resetDraw');

      let winnerCount = 0;
      let spinning = false;

      function triggerConfetti() {
        const confettiContainer = document.createElement('div');
        confettiContainer.style.position = 'fixed';
        confettiContainer.style.top = '0';
        confettiContainer.style.left = '0';
        confettiContainer.style.width = '100vw';
        confettiContainer.style.height = '100vh';
        confettiContainer.style.pointerEvents = 'none';
        confettiContainer.style.zIndex = '9999';
        document.body.appendChild(confettiContainer);

        const emojis = ['🎉', '✨', '🎊', '💥', '🌟'];
        const confettiCount = 100;

        for (let i = 0; i < confettiCount; i++) {
          const confetti = document.createElement('div');
          confetti.textContent = emojis[Math.floor(Math.random() * emojis.length)];
          confetti.style.position = 'absolute';
          confetti.style.fontSize = `${Math.floor(Math.random() * 20) + 10}px`;
          confetti.style.left = `${Math.random() * 100}vw`;
          confetti.style.top = `-2rem`;
          confetti.style.opacity = Math.random();
          confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
          confettiContainer.appendChild(confetti);

          const fallDuration = Math.random() * 3000 + 2000;

          confetti.animate([
            { transform: confetti.style.transform, top: '-2rem', opacity: confetti.style.opacity },
            { transform: `rotate(${Math.random() * 360}deg)`, top: '100vh', opacity: 0 }
          ], {
            duration: fallDuration,
            easing: 'ease-out',
            fill: 'forwards',
            delay: Math.random() * 1000
          });
        }

        setTimeout(() => {
          document.body.removeChild(confettiContainer);
        }, 6000);
      }

      function addWinnerToTable(nop, name) {
        winnerCount++;
        if (winnersTableBody.children.length === 1 && winnersTableBody.children[0].children.length === 1) {
          winnersTableBody.innerHTML = '';
        }

        const row = document.createElement('tr');
        row.classList.add('border-t', 'border-gray-200', 'dark:border-gray-600');

        const cellIndex = document.createElement('td');
        cellIndex.className = 'py-3 px-3 text-center';
        cellIndex.textContent = winnerCount;

        const cellNOP = document.createElement('td');
        cellNOP.className = 'py-3 px-3';
        cellNOP.textContent = nop;

        const cellName = document.createElement('td');
        cellName.className = 'py-3 px-3';
        cellName.textContent = name;

        const cellTime = document.createElement('td');
        cellTime.className = 'py-3 px-3';
        cellTime.textContent = new Date().toLocaleString();

        row.appendChild(cellIndex);
        row.appendChild(cellNOP);
        row.appendChild(cellName);
        row.appendChild(cellTime);

        winnersTableBody.appendChild(row);
      }

      function spin() {
        if (spinning) return;
        if (participants.length === 0) {
          displayText.textContent = "Data peserta kosong!";
          return;
        }

        spinning = true;
        let count = 0;
        let lastPicked = { nop: '', name: '' };

        const intervalId = setInterval(() => {
          lastPicked = participants[Math.floor(Math.random() * participants.length)];

          winnerNOP.textContent = lastPicked.nop;
          winnerName.textContent = lastPicked.name;
          displayText.textContent = `Sedang mengundi... ${lastPicked.name}`;

          count++;
          if (count >= 30) {
            clearInterval(intervalId);

            winnerNOP.textContent = lastPicked.nop;
            winnerName.textContent = lastPicked.name;
            displayText.textContent = `🎉 Pemenangnya adalah: ${lastPicked.name} (${lastPicked.nop})`;

            triggerConfetti();
            addWinnerToTable(lastPicked.nop, lastPicked.name);

            setTimeout(() => {
              winnerNOP.textContent = '-';
              winnerName.textContent = '-';
              displayText.textContent = '';
              spinning = false;
            }, 2000);
          }
        }, 100);
      }

      startButton.addEventListener('click', spin);

      resetButton.addEventListener('click', () => {
        winnersTableBody.innerHTML = '<tr><td class="py-3 px-3 text-center" colspan="4">Belum ada pemenang</td></tr>';
        winnerCount = 0;
        winnerNOP.textContent = '-';
        winnerName.textContent = '-';
        displayText.textContent = '';
        spinning = false;
      });

      if(window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches){
        document.documentElement.classList.add('dark');
      }
    });
  </script>
</body>
</html>
