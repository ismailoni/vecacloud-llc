/**
 * Omni Solutions Theme - Main JavaScript
 * @package Omni_Solutions
 */

(function() {
	'use strict';

	/**
	 * Mobile Menu Toggle
	 */
	function initMobileMenu() {
		const menuToggle = document.querySelector('.menu-toggle');
		const primaryMenu = document.getElementById('primary-menu');
		const navigation = document.querySelector('.main-navigation');

		if (menuToggle && primaryMenu && navigation) {
			menuToggle.addEventListener('click', function() {
				const isExpanded = menuToggle.getAttribute('aria-expanded') === 'true';
				menuToggle.setAttribute('aria-expanded', !isExpanded);
				navigation.classList.toggle('active');
			});

			// Close menu when a link is clicked
			const menuLinks = navigation.querySelectorAll('a');
			menuLinks.forEach(link => {
				link.addEventListener('click', function() {
					menuToggle.setAttribute('aria-expanded', 'false');
					navigation.classList.remove('active');
				});
			});
		}
	}

	/**
	 * Smooth Scroll for Anchor Links
	 */
	function initSmoothScroll() {
		document.querySelectorAll('a[href^="#"]').forEach(anchor => {
			anchor.addEventListener('click', function(e) {
				const href = this.getAttribute('href');
				if (href !== '#' && document.querySelector(href)) {
					e.preventDefault();
					document.querySelector(href).scrollIntoView({
						behavior: 'smooth'
					});
				}
			});
		});
	}

	/**
	 * Sticky Header on Scroll
	 */
	function initStickyHeader() {
		const header = document.querySelector('header.site-header');
		if (!header) return;

		let lastScrollTop = 0;
		let isScrolling = false;

		window.addEventListener('scroll', function() {
			if (isScrolling) return;
			isScrolling = true;

			const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

			if (scrollTop > 100) {
				header.classList.add('scrolled');
			} else {
				header.classList.remove('scrolled');
			}

			lastScrollTop = scrollTop;
			isScrolling = false;
		}, { passive: true });
	}

	/**
	 * Image Lazy Loading
	 */
	function initLazyLoading() {
		if ('IntersectionObserver' in window) {
			const lazyImages = document.querySelectorAll('img[data-src]');
			const imageObserver = new IntersectionObserver((entries, observer) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						const img = entry.target;
						img.src = img.dataset.src;
						img.classList.add('loaded');
						observer.unobserve(img);
					}
				});
			});

			lazyImages.forEach(img => imageObserver.observe(img));
		}
	}

	/**
	 * Form Validation
	 */
	function initFormValidation() {
		const forms = document.querySelectorAll('form');
		forms.forEach(form => {
			form.addEventListener('submit', function(e) {
				let isValid = true;
				const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');

				inputs.forEach(input => {
					if (!input.value.trim()) {
						isValid = false;
						input.classList.add('error');
					} else {
						input.classList.remove('error');
					}
				});

				if (!isValid) {
					e.preventDefault();
				}
			});

			// Remove error class on input
			const inputs = form.querySelectorAll('input, textarea, select');
			inputs.forEach(input => {
				input.addEventListener('change', function() {
					this.classList.remove('error');
				});
			});
		});
	}

	/**
	 * Carousel/Slider Functionality (if needed)
	 */
	function initCarousels() {
		const carousels = document.querySelectorAll('[data-carousel]');
		carousels.forEach(carousel => {
			const items = carousel.querySelectorAll('[data-carousel-item]');
			const prevBtn = carousel.querySelector('[data-carousel-prev]');
			const nextBtn = carousel.querySelector('[data-carousel-next]');
			let currentIndex = 0;

			if (items.length === 0) return;

			function showItem(index) {
				items.forEach((item, i) => {
					item.style.display = i === index ? 'block' : 'none';
				});
			}

			function nextItem() {
				currentIndex = (currentIndex + 1) % items.length;
				showItem(currentIndex);
			}

			function prevItem() {
				currentIndex = (currentIndex - 1 + items.length) % items.length;
				showItem(currentIndex);
			}

			if (prevBtn) prevBtn.addEventListener('click', prevItem);
			if (nextBtn) nextBtn.addEventListener('click', nextItem);

			showItem(currentIndex);
		});
	}

	/**
	 * Animate elements on scroll
	 */
	function initScrollAnimations() {
		if ('IntersectionObserver' in window) {
			const elements = document.querySelectorAll('[data-animate]');
			const observer = new IntersectionObserver((entries) => {
				entries.forEach(entry => {
					if (entry.isIntersecting) {
						entry.target.classList.add('animated');
						observer.unobserve(entry.target);
					}
				});
			}, { threshold: 0.1 });

			elements.forEach(el => observer.observe(el));
		}
	}

	/**
	 * Global toast notifications
	 */
	function showToast(message, type = 'success') {
		if (!message) return;
		const toast = document.getElementById('omni-toast');
		if (!toast) return;

		const allowedTypes = ['success', 'error', 'info', 'warning'];
		const toastType = allowedTypes.includes(type) ? type : 'success';

		toast.textContent = message;
		toast.classList.remove('visible', 'success', 'error', 'info', 'warning');
		toast.classList.add('visible', toastType);

		if (window.omniToastTimeout) {
			clearTimeout(window.omniToastTimeout);
		}
		window.omniToastTimeout = setTimeout(function() {
			toast.classList.remove('visible', 'success', 'error', 'info', 'warning');
		}, 4000);
	}

	/**
	 * Initialize all scripts when DOM is ready
	 */
	document.addEventListener('DOMContentLoaded', function() {
		initMobileMenu();
		initSmoothScroll();
		initStickyHeader();
		initLazyLoading();
		initFormValidation();
		initCarousels();
		initScrollAnimations();
	});

	// Expose global functions while preserving localized data (e.g., ajaxUrl)
	window.omniSolutions = Object.assign(window.omniSolutions || {}, {
		initMobileMenu,
		initSmoothScroll,
		initStickyHeader,
		initLazyLoading,
		initFormValidation,
		initCarousels,
		initScrollAnimations,
		showToast,
	});
})();
