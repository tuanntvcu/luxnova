(() => {
	const scoring = window.LuxNovaStyleScoring;
	const modal = document.querySelector('[data-design-style-quiz]');
	const triggers = document.querySelectorAll('[data-design-style-quiz-open]');

	if (!scoring || !modal || !triggers.length) {
		return;
	}

	const form = modal.querySelector('[data-design-style-quiz-form]');
	const steps = Array.from(modal.querySelectorAll('[data-design-style-quiz-step]'));
	const resultPanel = modal.querySelector('[data-design-style-quiz-result]');
	const progress = modal.querySelector('[data-design-style-quiz-progress]');
	const nextButton = modal.querySelector('[data-design-style-quiz-next]');
	const prevButton = modal.querySelector('[data-design-style-quiz-prev]');
	const submitButton = modal.querySelector('[data-design-style-quiz-submit]');
	const restartButton = modal.querySelector('[data-design-style-quiz-restart]');
	const closeButtons = modal.querySelectorAll('[data-design-style-quiz-close]');
	const dialog = modal.querySelector('.design-quiz-modal__dialog');
	let activeStep = 0;
	let previousFocus = null;

	const getFocusableItems = () => Array.from(modal.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])'));

	const setStep = (index) => {
		activeStep = Math.max(0, Math.min(index, steps.length - 1));

		steps.forEach((step, stepIndex) => {
			const isActive = stepIndex === activeStep;
			step.hidden = !isActive;
			step.setAttribute('aria-hidden', String(!isActive));
		});

		if (resultPanel) {
			resultPanel.hidden = true;
		}

		if (progress) {
			progress.textContent = `${activeStep + 1} / ${steps.length}`;
		}

		if (prevButton) {
			prevButton.disabled = activeStep === 0;
		}

		if (nextButton) {
			nextButton.hidden = activeStep === steps.length - 1;
		}

		if (submitButton) {
			submitButton.hidden = activeStep !== steps.length - 1;
		}
	};

	const currentStepAnswered = () => {
		const step = steps[activeStep];
		if (!step) {
			return false;
		}

		const checked = step.querySelector('input[type="radio"]:checked');
		return Boolean(checked);
	};

	const showStepValidation = () => {
		const step = steps[activeStep];
		const message = step ? step.querySelector('[data-design-style-quiz-error]') : null;

		if (message) {
			message.hidden = currentStepAnswered();
		}
	};

	const collectAnswers = () => {
		const formData = new FormData(form);
		const answers = {};

		for (const [key, value] of formData.entries()) {
			answers[key] = value;
		}

		return answers;
	};

	const renderResult = (result) => {
		if (!resultPanel || !result.primary) {
			return;
		}

		const primaryName = resultPanel.querySelector('[data-design-style-primary-name]');
		const primaryPercent = resultPanel.querySelector('[data-design-style-primary-percent]');
		const alternatives = resultPanel.querySelector('[data-design-style-alternatives]');
		const reasonTitle = resultPanel.querySelector('[data-design-style-reason-title]');
		const reasons = resultPanel.querySelector('[data-design-style-reasons]');

		if (primaryName) {
			primaryName.textContent = result.primary.name;
		}
		if (primaryPercent) {
			primaryPercent.textContent = `${result.primary.percentage}%`;
		}
		if (reasonTitle) {
			reasonTitle.textContent = `Vì sao LuxNova gợi ý ${result.primary.name}?`;
		}
		if (alternatives) {
			alternatives.innerHTML = '';
			result.alternatives.forEach((item) => {
				const li = document.createElement('li');
				li.textContent = `${item.name} (${item.percentage}%)`;
				alternatives.appendChild(li);
			});
		}
		if (reasons) {
			reasons.innerHTML = '';
			result.reasons.forEach((reason) => {
				const li = document.createElement('li');
				li.textContent = reason;
				reasons.appendChild(li);
			});
		}

		steps.forEach((step) => {
			step.hidden = true;
			step.setAttribute('aria-hidden', 'true');
		});

		if (progress) {
			progress.textContent = 'Kết quả';
		}
		if (prevButton) {
			prevButton.hidden = true;
		}
		if (nextButton) {
			nextButton.hidden = true;
		}
		if (submitButton) {
			submitButton.hidden = true;
		}

		resultPanel.hidden = false;
	};

	const openModal = () => {
		previousFocus = document.activeElement;
		modal.hidden = false;
		modal.setAttribute('aria-hidden', 'false');
		document.body.classList.add('is-modal-open');
		setStep(0);

		window.requestAnimationFrame(() => {
			if (dialog) {
				dialog.focus();
			}
		});
	};

	const closeModal = () => {
		if (modal.hidden) {
			return;
		}

		modal.hidden = true;
		modal.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('is-modal-open');

		if (previousFocus && typeof previousFocus.focus === 'function') {
			previousFocus.focus();
		}
	};

	triggers.forEach((trigger) => {
		trigger.addEventListener('click', (event) => {
			event.preventDefault();
			openModal();
		});
	});

	closeButtons.forEach((button) => {
		button.addEventListener('click', closeModal);
	});

	modal.addEventListener('click', (event) => {
		if (event.target === modal) {
			closeModal();
		}
	});

	modal.addEventListener('keydown', (event) => {
		if (event.key === 'Escape') {
			closeModal();
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

	if (nextButton) {
		nextButton.addEventListener('click', () => {
			if (!currentStepAnswered()) {
				showStepValidation();
				return;
			}

			setStep(activeStep + 1);
		});
	}

	if (prevButton) {
		prevButton.addEventListener('click', () => {
			setStep(activeStep - 1);
		});
	}

	if (restartButton) {
		restartButton.addEventListener('click', () => {
			form.reset();
			setStep(0);
		});
	}

	if (form) {
		form.addEventListener('change', showStepValidation);
		form.addEventListener('submit', (event) => {
			event.preventDefault();

			if (!steps.every((step) => Boolean(step.querySelector('input[type="radio"]:checked')))) {
				showStepValidation();
				return;
			}

			renderResult(scoring.calculateStyleMatch(collectAnswers()));
		});
	}

	modal.querySelectorAll('.js-consultation-modal').forEach((trigger) => {
		trigger.addEventListener('click', () => {
			closeModal();
		});
	});
})();
