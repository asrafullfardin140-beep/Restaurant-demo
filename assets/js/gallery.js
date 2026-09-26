document.addEventListener('DOMContentLoaded', () => {
    const track = document.getElementById('gallery-track');
    if (!track) return;

    const panels = Array.from(track.querySelectorAll('.gallery-panel'));
    const filters = Array.from(document.querySelectorAll('.gallery-filter'));
    const previousButton = document.getElementById('gallery-prev');
    const nextButton = document.getElementById('gallery-next');
    const currentLabel = document.getElementById('gallery-current');
    const totalLabel = document.getElementById('gallery-total');
    const progressBar = document.getElementById('gallery-progress-bar');
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImage = document.getElementById('lightbox-image');
    const lightboxCaption = document.getElementById('lightbox-caption');
    const lightboxPrevious = lightbox?.querySelector('.gallery-lightbox-prev');
    const lightboxNext = lightbox?.querySelector('.gallery-lightbox-next');
    const lightboxClose = lightbox?.querySelector('.gallery-lightbox-close');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

    let activePanelIndex = 0;
    let activeLightboxIndex = 0;
    let lastFocusedElement = null;
    let scrollFrame = null;
    let isDragging = false;
    let dragStartX = 0;
    let dragStartScroll = 0;
    let dragDistance = 0;

    const visiblePanels = () => panels.filter(panel => !panel.hidden);
    const visibleCards = () => visiblePanels().flatMap(panel => Array.from(panel.querySelectorAll('.gallery-card')));
    const formatNumber = value => String(value).padStart(2, '0');

    function updateControls(index = activePanelIndex) {
        const availablePanels = visiblePanels();
        const safeIndex = Math.max(0, Math.min(index, availablePanels.length - 1));
        activePanelIndex = safeIndex;

        if (currentLabel) currentLabel.textContent = formatNumber(safeIndex + 1);
        if (totalLabel) totalLabel.textContent = formatNumber(availablePanels.length);
        if (progressBar) progressBar.style.width = `${((safeIndex + 1) / availablePanels.length) * 100}%`;
        if (previousButton) previousButton.disabled = safeIndex === 0;
        if (nextButton) nextButton.disabled = safeIndex === availablePanels.length - 1;
    }

    function nearestPanelIndex() {
        const availablePanels = visiblePanels();
        const trackCentre = track.scrollLeft + track.clientWidth / 2;
        let nearestIndex = 0;
        let nearestDistance = Number.POSITIVE_INFINITY;

        availablePanels.forEach((panel, index) => {
            const panelCentre = panel.offsetLeft + panel.offsetWidth / 2;
            const distance = Math.abs(trackCentre - panelCentre);
            if (distance < nearestDistance) {
                nearestDistance = distance;
                nearestIndex = index;
            }
        });
        return nearestIndex;
    }

    function scrollToPanel(index) {
        const availablePanels = visiblePanels();
        const target = availablePanels[Math.max(0, Math.min(index, availablePanels.length - 1))];
        if (!target) return;
        target.scrollIntoView({
            behavior: reducedMotion.matches ? 'auto' : 'smooth',
            block: 'nearest',
            inline: 'center'
        });
        updateControls(availablePanels.indexOf(target));
    }

    track.addEventListener('scroll', () => {
        if (scrollFrame) cancelAnimationFrame(scrollFrame);
        scrollFrame = requestAnimationFrame(() => updateControls(nearestPanelIndex()));
    }, { passive: true });

    // Mouse dragging complements native touch swiping without adding a carousel library.
    track.addEventListener('pointerdown', event => {
        if (event.pointerType !== 'mouse' || event.button !== 0) return;
        isDragging = true;
        dragStartX = event.clientX;
        dragStartScroll = track.scrollLeft;
        dragDistance = 0;
        track.classList.add('is-dragging');
        track.setPointerCapture(event.pointerId);
    });

    track.addEventListener('pointermove', event => {
        if (!isDragging) return;
        dragDistance = event.clientX - dragStartX;
        track.scrollLeft = dragStartScroll - dragDistance;
    });

    function finishDrag(event) {
        if (!isDragging) return;
        isDragging = false;
        track.classList.remove('is-dragging');
        if (track.hasPointerCapture(event.pointerId)) track.releasePointerCapture(event.pointerId);
        if (Math.abs(dragDistance) > 8) scrollToPanel(nearestPanelIndex());
    }

    track.addEventListener('pointerup', finishDrag);
    track.addEventListener('pointercancel', finishDrag);
    track.addEventListener('click', event => {
        if (Math.abs(dragDistance) <= 8) return;
        event.preventDefault();
        event.stopPropagation();
        dragDistance = 0;
    }, true);

    previousButton?.addEventListener('click', () => scrollToPanel(activePanelIndex - 1));
    nextButton?.addEventListener('click', () => scrollToPanel(activePanelIndex + 1));

    track.addEventListener('keydown', event => {
        if (event.key === 'ArrowRight') {
            event.preventDefault();
            scrollToPanel(activePanelIndex + 1);
        }
        if (event.key === 'ArrowLeft') {
            event.preventDefault();
            scrollToPanel(activePanelIndex - 1);
        }
    });

    filters.forEach(filterButton => {
        filterButton.addEventListener('click', () => {
            const filter = filterButton.dataset.filter;
            filters.forEach(button => {
                const isActive = button === filterButton;
                button.classList.toggle('is-active', isActive);
                button.setAttribute('aria-pressed', String(isActive));
            });

            panels.forEach(panel => {
                const categories = panel.dataset.category?.split(' ') || [];
                panel.hidden = filter !== 'all' && !categories.includes(filter);
            });

            track.scrollTo({ left: 0, behavior: reducedMotion.matches ? 'auto' : 'smooth' });
            updateControls(0);
        });
    });

    function renderLightbox() {
        const cards = visibleCards();
        const card = cards[activeLightboxIndex];
        const image = card?.querySelector('img');
        if (!image || !lightboxImage || !lightboxCaption) return;
        lightboxImage.src = image.currentSrc || image.src;
        lightboxImage.alt = image.alt;
        lightboxCaption.textContent = card.dataset.caption || image.alt;
        if (lightboxPrevious) lightboxPrevious.disabled = cards.length < 2;
        if (lightboxNext) lightboxNext.disabled = cards.length < 2;
    }

    function openLightbox(card) {
        if (!lightbox) return;
        const cards = visibleCards();
        activeLightboxIndex = Math.max(0, cards.indexOf(card));
        lastFocusedElement = document.activeElement;
        renderLightbox();
        lightbox.hidden = false;
        document.body.classList.add('gallery-lightbox-open');
        lightboxClose?.focus();
    }

    function closeLightbox() {
        if (!lightbox || lightbox.hidden) return;
        lightbox.hidden = true;
        document.body.classList.remove('gallery-lightbox-open');
        if (lastFocusedElement instanceof HTMLElement) lastFocusedElement.focus();
    }

    function changeLightbox(direction) {
        const cards = visibleCards();
        if (cards.length < 2) return;
        activeLightboxIndex = (activeLightboxIndex + direction + cards.length) % cards.length;
        renderLightbox();
    }

    panels.forEach(panel => {
        panel.querySelectorAll('.gallery-card').forEach(card => {
            card.addEventListener('click', () => openLightbox(card));
        });
    });

    lightbox?.querySelectorAll('[data-lightbox-close]').forEach(element => {
        element.addEventListener('click', closeLightbox);
    });
    lightboxPrevious?.addEventListener('click', () => changeLightbox(-1));
    lightboxNext?.addEventListener('click', () => changeLightbox(1));

    document.addEventListener('keydown', event => {
        if (!lightbox || lightbox.hidden) return;
        if (event.key === 'Escape') closeLightbox();
        if (event.key === 'ArrowLeft') changeLightbox(-1);
        if (event.key === 'ArrowRight') changeLightbox(1);
        if (event.key === 'Tab') {
            const focusable = Array.from(lightbox.querySelectorAll('button:not(:disabled)'));
            const first = focusable[0];
            const last = focusable[focusable.length - 1];
            if (event.shiftKey && document.activeElement === first) {
                event.preventDefault();
                last?.focus();
            } else if (!event.shiftKey && document.activeElement === last) {
                event.preventDefault();
                first?.focus();
            }
        }
    });

    updateControls(0);
});
