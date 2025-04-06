// assets/js/script.js

// Safety Tips Toggle
const safetyTips = document.querySelectorAll('.safety-tip');
if (safetyTips) {
    safetyTips.forEach(tip => {
        tip.addEventListener('click', () => {
            const content = tip.querySelector('.tip-content');
            content.classList.toggle('hidden');
            content.style.transition = 'max-height 0.3s ease';
            content.classList.contains('hidden') 
                ? content.style.maxHeight = '0' 
                : content.style.maxHeight = content.scrollHeight + 'px';
        });
    });
}

// Keyboard Event (Global)
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        safetyTips.forEach(tip => {
            const content = tip.querySelector('.tip-content');
            content.classList.add('hidden');
            content.style.maxHeight = '0';
        });
    }
});

// Form Event (Placeholder for future forms)
const forms = document.querySelectorAll('form');
forms.forEach(form => {
    form.addEventListener('submit', (e) => {
        console.log('Form submitted:', e.target);
    });
});