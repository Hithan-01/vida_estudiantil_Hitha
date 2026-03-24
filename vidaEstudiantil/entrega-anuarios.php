<?php
$titulo = 'Entrega de Anuarios 2025-2026';
$paginaActiva = 'entrega-anuarios';
$siteURL = '/Vida%20Estudiantil/';
$portalURL = $siteURL . 'vidaEstudiantil/';

include('assets/php/header.php');
?>

<!-- ══════════════════════════════════════════
     BARRA DE EVENTO (sticky)
══════════════════════════════════════════ -->
<style>
* { box-sizing: border-box; }

/* ── Sticky bar ── */
.ea-bar {
    position: sticky; top: 0; z-index: 999;
    background: #fff;
    border-bottom: 1px solid #e2e8f0;
    padding: .6rem 1.5rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    flex-wrap: wrap;
    box-shadow: 0 2px 12px rgba(0,0,0,.08);
}
.ea-bar-brand {
    display: flex; flex-direction: column; line-height: 1.2;
}
.ea-bar-brand strong {
    font-size: .95rem; font-weight: 800; color: #1e1b6e; letter-spacing: .01em;
}
.ea-bar-brand span {
    font-size: .72rem; color: #64748b;
}
.ea-countdown {
    display: flex; gap: 1.25rem; align-items: center;
}
.ea-cd-unit {
    text-align: center;
}
.ea-cd-num {
    font-size: 1.45rem; font-weight: 900; color: #1e1b6e; line-height: 1;
    display: block;
}
.ea-cd-label {
    font-size: .62rem; color: #94a3b8; text-transform: uppercase; letter-spacing: .08em;
}
.ea-cd-sep {
    font-size: 1.4rem; font-weight: 900; color: #c7d2fe; line-height: 1; margin-bottom: 10px;
}
.ea-bar-btn {
    background: #1e1b6e; color: #fff; font-weight: 700; font-size: .85rem;
    padding: .55rem 1.3rem; border-radius: .75rem; text-decoration: none;
    transition: background .2s, transform .15s;
    white-space: nowrap;
}
.ea-bar-btn:hover { background: #2d2a9e; transform: translateY(-1px); color: #fff; }

/* ── Hero ── */
.ea-hero {
    background: linear-gradient(135deg, #dde0f7 0%, #e8ecff 50%, #d4d8f3 100%);
    padding: 5rem 0 4rem;
    overflow: hidden;
    position: relative;
}
.ea-hero-inner {
    display: flex; align-items: center; gap: 3rem;
    max-width: 1200px; margin: 0 auto; padding: 0 2rem;
}
.ea-hero-text { flex: 1; }
.ea-hero-tag {
    display: inline-block;
    background: rgba(30,27,110,.12); color: #1e1b6e;
    font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase;
    padding: .3rem .85rem; border-radius: 2rem; margin-bottom: 1.25rem;
}
.ea-hero-title {
    font-size: clamp(2.8rem, 6vw, 4.5rem);
    font-weight: 900; font-style: italic;
    color: #1e1b6e; line-height: 1;
    margin: 0 0 .5rem;
}
.ea-hero-subtitle {
    font-size: clamp(1rem, 2.5vw, 1.35rem);
    font-weight: 700; color: #4338ca;
    letter-spacing: .02em; margin: 0 0 1.5rem;
}
.ea-hero-desc {
    color: #475569; font-size: .95rem; line-height: 1.8;
    max-width: 460px; margin: 0;
}
.ea-hero-img-wrap {
    flex-shrink: 0; width: clamp(260px, 35%, 400px);
    position: relative;
}
.ea-hero-img-circle {
    width: 100%; aspect-ratio: 1;
    border-radius: 50%;
    background: rgba(99,102,241,.15);
    overflow: hidden;
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 20px 60px rgba(30,27,110,.2);
}
.ea-hero-img-circle img {
    width: 100%; height: 100%; object-fit: cover;
}
.ea-hero-img-placeholder {
    width: 100%; aspect-ratio: 1; border-radius: 50%;
    background: linear-gradient(135deg, #a5b4fc, #818cf8);
    display: flex; align-items: center; justify-content: center;
    box-shadow: 0 20px 60px rgba(30,27,110,.2);
}
@media(max-width:768px){
    .ea-hero-inner { flex-direction: column; text-align: center; }
    .ea-hero-desc  { margin: 0 auto; }
    .ea-hero-img-wrap { width: 220px; }
}

/* ── Sección: Lo que necesitas saber ── */
.ea-info {
    background: #fff;
    padding: 5rem 0;
}
.ea-section-title {
    font-size: clamp(1.6rem, 3.5vw, 2.2rem);
    font-weight: 800; color: #1e1b6e;
    text-align: center; margin-bottom: .75rem;
}
.ea-section-sub {
    text-align: center; color: #64748b; font-size: .95rem;
    max-width: 560px; margin: 0 auto 3rem; line-height: 1.7;
}
.ea-photo-cards {
    display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.25rem;
    max-width: 1100px; margin: 0 auto; padding: 0 2rem;
}
.ea-photo-card {
    border-radius: 1rem; overflow: hidden;
    aspect-ratio: 4/3; position: relative;
    background: #e2e8f0;
    box-shadow: 0 4px 20px rgba(0,0,0,.1);
    transition: transform .25s, box-shadow .25s;
}
.ea-photo-card:hover { transform: translateY(-4px); box-shadow: 0 12px 36px rgba(0,0,0,.15); }
.ea-photo-card img {
    width: 100%; height: 100%; object-fit: cover; display: block;
}
.ea-photo-card-label {
    position: absolute; bottom: 0; left: 0; right: 0;
    background: linear-gradient(to top, rgba(0,0,0,.65), transparent);
    padding: 1.25rem .9rem .75rem;
    color: #fff; font-size: .82rem; font-weight: 700;
}
.ea-photo-card-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #c7d2fe, #a5b4fc);
    color: #4338ca; font-size: .85rem; font-weight: 600;
    text-align: center; padding: 1rem;
}
@media(max-width:640px){ .ea-photo-cards { grid-template-columns: 1fr; } }
@media(min-width:641px) and (max-width:900px){ .ea-photo-cards { grid-template-columns: repeat(2,1fr); } }

/* ── Sección: Entregas pasadas ── */
.ea-past {
    background: #0f172a;
    padding: 5rem 0;
}
.ea-past .ea-section-title { color: #e2e8f0; }
.ea-past .ea-section-sub   { color: #94a3b8; }

/* Carousel */
.ea-carousel-wrap {
    position: relative; max-width: 1200px; margin: 0 auto; padding: 0 2rem;
}
.ea-carousel {
    overflow: visible;
}
.ea-carousel-track {
    display: flex; transition: transform .5s cubic-bezier(.4,0,.2,1);
}
.ea-past-card {
    flex: 0 0 78%; min-width: 78%;
    padding: 0 .75rem;
    transition: opacity .4s, transform .4s;
    opacity: .45;
    transform: scale(.96);
}
.ea-past-card.active-slide {
    opacity: 1;
    transform: scale(1);
}
.ea-past-card-inner {
    border-radius: .75rem; overflow: hidden; position: relative;
    aspect-ratio: 16/7; background: #1e293b;
    box-shadow: 0 4px 20px rgba(0,0,0,.4);
    transition: transform .25s;
}
.ea-past-card-inner:hover { transform: translateY(-4px); }
.ea-past-card img { width: 100%; height: 100%; object-fit: cover; display: block; }
.ea-past-card-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,.75) 0%, transparent 60%);
}
.ea-past-card-label {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 1rem;
    color: #fff; font-size: .78rem; font-weight: 800;
    text-transform: uppercase; letter-spacing: .05em; line-height: 1.3;
}
.ea-past-card-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: linear-gradient(135deg, #1e293b, #334155);
    color: #94a3b8; font-size: .85rem;
}
/* Flechas */
.ea-carousel-btn {
    position: absolute; top: 50%; transform: translateY(-50%);
    width: 40px; height: 40px; border-radius: 50%;
    background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.18);
    color: #fff; font-size: .9rem; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background .2s; z-index: 2;
}
.ea-carousel-btn:hover { background: rgba(255,255,255,.25); }
.ea-carousel-btn.prev { left: 0; }
.ea-carousel-btn.next { right: 0; }
.ea-carousel-btn:disabled { opacity: .3; cursor: default; }
/* Dots */
.ea-carousel-dots {
    display: flex; justify-content: center; gap: .5rem; margin-top: 1.5rem;
}
.ea-carousel-dot {
    width: 8px; height: 8px; border-radius: 50%;
    background: rgba(255,255,255,.25); border: none; cursor: pointer;
    transition: background .2s, transform .2s; padding: 0;
}
.ea-carousel-dot.active { background: #6366f1; transform: scale(1.3); }
.ea-past-card-label {
    font-size: 1rem;
}
.ea-carousel-btn {
    width: 48px; height: 48px; font-size: 1rem;
}

/* ── FAQ ── */
.ea-faq {
    background: #f8fafc;
    padding: 5rem 0;
}
.ea-faq-inner {
    max-width: 760px; margin: 0 auto; padding: 0 2rem;
}
.ea-faq-item {
    border-bottom: 1px solid #e2e8f0;
}
.ea-faq-btn {
    width: 100%; background: none; border: none; text-align: left;
    padding: 1.25rem 0; cursor: pointer;
    display: flex; justify-content: space-between; align-items: center; gap: 1rem;
    font-size: .97rem; font-weight: 600; color: #1e293b;
    transition: color .2s;
}
.ea-faq-btn:hover { color: #4338ca; }
.ea-faq-icon {
    flex-shrink: 0; width: 22px; height: 22px;
    border-radius: 50%; border: 1.5px solid #cbd5e1;
    display: flex; align-items: center; justify-content: center;
    font-size: .75rem; color: #64748b; transition: all .2s;
}
.ea-faq-item.open .ea-faq-icon { background: #4338ca; border-color: #4338ca; color: #fff; transform: rotate(45deg); }
.ea-faq-body {
    display: none; padding: 0 0 1.25rem;
    color: #475569; font-size: .93rem; line-height: 1.8;
}
.ea-faq-item.open .ea-faq-body { display: block; }

/* ── Pulso Footer ── */
.ea-footer {
    background: #070d1a;
    padding: 3rem 2rem 1.5rem;
    text-align: center;
    color: rgba(255,255,255,.55);
}
.ea-footer-logo {
    font-size: 1.5rem; font-weight: 900; color: #fff;
    letter-spacing: -.02em; margin-bottom: .5rem;
}
.ea-footer-logo span { color: #6366f1; }
.ea-footer-desc {
    font-size: .82rem; line-height: 1.7; max-width: 500px; margin: 0 auto 1.5rem;
}
.ea-footer-socials { display: flex; justify-content: center; gap: 1rem; margin-bottom: 2rem; }
.ea-footer-socials a {
    width: 36px; height: 36px; border-radius: 50%;
    background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.12);
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,.6); font-size: .85rem; text-decoration: none;
    transition: background .2s, color .2s;
}
.ea-footer-socials a:hover { background: rgba(255,255,255,.18); color: #fff; }
.ea-footer-bottom {
    border-top: 1px solid rgba(255,255,255,.07);
    padding-top: 1.25rem; font-size: .75rem;
    color: rgba(255,255,255,.3);
}
</style>

<!-- ── BARRA STICKY ── -->
<div class="ea-bar">
    <div class="ea-bar-brand">
        <strong>ENTREGA DE ANUARIO</strong>
        <span>Sábado 25 de Abril, 2026</span>
    </div>

    <div class="ea-countdown" id="eaCountdown">
        <div class="ea-cd-unit"><span class="ea-cd-num" id="cdDias">--</span><span class="ea-cd-label">días</span></div>
        <span class="ea-cd-sep">:</span>
        <div class="ea-cd-unit"><span class="ea-cd-num" id="cdHoras">--</span><span class="ea-cd-label">horas</span></div>
        <span class="ea-cd-sep">:</span>
        <div class="ea-cd-unit"><span class="ea-cd-num" id="cdMin">--</span><span class="ea-cd-label">minutos</span></div>
        <span class="ea-cd-sep">:</span>
        <div class="ea-cd-unit"><span class="ea-cd-num" id="cdSeg">--</span><span class="ea-cd-label">segundos</span></div>
    </div>

    <a href="<?php echo $portalURL; ?>anuarios" class="ea-bar-btn">Ver anuarios</a>
</div>

<!-- ── HERO ── -->
<section class="ea-hero">
    <div class="ea-hero-inner">
        <div class="ea-hero-text">
            <span class="ea-hero-tag">Vida Estudiantil 2025-2026</span>
            <h1 class="ea-hero-title">ENTREGA<br>DE ANUARIOS</h1>
            <p class="ea-hero-subtitle">VIDA ESTUDIANTIL 2025-2026</p>
            <p class="ea-hero-desc">
                Nuestro trayecto está lleno de recuerdos… Ven por tu anuario
                y revive cada momento que formó parte de nuestro camino.
            </p>
        </div>
        <div class="ea-hero-img-wrap">
            <!-- Reemplaza con: <img src="ruta/imagen.png" alt="Anuario 2025-2026"> -->
            <div class="ea-hero-img-placeholder">
                <i class="fas fa-book-open" style="font-size:5rem;color:rgba(255,255,255,.7);"></i>
            </div>
        </div>
    </div>
</section>

<!-- ── LO QUE NECESITAS SABER ── -->
<section class="ea-info">
    <div class="container">
        <h2 class="ea-section-title">Aquí lo que necesitas saber</h2>
        <p class="ea-section-sub">
            El evento de entrega será el <strong>Sábado 25 de abril de 2026</strong> enfrente de Rectoría, a partir de las <strong>8:00 PM</strong>
        </p>
    </div>
    <div class="ea-photo-cards">
        <!-- Tarjeta 1 — reemplaza src con tu foto del lugar -->
        <div class="ea-photo-card">
            <div class="ea-photo-card-placeholder">
                <div><i class="fas fa-university" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Frente a Rectoría<br>Universidad de Montemorelos</div>
            </div>
            <div class="ea-photo-card-label">Lugar del evento</div>
        </div>
        <!-- Tarjeta 2 — plano / tarima -->
        <div class="ea-photo-card">
            <div class="ea-photo-card-placeholder">
                <div><i class="fas fa-map" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Distribución del área<br>Tarima principal</div>
            </div>
            <div class="ea-photo-card-label">Distribución</div>
        </div>
        <!-- Tarjeta 3 — calendario -->
        <div class="ea-photo-card">
            <div class="ea-photo-card-placeholder">
                <div><i class="fas fa-calendar-alt" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>Sábado 25 de Abril<br>8:00 PM</div>
            </div>
            <div class="ea-photo-card-label">Sábado 25 de Abril</div>
        </div>
    </div>
</section>

<!-- ── ENTREGAS PASADAS ── -->
<section class="ea-past">
    <div class="container">
        <h2 class="ea-section-title">¿Ya viste las entregas pasadas?</h2>
        <p class="ea-section-sub">Momentos que quedaron grabados en la historia de nuestra comunidad.</p>
    </div>
    <div class="ea-carousel-wrap">
        <button class="ea-carousel-btn prev" id="eaPrev" onclick="eaSlide(-1)" aria-label="Anterior">
            <i class="fas fa-chevron-left"></i>
        </button>
        <div class="ea-carousel">
            <div class="ea-carousel-track" id="eaTrack">
                <!-- Tarjeta 1 -->
                <div class="ea-past-card">
                    <div class="ea-past-card-inner">
                        <div class="ea-past-card-placeholder"><i class="fas fa-images" style="font-size:2rem;"></i></div>
                        <div class="ea-past-card-overlay"></div>
                        <div class="ea-past-card-label">ENTREGA DE ANUARIO<br>2023-2024</div>
                    </div>
                </div>
                <!-- Tarjeta 2 -->
                <div class="ea-past-card">
                    <div class="ea-past-card-inner">
                        <div class="ea-past-card-placeholder"><i class="fas fa-images" style="font-size:2rem;"></i></div>
                        <div class="ea-past-card-overlay"></div>
                        <div class="ea-past-card-label">ENTREGA DE ANUARIO<br>2022-2023</div>
                    </div>
                </div>
                <!-- Tarjeta 3 -->
                <div class="ea-past-card">
                    <div class="ea-past-card-inner">
                        <div class="ea-past-card-placeholder"><i class="fas fa-images" style="font-size:2rem;"></i></div>
                        <div class="ea-past-card-overlay"></div>
                        <div class="ea-past-card-label">ENTREGA<br>2022</div>
                    </div>
                </div>
            </div>
        </div>
        <button class="ea-carousel-btn next" id="eaNext" onclick="eaSlide(1)" aria-label="Siguiente">
            <i class="fas fa-chevron-right"></i>
        </button>
        <div class="ea-carousel-dots" id="eaDots"></div>
    </div>
</section>

<!-- ── FAQ ── -->
<section class="ea-faq">
    <div class="ea-faq-inner">
        <h2 class="ea-section-title" style="text-align:left;margin-bottom:2rem;">¿Dudas? Quizás esto te ayude</h2>

        <div class="ea-faq-item open">
            <button class="ea-faq-btn" onclick="toggleFaq(this)">
                ¿Puede alguien más recoger mi anuario?
                <span class="ea-faq-icon"><i class="fas fa-plus"></i></span>
            </button>
            <div class="ea-faq-body">La entrega del anuario es personal. Deberás presentarte tú mismo con tu credencial vigente.</div>
        </div>

        <div class="ea-faq-item">
            <button class="ea-faq-btn" onclick="toggleFaq(this)">
                ¿Tiene algún costo el anuario?
                <span class="ea-faq-icon"><i class="fas fa-plus"></i></span>
            </button>
            <div class="ea-faq-body">Presentando tu credencial de Estudiante Vigente, ¡es <strong>GRATIS</strong>!</div>
        </div>

        <div class="ea-faq-item">
            <button class="ea-faq-btn" onclick="toggleFaq(this)">
                ¿Todavía entregan anuarios pasados?
                <span class="ea-faq-icon"><i class="fas fa-plus"></i></span>
            </button>
            <div class="ea-faq-body">Sabemos que el pasado quedó atrás, PERO quizá tenemos un ejemplar extra. ¡Solo pregúntanos!</div>
        </div>

        <div class="ea-faq-item">
            <button class="ea-faq-btn" onclick="toggleFaq(this)">
                ¿Se ofrecerán alimentos durante el evento?
                <span class="ea-faq-icon"><i class="fas fa-plus"></i></span>
            </button>
            <div class="ea-faq-body">Habrá una pequeña selección de snacks y bebidas disponibles durante la noche del evento. ¡Ven con hambre!</div>
        </div>
    </div>
</section>

<!-- ── PULSO FOOTER ── -->
<footer class="ea-footer">
    <div class="ea-footer-logo">pul<span>s</span>o</div>
    <p class="ea-footer-desc">
        El anuario Vida Estudiantil 2025-2026: Trayectos, es un proyecto institucional producido
        por PULSO de la Vicerrectoría Estudiantil de la Universidad de Montemorelos.
        Este anuario fue realizado con la asistencia y liderazgo de estudiantes y personal de
        apoyo, a fin de arraigar a la familia universitaria y promocionar el mensaje curricular.
    </p>
    <div class="ea-footer-socials">
        <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" title="TikTok"><i class="fab fa-tiktok"></i></a>
        <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="#" title="Twitter/X"><i class="fab fa-x-twitter"></i></a>
        <a href="#" title="Spotify"><i class="fab fa-spotify"></i></a>
    </div>
    <div class="ea-footer-bottom">
        <span>2026</span>
    </div>
</footer>

<script>
/* ── Countdown ── */
(function() {
    // Fecha objetivo: 25 de Abril 2026, 20:00 PM hora local
    const target = new Date('2026-04-25T20:00:00');

    function pad(n) { return String(n).padStart(2, '0'); }

    function tick() {
        const now  = new Date();
        const diff = target - now;

        if (diff <= 0) {
            document.getElementById('cdDias').textContent = '00';
            document.getElementById('cdHoras').textContent = '00';
            document.getElementById('cdMin').textContent = '00';
            document.getElementById('cdSeg').textContent = '00';
            return;
        }

        const d = Math.floor(diff / 86400000);
        const h = Math.floor((diff % 86400000) / 3600000);
        const m = Math.floor((diff % 3600000) / 60000);
        const s = Math.floor((diff % 60000) / 1000);

        document.getElementById('cdDias').textContent  = pad(d);
        document.getElementById('cdHoras').textContent = pad(h);
        document.getElementById('cdMin').textContent   = pad(m);
        document.getElementById('cdSeg').textContent   = pad(s);
    }

    tick();
    setInterval(tick, 1000);
})();

/* ── Carousel ── */
(function() {
    const track  = document.getElementById('eaTrack');
    const dots   = document.getElementById('eaDots');
    const prev   = document.getElementById('eaPrev');
    const next   = document.getElementById('eaNext');
    if (!track) return;

    const cards  = track.querySelectorAll('.ea-past-card');
    const total  = cards.length;
    let current  = 0;

    function buildDots() {
        dots.innerHTML = '';
        for (let i = 0; i < total; i++) {
            const d = document.createElement('button');
            d.className = 'ea-carousel-dot' + (i === current ? ' active' : '');
            d.addEventListener('click', () => goTo(i));
            dots.appendChild(d);
        }
    }

    function goTo(idx) {
        current = Math.max(0, Math.min(idx, total - 1));
        // 78% card width + 1.5rem gap ≈ 1.5rem = 24px
        const cardW = cards[0].offsetWidth;
        const offset = current * cardW + (current * 12) - (track.parentElement.offsetWidth - cardW) / 2;
        track.style.transform = `translateX(${-Math.max(0, offset)}px)`;
        cards.forEach((c, i) => c.classList.toggle('active-slide', i === current));
        dots.querySelectorAll('.ea-carousel-dot').forEach((d, i) => d.classList.toggle('active', i === current));
        prev.disabled = current === 0;
        next.disabled = current >= total - 1;
    }

    window.eaSlide = function(dir) { goTo(current + dir); resetTimer(); };

    // Auto-advance cada 30 segundos
    let timer = setInterval(() => goTo(current + 1 < total ? current + 1 : 0), 10000);
    function resetTimer() {
        clearInterval(timer);
        timer = setInterval(() => goTo(current + 1 < total ? current + 1 : 0), 10000    );
    }
    // Reiniciar timer al hacer click en dots
    dots.addEventListener('click', resetTimer);

    buildDots();
    goTo(0);
})();

/* ── FAQ accordion ── */
function toggleFaq(btn) {
    const item = btn.closest('.ea-faq-item');
    const isOpen = item.classList.contains('open');
    // Cerrar todos
    document.querySelectorAll('.ea-faq-item').forEach(i => i.classList.remove('open'));
    // Abrir si estaba cerrado
    if (!isOpen) item.classList.add('open');
}
</script>

<?php include('assets/php/footer.php'); ?>
