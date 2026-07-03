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

	const modal = document.querySelector('#consultation-modal');
	const modalTriggers = document.querySelectorAll('.js-consultation-modal');
	let previousFocus = null;

	const getFocusableItems = () => {
		if (!modal) {
			return [];
		}
		return Array.from(modal.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'));
	};

	const openConsultationModal = () => {
		if (!modal) {
			return;
		}

		previousFocus = document.activeElement;
		modal.hidden = false;
		modal.setAttribute('aria-hidden', 'false');
		document.body.classList.add('is-modal-open');

		window.requestAnimationFrame(() => {
			const dialog = modal.querySelector('.consultation-modal__dialog');
			if (dialog) {
				dialog.focus();
			}
		});
	};

	const closeConsultationModal = () => {
		if (!modal || modal.hidden) {
			return;
		}

		modal.hidden = true;
		modal.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('is-modal-open');

		if (previousFocus && typeof previousFocus.focus === 'function') {
			previousFocus.focus();
		}
	};

	modalTriggers.forEach((trigger) => {
		trigger.addEventListener('click', (event) => {
			event.preventDefault();
			openConsultationModal();
		});
	});

	if (modal) {
		modal.addEventListener('click', (event) => {
			if (event.target.closest('[data-consultation-close]')) {
				closeConsultationModal();
			}
		});

		modal.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') {
				closeConsultationModal();
				return;
			}

			if (event.key !== 'Tab') {
				return;
			}

			const focusableItems = getFocusableItems();
			if (!focusableItems.length) {
				return;
			}

			const firstItem = focusableItems[0];
			const lastItem = focusableItems[focusableItems.length - 1];

			if (event.shiftKey && document.activeElement === firstItem) {
				event.preventDefault();
				lastItem.focus();
			} else if (!event.shiftKey && document.activeElement === lastItem) {
				event.preventDefault();
				firstItem.focus();
			}
		});

		const consultationForm = modal.querySelector('[data-consultation-form]');
		if (consultationForm) {
			consultationForm.addEventListener('submit', async (event) => {
				event.preventDefault();
				const successMessage = modal.querySelector('[data-consultation-success]');
				const errorMessage = modal.querySelector('[data-consultation-error]');
				const submitButton = modal.querySelector('[data-consultation-submit]');
				const defaultSubmitText = submitButton ? submitButton.innerHTML : '';

				if (successMessage) {
					successMessage.hidden = true;
				}
				if (errorMessage) {
					errorMessage.hidden = true;
				}

				if (!window.LuxNovaConsultation || !window.LuxNovaConsultation.ajaxUrl || !window.LuxNovaConsultation.nonce) {
					if (errorMessage) {
						errorMessage.textContent = 'Không thể gửi yêu cầu lúc này. Vui lòng thử lại sau.';
						errorMessage.hidden = false;
					}
					return;
				}

				if (submitButton) {
					submitButton.disabled = true;
					submitButton.textContent = 'Đang gửi...';
				}

				const formData = new FormData(consultationForm);
				formData.append('action', 'luxnova_submit_consultation');
				formData.append('nonce', window.LuxNovaConsultation.nonce);
				formData.append('page_url', window.location.href);

				try {
					const response = await fetch(window.LuxNovaConsultation.ajaxUrl, {
						method: 'POST',
						body: formData,
						credentials: 'same-origin',
					});
					const result = await response.json();
					const message = result && result.message ? result.message : 'Không thể gửi yêu cầu lúc này. Vui lòng thử lại sau.';

					if (response.ok && result && result.success) {
						if (successMessage) {
							successMessage.textContent = message;
							successMessage.hidden = false;
						}
						consultationForm.reset();
					} else if (errorMessage) {
						errorMessage.textContent = message;
						errorMessage.hidden = false;
					}
				} catch (error) {
					if (errorMessage) {
						errorMessage.textContent = 'Không thể gửi yêu cầu lúc này. Vui lòng thử lại sau.';
						errorMessage.hidden = false;
					}
				} finally {
					if (submitButton) {
						submitButton.disabled = false;
						submitButton.innerHTML = defaultSubmitText;
					}
				}
			});
		}
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
