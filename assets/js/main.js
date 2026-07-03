(() => {
	const header = document.querySelector('[data-site-header]');
	const menuToggle = document.querySelector('[data-menu-toggle]');
	const nav = document.querySelector('#primary-nav');

	const setHeaderState = () => {
		if (!header) {
			return;
		}
		header.classList.toggle('is-scrolled', window.scrollY > 18);
	};

	setHeaderState();
	window.addEventListener('scroll', setHeaderState, { passive: true });

	if (menuToggle && nav) {
		menuToggle.addEventListener('click', () => {
			const isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
			menuToggle.setAttribute('aria-expanded', String(!isOpen));
			nav.classList.toggle('is-open', !isOpen);
		});

		nav.addEventListener('click', (event) => {
			if (event.target instanceof HTMLAnchorElement) {
				menuToggle.setAttribute('aria-expanded', 'false');
				nav.classList.remove('is-open');
			}
		});
	}

	const revealItems = document.querySelectorAll('.reveal-on-scroll');
	if ('IntersectionObserver' in window) {
		const revealObserver = new IntersectionObserver((entries, observer) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.14 });

		revealItems.forEach((item) => revealObserver.observe(item));
	} else {
		revealItems.forEach((item) => item.classList.add('is-visible'));
	}

	const counters = document.querySelectorAll('[data-count-up]');
	const animateCounter = (element) => {
		const target = Number.parseInt(element.dataset.countUp || '0', 10);
		if (!target || element.dataset.counted === 'true') {
			return;
		}

		element.dataset.counted = 'true';
		const duration = 900;
		const start = performance.now();
		const tick = (time) => {
			const progress = Math.min((time - start) / duration, 1);
			const eased = 1 - Math.pow(1 - progress, 3);
			element.textContent = String(Math.round(target * eased));
			if (progress < 1) {
				window.requestAnimationFrame(tick);
			}
		};
		window.requestAnimationFrame(tick);
	};

	if ('IntersectionObserver' in window) {
		const counterObserver = new IntersectionObserver((entries, observer) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					animateCounter(entry.target);
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.6 });

		counters.forEach((counter) => counterObserver.observe(counter));
	} else {
		counters.forEach(animateCounter);
	}
})();
