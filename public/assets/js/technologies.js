document.addEventListener('DOMContentLoaded', () => {
    const skillTitle = document.getElementById('skill-title');
    const skillDescription = document.getElementById('skill-description');
    const icons = document.getElementById('dev-icons');

    icons.addEventListener('click', (e) => {
        const icon = e.target;
        const techName = icon.classList[0];
        const skillNames = {
            "php": "#777bb3",
            "laravel": "#F0513F",
            "javascript": "#F0DB4F",
            "docker": "#019BC6",
            "mysql": "#00618A",
            "github": "white",
            "wordpress": "white",
            "html5": "#E54D26",
            "css3": "#3D8FC6",
            "bootstrap": "#8819FD",
            "tailwindcss": "#38BDF8"
        }
        const skillNamesArr = Object.entries(skillNames);

        if (icon.tagName.toLowerCase() === 'i' && icon.dataset.title) {
            skillTitle.textContent = icon.dataset.title;
            skillDescription.textContent = icon.dataset.description;

            icons.querySelectorAll('i').forEach(i => {
                i.classList.remove('colored', 'skill-active');
                i.style.boxShadow = "none";
            });

            for (const [name, color] of skillNamesArr) {
                if (techName.includes(name)) {
                    icon.style.boxShadow = color + " 0px 0px 5px 1px";
                }
            }
            
            if (!techName.includes("github") && !techName.includes("wordpress")) {
                icon.classList.add('colored', 'skill-active');
            } else {
                icon.classList.add('skill-active');
            }
        }
    });
});



