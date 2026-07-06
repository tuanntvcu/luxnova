class LuxnovaCursor {
	constructor() {
		this.cursor = null;
		this.dot = null;
		this.ring = null;
		this.label = null;
		this.currentState = 'default';
		this.isHidden = false;
		this.isReady = false;
		this.lastX = window.innerWidth / 2;
		this.lastY = window.innerHeight / 2;
		this.color = '#C8A46A';
		this.darkDot = '#111111';

		this.selectors = {
			button: 'button, .button, .btn, .wp-element-button, input[type="submit"], a.button',
			link: 'a:not(.button):not(.btn):not(.wp-element-button)',
			gallery: '.gallery-item',
			slider: '.slider, .swiper',
			disabled: 'input:not([type="submit"]), textarea, select, iframe, .gm-style, [data-cursor-disabled]',
		};

		this.onPointerMove = this.move.bind(this);
		this.onPointerDown = this.onPointerDown.bind(this);
		this.onPointerOver = this.onPointerOver.bind(this);
		this.onPointerOut = this.onPointerOut.bind(this);
		this.hasInitialized = false;
	}

	init() {
		if (this.hasInitialized) {
			return;
		}

		if (!this.canRun()) {
			return;
		}

		this.createMarkup();

		if (!this.cursor || !this.dot || !this.ring || !this.label) {
			return;
		}

		gsap.set([this.dot, this.ring], {
			xPercent: -50,
			yPercent: -50,
			x: this.lastX,
			y: this.lastY,
			force3D: true,
		});
		gsap.set(this.dot, { scale: 1, backgroundColor: this.color });
		gsap.set(this.ring, {
			scale: 1,
			backgroundColor: 'transparent',
			borderColor: this.color,
		});
		gsap.set(this.label, { opacity: 0 });

		// quickTo keeps movement smooth without creating a new tween per pointermove.
		this.dotX = gsap.quickTo(this.dot, 'x', { duration: 0.05, ease: 'power3.out' });
		this.dotY = gsap.quickTo(this.dot, 'y', { duration: 0.05, ease: 'power3.out' });
		this.ringX = gsap.quickTo(this.ring, 'x', { duration: 0.35, ease: 'power3.out' });
		this.ringY = gsap.quickTo(this.ring, 'y', { duration: 0.35, ease: 'power3.out' });

		gsap.set(this.dot, { opacity: 1 });
		gsap.set(this.ring, { opacity: 0.8 });
		this.isReady = true;

		document.documentElement.classList.add('luxnova-cursor-enabled');

		this.bindEvents();
		this.hasInitialized = true;
	}

	canRun() {
		// Respect touch devices and reduced-motion before creating DOM or listeners.
		return Boolean(
			window.gsap &&
			typeof window.gsap.quickTo === 'function' &&
			window.matchMedia &&
			window.matchMedia('(any-pointer: fine)').matches &&
			!window.matchMedia('(max-width: 900px)').matches &&
			!window.matchMedia('(prefers-reduced-motion: reduce)').matches
		);
	}

	createMarkup() {
		// Runtime markup keeps mobile/reduced-motion users free of cursor DOM.
		this.cursor = document.createElement('div');
		this.cursor.className = 'luxnova-cursor';
		this.cursor.setAttribute('aria-hidden', 'true');
		this.cursor.innerHTML = [
			'<div class="luxnova-cursor__ring"><span class="luxnova-cursor__label"></span></div>',
			'<div class="luxnova-cursor__dot"></div>',
		].join('');

		document.body.appendChild(this.cursor);
		this.dot = this.cursor.querySelector('.luxnova-cursor__dot');
		this.ring = this.cursor.querySelector('.luxnova-cursor__ring');
		this.label = this.cursor.querySelector('.luxnova-cursor__label');
	}

	bindEvents() {
		window.addEventListener('pointermove', this.onPointerMove, { passive: true });
		window.addEventListener('mousemove', this.onPointerMove, { passive: true });
		document.addEventListener('pointermove', this.onPointerMove, { passive: true });
		document.addEventListener('mousemove', this.onPointerMove, { passive: true });
		window.addEventListener('pointerdown', this.onPointerDown, { passive: true });
		document.addEventListener('pointerover', this.onPointerOver, { passive: true });
		document.addEventListener('pointerout', this.onPointerOut, { passive: true });
		window.addEventListener('beforeunload', () => this.destroy(), { once: true });
	}

	move(event) {
		this.lastX = event.clientX;
		this.lastY = event.clientY;

		if (!this.isReady) {
			gsap.to(this.dot, { opacity: 1, duration: 0.18, overwrite: 'auto' });
			gsap.to(this.ring, { opacity: 0.8, duration: 0.18, overwrite: 'auto' });
			this.isReady = true;
		}

		if (this.isHidden) {
			return;
		}

		this.dotX(this.lastX);
		this.dotY(this.lastY);
		this.ringX(this.lastX);
		this.ringY(this.lastY);
	}

	onPointerDown() {
		if (this.isHidden) {
			return;
		}

		gsap.timeline({ defaults: { duration: 0.09, ease: 'power2.out' } })
			.to(this.ring, { scale: this.getStateScale() * 0.85, overwrite: 'auto' })
			.to(this.ring, { scale: this.getStateScale(), overwrite: 'auto' });

		gsap.timeline({ defaults: { duration: 0.09, ease: 'power2.out' } })
			.to(this.dot, { scale: 1.3, overwrite: 'auto' }, 0)
			.to(this.dot, { scale: 1, overwrite: 'auto' });
	}

	onPointerOver(event) {
		const target = event.target;

		if (!(target instanceof Element)) {
			return;
		}

		if (target.closest(this.selectors.disabled)) {
			this.hide();
			return;
		}

		this.show();

		if (target.closest(this.selectors.button)) {
			this.setState('button');
			return;
		}

		if (target.closest(this.selectors.gallery)) {
			this.setState('label', { label: 'OPEN' });
			return;
		}

		if (target.closest(this.selectors.slider)) {
			this.setState('label', { label: 'DRAG' });
			return;
		}

		if (target.closest(this.selectors.link)) {
			this.setState('link');
		}
	}

	onPointerOut(event) {
		const target = event.target;

		if (!(target instanceof Element)) {
			return;
		}

		if (target.closest(this.selectors.disabled)) {
			this.show();
		}

		const buttonTarget = target.closest(this.selectors.button);
		if (buttonTarget) {
			const nextTarget = event.relatedTarget;
			if (!(nextTarget instanceof Element) || !buttonTarget.contains(nextTarget)) {
				this.setState('default');
			}
			return;
		}

		if (
			target.closest(`${this.selectors.button}, ${this.selectors.link}, ${this.selectors.gallery}, ${this.selectors.slider}`)
		) {
			const nextTarget = event.relatedTarget;
			if (nextTarget instanceof Element && nextTarget.closest(`${this.selectors.button}, ${this.selectors.link}, ${this.selectors.gallery}, ${this.selectors.slider}`)) {
				return;
			}
			this.setState('default');
		}
	}

	setState(state, options = {}) {
		if (this.currentState === state && state !== 'label') {
			return;
		}

		this.currentState = state;

		if (state === 'button') {
			this.hideLabel();
			gsap.to(this.ring, {
				scale: 1,
				backgroundColor: 'transparent',
				borderColor: '#ffffff',
				duration: 0.2,
				ease: 'power3.out',
				overwrite: 'auto',
			});
			gsap.to(this.dot, {
				scale: 1,
				backgroundColor: '#ffffff',
				duration: 0.2,
				ease: 'power3.out',
				overwrite: 'auto',
			});
			return;
		}

		if (state === 'link') {
			this.hideLabel();
			gsap.to(this.ring, {
				scale: 1.3,
				backgroundColor: 'transparent',
				borderColor: this.color,
				duration: 0.2,
				ease: 'power3.out',
				overwrite: 'auto',
			});
			gsap.to(this.dot, {
				backgroundColor: this.color,
				duration: 0.2,
				ease: 'power3.out',
				overwrite: 'auto',
			});
			return;
		}

		if (state === 'label') {
			this.showLabel(options.label || '');
			gsap.to(this.ring, {
				scale: 2.6,
				backgroundColor: 'rgba(200, 164, 106, 0.95)',
				borderColor: 'transparent',
				duration: 0.2,
				ease: 'power3.out',
				overwrite: 'auto',
			});
			gsap.to(this.dot, {
				backgroundColor: 'transparent',
				duration: 0.2,
				ease: 'power3.out',
				overwrite: 'auto',
			});
			return;
		}

		this.hideLabel();
		gsap.to(this.ring, {
			scale: 1,
			backgroundColor: 'transparent',
			borderColor: this.color,
			duration: 0.2,
			ease: 'power3.out',
			overwrite: 'auto',
		});
		gsap.to(this.dot, {
			scale: 1,
			backgroundColor: this.color,
			duration: 0.2,
			ease: 'power3.out',
			overwrite: 'auto',
		});
	}

	showLabel(text) {
		if (this.label.textContent !== text) {
			this.label.textContent = text;
		}

		gsap.to(this.label, {
			opacity: 1,
			duration: 0.18,
			ease: 'power2.out',
			overwrite: 'auto',
		});
	}

	hideLabel() {
		gsap.to(this.label, {
			opacity: 0,
			duration: 0.16,
			ease: 'power2.out',
			overwrite: 'auto',
		});
	}

	hide() {
		if (this.isHidden) {
			return;
		}

		this.isHidden = true;
		gsap.to([this.dot, this.ring], {
			opacity: 0,
			duration: 0.12,
			ease: 'power2.out',
			overwrite: 'auto',
		});
	}

	show() {
		if (!this.isHidden) {
			return;
		}

		this.isHidden = false;
		gsap.to(this.dot, {
			opacity: 1,
			duration: 0.16,
			ease: 'power2.out',
			overwrite: 'auto',
		});
		gsap.to(this.ring, {
			opacity: 0.8,
			duration: 0.16,
			ease: 'power2.out',
			overwrite: 'auto',
		});
	}

	getStateScale() {
		if (this.currentState === 'button') {
			return 1;
		}

		if (this.currentState === 'link') {
			return 1.3;
		}

		if (this.currentState === 'label') {
			return 2.6;
		}

		return 1;
	}

	status() {
		return {
			canRun: this.canRun(),
			hasInitialized: this.hasInitialized,
			hasCursor: Boolean(this.cursor && document.body.contains(this.cursor)),
			hasClass: document.documentElement.classList.contains('luxnova-cursor-enabled'),
			isHidden: this.isHidden,
			isReady: this.isReady,
			hasGsap: Boolean(window.gsap),
			hasQuickTo: Boolean(window.gsap && window.gsap.quickTo),
			anyPointerFine: window.matchMedia ? window.matchMedia('(any-pointer: fine)').matches : null,
			reducedMotion: window.matchMedia ? window.matchMedia('(prefers-reduced-motion: reduce)').matches : null,
		};
	}

	destroy() {
		window.removeEventListener('pointermove', this.onPointerMove);
		window.removeEventListener('mousemove', this.onPointerMove);
		document.removeEventListener('pointermove', this.onPointerMove);
		document.removeEventListener('mousemove', this.onPointerMove);
		window.removeEventListener('pointerdown', this.onPointerDown);
		document.removeEventListener('pointerover', this.onPointerOver);
		document.removeEventListener('pointerout', this.onPointerOut);

		document.documentElement.classList.remove('luxnova-cursor-enabled');

		if (this.cursor) {
			this.cursor.remove();
		}
	}
}

const bootLuxnovaCursor = () => {
	const cursor = new LuxnovaCursor();

	try {
		cursor.init();
		window.LuxnovaCursor = cursor;
	} catch (error) {
		cursor.destroy();
		console.warn('LuxNova cursor disabled:', error);
	}
};

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', bootLuxnovaCursor, { once: true });
} else {
	bootLuxnovaCursor();
}
