<footer><?php echo $config['footer'];?></footer>
<button id="mode-toggle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lightning-charge-fill" viewBox="0 0 16 16">
  <path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/>
<title>Dark Light Mode</title></svg></button>
<script>
const body = document.body;
const modeToggle = document.getElementById('mode-toggle');
function setMode(mode) {
    if (mode === 'dark') {
        body.classList.add('dark-mode');
        body.classList.remove('light-mode');
    } else {
        body.classList.add('light-mode');
        body.classList.remove('dark-mode');
    }
    localStorage.setItem('preferredMode', mode);
}
function loadSavedMode() {
    const savedMode = localStorage.getItem('preferredMode');
    if (savedMode) {
        setMode(savedMode);
    } else {
        setMode('light');
    }
}
modeToggle.addEventListener('click', () => {
    const currentMode = body.classList.contains('dark-mode') ? 'dark' : 'light';
    const newMode = currentMode === 'dark' ? 'light' : 'dark';
    setMode(newMode);
});
document.addEventListener('DOMContentLoaded', loadSavedMode);
</script>
</body>
</html>