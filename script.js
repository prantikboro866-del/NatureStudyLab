const menuButton = document.querySelector('.menu-toggle');
const navigation = document.querySelector('#site-nav');

if (menuButton && navigation) {
    menuButton.addEventListener('click', () => {
        const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
        menuButton.setAttribute('aria-expanded', String(!isOpen));
        navigation.classList.toggle('is-open', !isOpen);
    });

    navigation.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => {
            menuButton.setAttribute('aria-expanded', 'false');
            navigation.classList.remove('is-open');
        });
    });
}

const contactForm = document.querySelector('.contact-form');

if (contactForm) {
    contactForm.addEventListener('submit', async (event) => {
        event.preventDefault();
        const submitButton = contactForm.querySelector('button[type="submit"]');
        const status = contactForm.querySelector('.form-status');

        submitButton.disabled = true;
        status.textContent = 'Sending your message...';

        try {
            const response = await fetch('submit_contact.php', {
                method: 'POST',
                body: new FormData(contactForm),
                headers: { Accept: 'application/json' }
            });
            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Unable to send your message.');
            }

            contactForm.reset();
            status.textContent = result.message;
        } catch (error) {
            status.textContent = error.message || 'Unable to send your message. Please try again.';
        } finally {
            submitButton.disabled = false;
        }
    });
}