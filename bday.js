document.addEventListener('DOMContentLoaded', function() {
    const music = document.getElementById('bg-music');
    const toggle = document.getElementById('music-toggle');
    const downloadBtn = document.getElementById('download-btn');

    // Initialize icon
    if (toggle) {
        toggle.textContent = (music && !music.paused) ? '🔈' : '🔊';
    }

    // Toggle play/pause with proper promise handling
    if (toggle && music) {
        toggle.addEventListener('click', () => {
            if (music.paused) {
                const playPromise = music.play();
                if (playPromise && typeof playPromise.then === 'function') {
                    playPromise.then(() => {
                        toggle.textContent = '🔈';
                        spawnFlowers(12);
                    }).catch((err) => {
                        console.warn('Audio play blocked or failed:', err);
                        // show native controls so user can start playback manually
                        music.controls = true;
                        try { alert('Browser mencegah pemutaran otomatis. Gunakan kontrol audio untuk memutar.'); } catch (e) {}
                    });
                } else {
                    // older browsers
                    toggle.textContent = '🔈';
                }
            } else {
                music.pause();
                toggle.textContent = '🔊';
            }
        });
    }

    // Print / download button
    if (downloadBtn) {
        downloadBtn.addEventListener('click', () => {
            window.print();
        });
    }

    // Help browsers that block autoplay: attempt to play once on first user interaction
    if (music) {
        // try autoplay once on first interaction; if succeeds, spawn flowers
        const tryPlayOnce = () => {
            const p = music.play();
            if (p && typeof p.then === 'function') {
                p.then(()=>{ spawnFlowers(8); }).catch(()=>{});
            }
            document.removeEventListener('click', tryPlayOnce);
        };
        document.addEventListener('click', tryPlayOnce, { once: true });
    }

    // Spawn floating flower emoji elements
    function spawnFlowers(count){
        const flowers = ['🌸','🌺','🌼','💐','🌷'];
        for(let i=0;i<count;i++){
            // staggered spawn: each flower appears a bit later
            setTimeout(()=>{
                const f = document.createElement('div');
                f.className = 'flower';
                f.textContent = flowers[Math.floor(Math.random()*flowers.length)];
                const left = Math.random()*90 + '%';
                f.style.left = left;
                const size = Math.floor(Math.random()*28)+18; // 18-46px
                f.style.fontSize = size + 'px';
                // longer, varied duration so flowers fall slowly
                const duration = Math.random()*6+6; // 6-12s
                f.style.animationDuration = duration + 's';
                // slight negative delay to spread start times visually
                f.style.animationDelay = (Math.random()*0.6)+'s';
                document.body.appendChild(f);
                // cleanup after animation
                setTimeout(()=>{ if(f && f.parentNode) f.parentNode.removeChild(f); }, (duration+1)*1000);
            }, i * 250); // new flower every 250ms
        }
    }
});
