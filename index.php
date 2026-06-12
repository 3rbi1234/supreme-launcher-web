<?php
// index.php - Supreme RolePlay Launcher
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Download Supreme RolePlay Launcher">
    <meta name="theme-color" content="#060608">
    <title>Supreme RolePlay | Launcher</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800;14..32,900&display=swap" rel="stylesheet">
    <style>
        :root{--bg:#060608;--gold:#FFD54A;--text:#fff;--dim:#7a7a8a;--border:rgba(255,255,255,0.05);--glass:rgba(13,13,20,0.85);--green:#4ADE80}
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;overflow-x:hidden}
        .bg-wrap{position:fixed;inset:0;z-index:-2}
        .bg-img{position:absolute;inset:0;background-size:cover;background-position:center;opacity:0;transition:opacity 2s}
        .bg-img.show{opacity:1}
        .bg-dark{position:fixed;inset:0;background:rgba(6,6,8,0.88);backdrop-filter:blur(6px);z-index:-1}
        .lang-wrap{position:fixed;top:20px;right:20px;z-index:999}
        .lang-flag{width:20px;height:14px;border-radius:2px}
        .lang-btn{display:flex;align-items:center;gap:8px;padding:8px 14px;background:var(--glass);border:1px solid var(--border);border-radius:30px;cursor:pointer;color:#fff;font-size:12px;font-weight:600;backdrop-filter:blur(16px);transition:0.2s}
        .lang-btn:hover{border-color:var(--gold)}
        .lang-drop{display:none;position:absolute;top:calc(100%+8px);right:0;background:rgba(10,10,16,0.98);border:1px solid rgba(255,255,255,0.08);border-radius:16px;overflow:hidden;min-width:150px;box-shadow:0 20px 60px rgba(0,0,0,0.9);backdrop-filter:blur(20px)}
        .lang-wrap.open .lang-drop{display:block}
        .lang-opt{display:flex;align-items:center;gap:10px;padding:12px 16px;cursor:pointer;color:rgba(255,255,255,0.5);font-size:13px;font-weight:500;transition:0.2s}
        .lang-opt:hover{background:rgba(255,213,74,0.05);color:#fff}
        .lang-opt.active{color:var(--gold)}
        .lang-arrow{font-size:8px;transition:0.2s}
        .lang-wrap.open .lang-arrow{transform:rotate(180deg)}
        .page{position:relative;z-index:1;display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:100vh;padding:2rem}
        .container{width:100%;max-width:800px;animation:fadeIn 0.8s ease}
        @keyframes fadeIn{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}
        .hero{text-align:center}
        .logo{width:90px;margin-bottom:1.5rem;filter:drop-shadow(0 8px 24px rgba(0,0,0,0.6))}
        .logo:hover{transform:translateY(-4px) scale(1.05);transition:0.3s}
        .hero h1{font-size:clamp(2.5rem,7vw,4.5rem);font-weight:900;letter-spacing:-1px;margin-bottom:0.5rem;background:linear-gradient(180deg,#fff 20%,#aaa 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
        .hero .tagline{color:var(--dim);font-size:1rem;margin-bottom:2rem;font-weight:500}
        .stats-card{display:inline-flex;align-items:center;gap:14px;background:var(--glass);border:1px solid var(--border);border-radius:20px;padding:18px 30px;backdrop-filter:blur(16px);margin-bottom:1.5rem;transition:0.3s}
        .stats-card img{width:26px;height:26px;opacity:0.8}
        .live-dot{width:10px;height:10px;border-radius:50%;background:var(--green);box-shadow:0 0 14px var(--green);animation:pulse 2s infinite;flex-shrink:0}
        @keyframes pulse{0%,100%{opacity:1}50%{opacity:0.4}}
        .stats-num{font-size:2.2rem;font-weight:800;color:var(--gold);line-height:1}
        .stats-label{font-size:0.75rem;color:var(--dim);text-transform:uppercase;letter-spacing:1px}
        .btn-outline{display:inline-flex;align-items:center;gap:6px;background:var(--glass);border:1px solid var(--border);color:#fff;padding:10px 20px;border-radius:30px;text-decoration:none;font-weight:500;font-size:0.85rem;backdrop-filter:blur(12px);transition:0.3s;margin-bottom:1.5rem}
        .btn-outline:hover{border-color:var(--gold);background:rgba(255,213,74,0.06);transform:translateY(-2px)}
        .btn-primary{display:inline-flex;align-items:center;gap:10px;background:linear-gradient(135deg,#FFD54A,#FFC107);color:#0a0a0f;font-weight:700;font-size:1.1rem;padding:16px 42px;border-radius:50px;text-decoration:none;box-shadow:0 12px 35px rgba(255,213,74,0.3);transition:0.3s}
        .btn-primary:hover{transform:translateY(-3px);box-shadow:0 20px 50px rgba(255,213,74,0.5)}
        .features{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin:2.5rem 0}
        .feat{background:var(--glass);border:1px solid var(--border);border-radius:20px;padding:24px 18px;text-align:center;backdrop-filter:blur(14px);transition:0.3s}
        .feat:hover{transform:translateY(-6px);border-color:rgba(255,213,74,0.2);box-shadow:0 16px 40px rgba(0,0,0,0.5)}
        .feat img{width:40px;height:40px;margin-bottom:12px}
        .feat h3{font-size:1rem;font-weight:700;margin-bottom:4px}
        .feat p{color:var(--dim);font-size:0.8rem;line-height:1.4}
        .dl-info{display:flex;gap:20px;justify-content:center;flex-wrap:wrap;margin-bottom:2rem}
        .dl-item{background:var(--glass);border:1px solid var(--border);border-radius:16px;padding:12px 20px;text-align:center;backdrop-filter:blur(12px);min-width:100px}
        .dl-item .lbl{font-size:0.65rem;text-transform:uppercase;color:var(--dim);letter-spacing:0.8px;display:block;margin-bottom:4px}
        .dl-item .val{font-weight:700;font-size:0.9rem}
        footer{color:#4a4a5a;font-size:0.75rem;text-align:center;margin-top:2rem}
        @media(max-width:600px){.features{grid-template-columns:1fr}}
    </style>
</head>
<body>
<div class="bg-wrap" id="bgWrap"></div>
<div class="bg-dark"></div>
<div class="lang-wrap" id="langWrap">
    <button class="lang-btn" id="langBtn">
        <img id="langFlag" src="uk.png" class="lang-flag"><span id="langCode">EN</span><span class="lang-arrow">▼</span>
    </button>
    <div class="lang-drop">
        <div class="lang-opt active" data-lang="en"><img src="uk.png" class="lang-flag"> English</div>
        <div class="lang-opt" data-lang="de"><img src="germany.png" class="lang-flag"> Deutsch</div>
    </div>
</div>
<div class="page"><div class="container"><div class="hero">
    <img src="logo.png" alt="Supreme" class="logo" width="90" height="90">
    <h1>SUPREME ROLEPLAY</h1>
    <p class="tagline" id="tagline">The most advanced roleplay launcher.</p>
    <div class="stats-card"><span class="live-dot"></span><img src="people.png"><span class="stats-num" id="totalPlayers">—</span><span class="stats-label" id="lblPlayers">Players Online</span></div><br>
    <a href="servers.php" class="btn-outline" id="btnServers">🌐 View All Servers →</a><br>
    <a href="download.php" class="btn-primary" id="btnDownload"><svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg> Download Launcher</a>
</div>
<div class="features">
    <div class="feat"><img src="secure.png"><h3 id="f1t">Advanced Security</h3><p id="f1d">Safe downloads, protected systems.</p></div>
    <div class="feat"><img src="fast.png"><h3 id="f2t">Lightning Fast</h3><p id="f2d">High-speed delivery worldwide.</p></div>
    <div class="feat"><img src="download.png"><h3 id="f3t">One Click Install</h3><p id="f3d">Automatic updates in seconds.</p></div>
</div>
<div class="dl-info">
    <div class="dl-item"><span class="lbl" id="l1">Version</span><span class="val">2.4.1</span></div>
    <div class="dl-item"><span class="lbl" id="l2">Size</span><span class="val">184 MB</span></div>
    <div class="dl-item"><span class="lbl" id="l3">Updated</span><span class="val">June 2026</span></div>
    <div class="dl-item"><span class="lbl" id="l4">Windows</span><span class="val">10 / 11</span></div>
</div>
<footer>© 2026 Supreme RolePlay. All rights reserved.</footer></div></div>
<script>
const TX={en:{tagline:'The most advanced roleplay launcher.',players:'Players Online',servers:'🌐 View All Servers →',download:'Download Launcher',f1t:'Advanced Security',f1d:'Safe downloads, protected systems.',f2t:'Lightning Fast',f2d:'High-speed delivery worldwide.',f3t:'One Click Install',f3d:'Automatic updates in seconds.',l1:'Version',l2:'Size',l3:'Updated',l4:'Windows'},de:{tagline:'Der fortschrittlichste Launcher.',players:'Spieler Online',servers:'🌐 Alle Server →',download:'Herunterladen',f1t:'Erweiterte Sicherheit',f1d:'Sichere Downloads.',f2t:'Blitzschnell',f2d:'Weltweit schnelle Lieferung.',f3t:'Ein-Klick-Installation',f3d:'Updates in Sekunden.',l1:'Version',l2:'Größe',l3:'Aktualisiert',l4:'Windows'}};
let lang=localStorage.getItem('srp_lang')||'en';
function setLang(l){lang=l;localStorage.setItem('srp_lang',l);const t=TX[l];
document.getElementById('tagline').textContent=t.tagline;document.getElementById('lblPlayers').textContent=t.players;
document.getElementById('btnServers').textContent=t.servers;
document.getElementById('btnDownload').innerHTML='<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/></svg> '+t.download;
document.getElementById('f1t').textContent=t.f1t;document.getElementById('f1d').textContent=t.f1d;
document.getElementById('f2t').textContent=t.f2t;document.getElementById('f2d').textContent=t.f2d;
document.getElementById('f3t').textContent=t.f3t;document.getElementById('f3d').textContent=t.f3d;
document.getElementById('l1').textContent=t.l1;document.getElementById('l2').textContent=t.l2;
document.getElementById('l3').textContent=t.l3;document.getElementById('l4').textContent=t.l4;
document.getElementById('langFlag').src=l==='en'?'uk.png':'germany.png';
document.getElementById('langCode').textContent=l.toUpperCase();
document.querySelectorAll('.lang-opt').forEach(o=>o.classList.toggle('active',o.dataset.lang===l));}
setLang(lang);
document.getElementById('langBtn').addEventListener('click',e=>{e.stopPropagation();document.getElementById('langWrap').classList.toggle('open')});
document.querySelectorAll('.lang-opt').forEach(o=>o.addEventListener('click',function(e){e.stopPropagation();setLang(this.dataset.lang);document.getElementById('langWrap').classList.remove('open')}));
document.addEventListener('click',e=>{if(!document.getElementById('langWrap').contains(e.target))document.getElementById('langWrap').classList.remove('open')});
(function(){const c=document.getElementById('bgWrap');for(let i=0;i<11;i++){const d=document.createElement('div');d.className='bg-img';d.style.backgroundImage=`url('bg${i}.png')`;if(i===0)d.classList.add('show');c.appendChild(d)}const s=document.querySelectorAll('.bg-img');let idx=0;setInterval(()=>{s[idx].classList.remove('show');idx=(idx+1)%s.length;s[idx].classList.add('show')},9000)})();
async function loadStats(){try{const r=await fetch('server_status.php');const d=await r.json();document.getElementById('totalPlayers').textContent=d.total_players}catch(e){document.getElementById('totalPlayers').textContent='—'}}
loadStats();setInterval(loadStats,20000);
</script>
</body>
</html>