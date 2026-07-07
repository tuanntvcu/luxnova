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

	const inlineConsultationForms = document.querySelectorAll('[data-consultation-form]');
	inlineConsultationForms.forEach((consultationForm) => {
		if (consultationForm.closest('#consultation-modal')) {
			return;
		}

		consultationForm.addEventListener('submit', async (event) => {
			event.preventDefault();
			const successMessage = consultationForm.querySelector('[data-consultation-success]');
			const errorMessage = consultationForm.querySelector('[data-consultation-error]');
			const submitButton = consultationForm.querySelector('[data-consultation-submit]');
			const defaultSubmitText = submitButton ? submitButton.innerHTML : '';

			if (successMessage) {
				successMessage.hidden = true;
			}
			if (errorMessage) {
				errorMessage.hidden = true;
			}

			if (!window.LuxNovaConsultation || !window.LuxNovaConsultation.ajaxUrl || !window.LuxNovaConsultation.nonce) {
				if (errorMessage) {
					errorMessage.textContent = 'KhÃ´ng thá»ƒ gá»­i yÃªu cáº§u lÃºc nÃ y. Vui lÃ²ng thá»­ láº¡i sau.';
					errorMessage.hidden = false;
				}
				return;
			}

			if (submitButton) {
				submitButton.disabled = true;
				submitButton.textContent = 'Äang gá»­i...';
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
				const message = result && result.message ? result.message : 'KhÃ´ng thá»ƒ gá»­i yÃªu cáº§u lÃºc nÃ y. Vui lÃ²ng thá»­ láº¡i sau.';

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
					errorMessage.textContent = 'KhÃ´ng thá»ƒ gá»­i yÃªu cáº§u lÃºc nÃ y. Vui lÃ²ng thá»­ láº¡i sau.';
					errorMessage.hidden = false;
				}
			} finally {
				if (submitButton) {
					submitButton.disabled = false;
					submitButton.innerHTML = defaultSubmitText;
				}
			}
		});
	});

	const testimonialSliders = document.querySelectorAll('[data-testimonial-slider]');
	testimonialSliders.forEach((slider) => {
		const track = slider.querySelector('.testimonial-slider__track');
		if (!track) {
			return;
		}

		const originalSlides = Array.from(track.children);
		if (originalSlides.length < 2) {
			return;
		}

		let currentIndex = 0;
		let slideStep = 0;
		let autoplayTimer = null;
		let resizeTimer = null;
		const mobileScrollerQuery = window.matchMedia('(max-width: 767px)');

		const shouldUseNativeScroll = () => mobileScrollerQuery.matches;

		const getVisibleColumns = () => {
			const value = Number.parseInt(window.getComputedStyle(slider).getPropertyValue('--testimonial-columns'), 10);
			return Number.isNaN(value) ? 1 : Math.max(1, value);
		};

		const getSlideStep = () => {
			const firstSlide = track.querySelector('.testimonial-slider__slide');
			if (!firstSlide) {
				return 0;
			}

			const trackStyle = window.getComputedStyle(track);
			const gap = Number.parseFloat(trackStyle.columnGap || trackStyle.gap || '0') || 0;
			return firstSlide.getBoundingClientRect().width + gap;
		};

		const setTrackPosition = (animate = true) => {
			if (shouldUseNativeScroll()) {
				track.classList.remove('is-resetting');
				track.style.transform = '';
				return;
			}

			track.classList.toggle('is-resetting', !animate);
			track.style.transform = `translate3d(-${currentIndex * slideStep}px, 0, 0)`;

			if (!animate) {
				window.requestAnimationFrame(() => {
					track.classList.remove('is-resetting');
				});
			}
		};

		const stopAutoplay = () => {
			if (autoplayTimer) {
				window.clearInterval(autoplayTimer);
				autoplayTimer = null;
			}
		};

		const startAutoplay = () => {
			stopAutoplay();
			if (shouldUseNativeScroll()) {
				return;
			}

			autoplayTimer = window.setInterval(() => {
				currentIndex += 1;
				setTrackPosition();
			}, 3000);
		};

		const removeClones = () => {
			track.querySelectorAll('[data-testimonial-clone]').forEach((clone) => clone.remove());
		};

		const appendClones = () => {
			const cloneCount = Math.min(getVisibleColumns(), originalSlides.length);
			originalSlides.slice(0, cloneCount).forEach((slide) => {
				const clone = slide.cloneNode(true);
				clone.setAttribute('aria-hidden', 'true');
				clone.setAttribute('data-testimonial-clone', 'true');
				clone.classList.add('is-visible');
				clone.querySelectorAll('a, button, input, select, textarea, [tabindex]').forEach((item) => {
					item.setAttribute('tabindex', '-1');
				});
				track.appendChild(clone);
			});
		};

		const setupSlider = () => {
			stopAutoplay();
			removeClones();
			if (shouldUseNativeScroll()) {
				currentIndex = 0;
				slideStep = 0;
				track.classList.remove('is-resetting');
				track.style.transform = '';
				return;
			}

			appendClones();
			currentIndex = 0;
			slideStep = getSlideStep();
			setTrackPosition(false);
			startAutoplay();
		};

		track.addEventListener('transitionend', () => {
			if (currentIndex >= originalSlides.length) {
				currentIndex = 0;
				setTrackPosition(false);
			}
		});

		slider.addEventListener('mouseenter', stopAutoplay);
		slider.addEventListener('mouseleave', startAutoplay);
		slider.addEventListener('focusin', stopAutoplay);
		slider.addEventListener('focusout', startAutoplay);
		window.addEventListener('resize', () => {
			window.clearTimeout(resizeTimer);
			resizeTimer = window.setTimeout(setupSlider, 160);
		});
		document.addEventListener('visibilitychange', () => {
			if (document.hidden) {
				stopAutoplay();
			} else {
				startAutoplay();
			}
		});

		setupSlider();
	});

	const projectGallery = document.querySelector('[data-project-gallery]');
	const projectGalleryLightbox = document.querySelector('[data-project-gallery-lightbox]');
	if (projectGallery && projectGalleryLightbox) {
		const mediaRoot = projectGalleryLightbox.querySelector('[data-project-gallery-media]');
		const counter = projectGalleryLightbox.querySelector('[data-project-gallery-counter]');
		const dialog = projectGalleryLightbox.querySelector('.project-gallery-lightbox__dialog');
		const dataNode = document.querySelector('[data-project-gallery-data]');
		const itemButtons = Array.from(projectGallery.querySelectorAll('[data-project-gallery-item]'));
		let galleryItems = [];
		let currentGalleryIndex = 0;
		let galleryPreviousFocus = null;

		try {
			galleryItems = dataNode ? JSON.parse(dataNode.textContent || '[]') : [];
		} catch (error) {
			galleryItems = [];
		}

		if (!galleryItems.length) {
			galleryItems = itemButtons.map((button) => {
				try {
					return JSON.parse(button.dataset.projectGalleryItem || '{}');
				} catch (error) {
					return {};
				}
			}).filter((item) => item && item.url);
		}

		const renderProjectGalleryItem = () => {
			if (!mediaRoot || !galleryItems.length) {
				return;
			}

			const item = galleryItems[currentGalleryIndex] || {};
			mediaRoot.innerHTML = '';

			if (item.type === 'video') {
				const video = document.createElement('video');
				video.src = item.url || '';
				video.controls = true;
				video.autoplay = true;
				video.playsInline = true;
				video.preload = 'metadata';
				if (item.thumb) {
					video.poster = item.thumb;
				}
				mediaRoot.appendChild(video);
				video.play().catch(() => {});
			} else {
				const image = document.createElement('img');
				image.src = item.url || item.thumb || '';
				image.alt = item.alt || '';
				image.decoding = 'async';
				mediaRoot.appendChild(image);
			}

			if (counter) {
				counter.textContent = `${currentGalleryIndex + 1} / ${galleryItems.length}`;
			}
		};

		const openProjectGallery = (index) => {
			if (!galleryItems.length) {
				return;
			}

			currentGalleryIndex = Math.max(0, Math.min(index, galleryItems.length - 1));
			galleryPreviousFocus = document.activeElement;
			projectGalleryLightbox.hidden = false;
			projectGalleryLightbox.setAttribute('aria-hidden', 'false');
			document.body.classList.add('is-modal-open');
			renderProjectGalleryItem();

			window.requestAnimationFrame(() => {
				if (dialog) {
					dialog.focus();
				}
			});
		};

		const closeProjectGallery = () => {
			if (projectGalleryLightbox.hidden) {
				return;
			}

			if (mediaRoot) {
				mediaRoot.innerHTML = '';
			}
			projectGalleryLightbox.hidden = true;
			projectGalleryLightbox.setAttribute('aria-hidden', 'true');
			document.body.classList.remove('is-modal-open');

			if (galleryPreviousFocus && typeof galleryPreviousFocus.focus === 'function') {
				galleryPreviousFocus.focus();
			}
		};

		const moveProjectGallery = (step) => {
			if (!galleryItems.length) {
				return;
			}

			currentGalleryIndex = (currentGalleryIndex + step + galleryItems.length) % galleryItems.length;
			renderProjectGalleryItem();
		};

		itemButtons.forEach((button) => {
			button.addEventListener('click', () => {
				const index = Number.parseInt(button.dataset.projectGalleryIndex || '0', 10);
				openProjectGallery(Number.isNaN(index) ? 0 : index);
			});
		});

		projectGalleryLightbox.addEventListener('click', (event) => {
			if (event.target.closest('[data-project-gallery-close]')) {
				closeProjectGallery();
			} else if (event.target.closest('[data-project-gallery-prev]')) {
				moveProjectGallery(-1);
			} else if (event.target.closest('[data-project-gallery-next]')) {
				moveProjectGallery(1);
			}
		});

		projectGalleryLightbox.addEventListener('keydown', (event) => {
			if (event.key === 'Escape') {
				closeProjectGallery();
			} else if (event.key === 'ArrowLeft') {
				event.preventDefault();
				moveProjectGallery(-1);
			} else if (event.key === 'ArrowRight') {
				event.preventDefault();
				moveProjectGallery(1);
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
		const duration = 2500;
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
