document.addEventListener('DOMContentLoaded', () => {
  const startButtons = document.querySelectorAll('.play-button');
  const audioPlayer = document.querySelector('.audio-player');
  const audio = document.querySelector('audio');
  const audioTitle = document.querySelector('.track-title');
  const playPauseBtn = document.querySelector('.play-toggle');
  const skipBtn = document.querySelector('.skip');
  const loopBtn = document.querySelector('.loop');
  const seekBar = document.querySelector('input[name="seekbar"]');
  const time = document.querySelector('.duration');
  const playedTime = document.querySelector('.elapsed-time');
  const songs = Array.from(startButtons).map(button => ({
    id: button.getAttribute('data-id'),
    title: button.getAttribute('data-title')
  }));

  let currentSongIndex = 0;
  let loopMode = 'all';

  function playSong(index) {
    if (index >= 0 && index < songs.length) {
      currentSongIndex = index;
      audio.src = `includes/stream.php?id=${songs[index].id}`;
      audioTitle.textContent = songs[index].title;
      audio.play();
      playPauseBtn.textContent = '||';
    }
  }
  function formatTime(seconds) {
    const min = Math.floor(seconds / 60);
    const sec = Math.floor(seconds % 60);
    return `${min}:${sec.toString().padStart(2, '0')}`;
  }

  startButtons.forEach((button, index) => {
    button.addEventListener('click', () => {
      playSong(index);
      audioPlayer.style.display = 'flex';
    });
  });
  playPauseBtn.addEventListener('click', () => {
    if (audio.paused) {
      audio.play();
      playPauseBtn.textContent = '||';
    } else {
      audio.pause();
      playPauseBtn.textContent = '▶';
    }
  });
  skipBtn.addEventListener('click', () => {
    playSong((currentSongIndex + 1) % songs.length);
  });
  loopBtn.addEventListener('click', () => {
    if (loopMode === 'all') {
      loopMode = 'one';
      loopBtn.textContent = 'OFF';
    } else if (loopMode === 'one') {
      loopMode = 'none';
      loopBtn.textContent = 'ALL';
    } else {
      loopMode = 'all';
      loopBtn.textContent = 'ONE';
    }
  });
  seekBar.addEventListener('input', (e) => {
    audio.currentTime = e.currentTarget.value;
  });
  audio.addEventListener('loadedmetadata', () => {
    time.textContent = formatTime(audio.duration);
    seekBar.setAttribute('max', Math.floor(audio.duration));
  });
  audio.addEventListener('timeupdate', () => {
    const currentTime = audio.currentTime;
    playedTime.textContent = formatTime(currentTime);
    seekBar.value = currentTime;
  });
  audio.addEventListener('ended', () => {
    if (loopMode === 'all') {
      playSong((currentSongIndex + 1) % songs.length);
    } else if (loopMode === 'one') {
      playSong((currentSongIndex));
    } else {
      playPauseBtn.textContent = '▶';
    }
  });
});