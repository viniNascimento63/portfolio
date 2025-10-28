document.addEventListener('DOMContentLoaded', () => {
    const skillTitle = document.getElementById('skill-title');
    const skillDescription = document.getElementById('skill-description');
    const icons = document.querySelector('.dev-icons');

    icons.addEventListener('click', (e) => {
        const icon = e.target;
        console.log(icon);

        if (icon.tagName.toLowerCase() === 'i' && icon.dataset.title) {
            skillTitle.textContent = icon.dataset.title;
            skillDescription.textContent = icon.dataset.description;

            icons.querySelectorAll('i').forEach(i => i.classList.remove('active'));
            icon.classList.add('active');
        }
    });
});



