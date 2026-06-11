/**
 * Noted — Chat Help Widget z driver.js
 * Interaktywny samouczek udający czat AI
 */
(function () {
  'use strict';

  // ─── BAZA WIEDZY (pytania + kroki tour) ──────────────────────────────────────
  const QUESTIONS = [
    {
      id: 'share-notes',
      label: '📤 Jak udostępnić swoje notatki?',
      answer: 'Kliknij przycisk <strong>"Udostępnij notatki"</strong> w sekcji hero na stronie głównej, lub przejdź do swojego profilu. Pokażę Ci to teraz!',
      tourSteps: [
        {
          element: '.vinted-cta-card',
          popover: {
            title: '📋 Karta "Masz własne notatki?"',
            description: 'Tutaj znajdziesz informacje o udostępnianiu notatek.',
            side: 'left',
            align: 'start',
          },
        },
        {
          element: '.vinted-cta-card a, .vinted-cta-card button',
          popover: {
            title: '📤 Udostępnij notatki',
            description: 'Kliknij tutaj, aby przejść do formularza dodawania nowej notatki. Sam decydujesz o cenie lub możesz udostępnić za darmo!',
            side: 'top',
            align: 'center',
          },
        },
      ],
    },
    {
      id: 'search-notes',
      label: '🔍 Jak znaleźć notatki?',
      answer: 'Użyj wyszukiwarki na górze strony lub przeglądaj według kategorii poniżej. Możesz szukać po nazwie, uczelni i opisie!',
      tourSteps: [
        {
          element: '#heroSearchInput',
          popover: {
            title: '🔍 Wyszukiwarka',
            description: 'Wpisz tutaj dowolną frazę — np. "matematyka, UW". Możesz szukać po wielu słowach naraz oddzielając je przecinkiem.',
            side: 'bottom',
            align: 'start',
          },
        },
        {
          element: '#categoryBar',
          popover: {
            title: '📂 Kategorie',
            description: 'Kliknij w dowolną kategorię, aby szybko przefiltrować notatki — np. Informatyka, Medycyna, Prawo.',
            side: 'top',
            align: 'start',
          },
        },
        {
          element: '#notesGrid',
          popover: {
            title: '📚 Katalog notatek',
            description: 'Tutaj wyświetlają się wyniki. Kliknij w kartę notatki, aby zobaczyć szczegóły i podgląd materiału.',
            side: 'top',
            align: 'center',
          },
        },
      ],
    },
    {
      id: 'favorites',
      label: '❤️ Jak zapisać ulubione notatki?',
      answer: 'Kliknij ikonę serca 🤍 na karcie dowolnej notatki, aby dodać ją do ulubionych. Znajdziesz je później w swoim profilu!',
      tourSteps: [
        {
          element: '.fav-btn, .btn-like',
          popover: {
            title: '❤️ Dodaj do ulubionych',
            description: 'Kliknij ikonę serca na dowolnej notatce — zostanie ona zapisana w Twoim profilu w sekcji "Ulubione".',
            side: 'bottom',
            align: 'center',
          },
        },
      ],
    },
  ];

  // ─── MAPOWANIE: akcja czatu → selektor UI na stronie głównej ─────────────────
  const CHAT_HIGHLIGHT_MAP = {
    'share-notes': '#btn-share-notes',
    'favorites': '.fav-btn',
    'search-notes': ['#heroSearchForm', '#categoryBar'],
  };

  const HIGHLIGHT_DURATION_MS = 4000;

  // ─── STAN ─────────────────────────────────────────────────────────────────────
  let isOpen = false;
  let driverInstance = null;
  let activeHighlightEl = null;
  let highlightTimeout = null;

  // ─── INICJALIZACJA DRIVER.JS ─────────────────────────────────────────────────
  function initDriver() {
    if (typeof window.driver === 'undefined' && typeof window.Driver === 'undefined') {
      console.warn('[ChatWidget] driver.js nie załadowany.');
      return null;
    }
    const DriverFn = window.driver?.driver || window.Driver;
    return DriverFn({
      animate: true,
      smoothScroll: true,
      overlayColor: 'rgba(0,0,0,0.7)',
      stagePadding: 12,
      stageRadius: 12,
      allowClose: true,
      showButtons: ['next', 'previous', 'close'],
      nextBtnText: 'Dalej →',
      prevBtnText: '← Wstecz',
      doneBtnText: '✓ Rozumiem!',
      popoverClass: 'noted-driver-popover',
      onDestroyStarted: () => {
        // Reopen/reset questions opacity only if chat panel is still open
        if (isOpen) {
          setTimeout(() => reopenChat(), 400);
        }
      },
    });
  }

  // ─── BUDOWANIE HTML WIDGETU ───────────────────────────────────────────────────
  function buildHTML() {
    const wrap = document.createElement('div');
    wrap.id = 'noted-chat-widget';
    wrap.setAttribute('role', 'complementary');
    wrap.setAttribute('aria-label', 'Asystent AI Noted');
    wrap.innerHTML = `
      <!-- Floating toggle button -->
      <button id="nw-toggle" class="nw-toggle-btn" aria-label="Otwórz Asystenta AI" aria-expanded="false">
        <span class="nw-toggle-icon nw-icon-closed">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </span>
        <span class="nw-toggle-icon nw-icon-open" style="display:none">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </span>
        <span class="nw-toggle-label">Asystent AI</span>
        <span class="nw-badge" id="nw-badge" aria-label="1 nowa wiadomość">1</span>
      </button>

      <!-- Chat panel -->
      <div id="nw-panel" class="nw-panel" role="dialog" aria-modal="true" aria-label="Czat pomocy" hidden>
        <!-- Header -->
        <div class="nw-header">
          <div class="nw-header-info">
            <div class="nw-avatar" aria-hidden="true">🤖</div>
            <div>
              <div class="nw-bot-name">Noted Assistant</div>
              <div class="nw-bot-status">
                <span class="nw-status-dot" aria-hidden="true"></span>
                Online
              </div>
            </div>
          </div>
          <button id="nw-close" class="nw-close-btn" aria-label="Zamknij czat">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
          </button>
        </div>

        <!-- Messages -->
        <div class="nw-messages" id="nw-messages" role="log" aria-live="polite" aria-label="Historia czatu"></div>

        <!-- Quick questions -->
        <div class="nw-questions" id="nw-questions">
          <p class="nw-questions-label">Wybierz pytanie lub kliknij aby dowiedzieć się więcej:</p>
          <div class="nw-questions-list" id="nw-questions-list"></div>
        </div>

        <!-- Footer reset -->
        <div class="nw-footer">
          <button id="nw-reset" class="nw-reset-btn" aria-label="Zacznij od nowa">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
            Zacznij od nowa
          </button>
          <span class="nw-footer-brand">Noted Help</span>
        </div>
      </div>
    `;
    document.body.appendChild(wrap);
  }

  // ─── DODAWANIE WIADOMOŚCI ─────────────────────────────────────────────────────
  function addMessage(html, type = 'bot', withTyping = false) {
    const container = document.getElementById('nw-messages');
    if (!container) return;

    if (type === 'bot' && withTyping) {
      // Show typing indicator first
      const typing = document.createElement('div');
      typing.className = 'nw-message nw-bot nw-typing-wrap';
      typing.setAttribute('aria-label', 'Asystent pisze...');
      typing.innerHTML = `
        <div class="nw-msg-avatar" aria-hidden="true">🤖</div>
        <div class="nw-msg-bubble nw-typing">
          <span></span><span></span><span></span>
        </div>
      `;
      container.appendChild(typing);
      container.scrollTop = container.scrollHeight;

      setTimeout(() => {
        typing.remove();
        appendMessage(container, html, type);
      }, 900);
    } else {
      appendMessage(container, html, type);
    }
  }

  function appendMessage(container, html, type) {
    const msg = document.createElement('div');
    msg.className = `nw-message nw-${type}`;
    if (type === 'bot') {
      msg.innerHTML = `
        <div class="nw-msg-avatar" aria-hidden="true">🤖</div>
        <div class="nw-msg-bubble">${html}</div>
      `;
    } else {
      msg.innerHTML = `<div class="nw-msg-bubble">${html}</div>`;
    }
    container.appendChild(msg);
    requestAnimationFrame(() => {
      msg.classList.add('nw-visible');
      container.scrollTop = container.scrollHeight;
    });
  }

  // ─── RENDEROWANIE PYTAŃ ───────────────────────────────────────────────────────
  function renderQuestions(subset) {
    const list = document.getElementById('nw-questions-list');
    if (!list) return;
    list.innerHTML = '';
    const items = subset || QUESTIONS;
    items.forEach(q => {
      const btn = document.createElement('button');
      btn.className = 'nw-chip';
      btn.dataset.id = q.id;
      btn.textContent = q.label;
      btn.setAttribute('aria-label', `Zapytaj: ${q.label}`);
      list.appendChild(btn);
    });
  }

  // ─── PODŚWIETLANIE ELEMENTÓW UI ───────────────────────────────────────────────
  function resolveHighlightTarget(selector) {
    const selectors = Array.isArray(selector) ? selector : [selector];
    for (const item of selectors) {
      const element = document.querySelector(item);
      if (element) return element;
    }
    return null;
  }

  function clearHighlight() {
    if (highlightTimeout) {
      clearTimeout(highlightTimeout);
      highlightTimeout = null;
    }

    document.querySelectorAll('.chat-highlight-pulse').forEach(el => {
      el.classList.remove('chat-highlight-pulse');
    });

    activeHighlightEl = null;
  }

  function highlightElement(selector) {
    const element = resolveHighlightTarget(selector);
    if (!element) return false;

    clearHighlight();

    element.scrollIntoView({ behavior: 'smooth', block: 'center' });
    element.classList.add('chat-highlight-pulse');
    activeHighlightEl = element;

    highlightTimeout = setTimeout(() => {
      element.classList.remove('chat-highlight-pulse');
      if (activeHighlightEl === element) activeHighlightEl = null;
      highlightTimeout = null;
    }, HIGHLIGHT_DURATION_MS);

    return true;
  }

  // ─── OBSŁUGA PYTANIA ─────────────────────────────────────────────────────────
  function handleQuestion(id) {
    const q = QUESTIONS.find(x => x.id === id);
    if (!q) return;

    // User message
    addMessage(q.label, 'user');

    // Hide question chips temporarily
    const qWrap = document.getElementById('nw-questions');
    if (qWrap) qWrap.style.opacity = '0.4';

    // Bot answer with typing animation
    addMessage(q.answer, 'bot', true);

    const highlightSelector = CHAT_HIGHLIGHT_MAP[id];
    const hasHighlight = Boolean(highlightSelector);
    const hasValidSteps = q.tourSteps && q.tourSteps.some(s => document.querySelector(s.element));

    if (hasHighlight) {
      setTimeout(() => {
        addMessage('Zaraz podświetlę odpowiedni element na stronie ✨', 'bot', false);
      }, 1300);

      setTimeout(() => {
        const highlighted = highlightElement(highlightSelector);

        if (!highlighted && hasValidSteps) {
          startTour(q.tourSteps);
          return;
        }

        setTimeout(() => {
          if (qWrap) qWrap.style.opacity = '';
          if (highlighted) {
            addMessage('Czy mogę pomóc Ci w czymś jeszcze? 😊', 'bot', false);
          }
        }, highlighted ? HIGHLIGHT_DURATION_MS : 0);

        if (!highlighted && !hasValidSteps && qWrap) {
          qWrap.style.opacity = '';
        }
      }, 2400);
    } else if (hasValidSteps) {
      setTimeout(() => {
        addMessage('Zaraz podświetlę odpowiedni element na stronie ✨', 'bot', false);
      }, 1300);

      setTimeout(() => {
        startTour(q.tourSteps);
      }, 2400);
    } else {
      setTimeout(() => {
        if (qWrap) qWrap.style.opacity = '';
      }, 1200);
    }
  }

  // ─── TOUR ─────────────────────────────────────────────────────────────────────
  function startTour(steps) {
    if (!driverInstance) driverInstance = initDriver();
    if (!driverInstance) return;

    // Filter to only steps where element exists
    const validSteps = steps.filter(s => document.querySelector(s.element));
    if (!validSteps.length) {
      reopenChat();
      return;
    }

    driverInstance.setSteps(validSteps);
    driverInstance.drive();
  }

  function reopenChat() {
    const qWrap = document.getElementById('nw-questions');
    if (qWrap) qWrap.style.opacity = '';
    openChatPanel();
    addMessage('Czy mogę pomóc Ci w czymś jeszcze? 😊', 'bot', false);
  }

  // ─── PANEL OPEN/CLOSE ─────────────────────────────────────────────────────────
  function openChatPanel() {
    isOpen = true;
    const panel = document.getElementById('nw-panel');
    const toggle = document.getElementById('nw-toggle');
    const badge = document.getElementById('nw-badge');
    const iconClosed = toggle?.querySelector('.nw-icon-closed');
    const iconOpen = toggle?.querySelector('.nw-icon-open');
    if (panel) { panel.hidden = false; panel.classList.add('nw-panel-open'); }
    if (badge) badge.style.display = 'none';
    if (toggle) { toggle.setAttribute('aria-expanded', 'true'); toggle.classList.add('nw-toggle-active'); }
    if (iconClosed) iconClosed.style.display = 'none';
    if (iconOpen) iconOpen.style.display = '';
    // Focus for accessibility
    setTimeout(() => document.getElementById('nw-close')?.focus(), 100);
  }

  function closeChatPanel() {
    isOpen = false;
    const panel = document.getElementById('nw-panel');
    const toggle = document.getElementById('nw-toggle');
    const iconClosed = toggle?.querySelector('.nw-icon-closed');
    const iconOpen = toggle?.querySelector('.nw-icon-open');
    if (panel) { panel.classList.remove('nw-panel-open'); setTimeout(() => { if (!isOpen) panel.hidden = true; }, 280); }
    if (toggle) { toggle.setAttribute('aria-expanded', 'false'); toggle.classList.remove('nw-toggle-active'); }
    if (iconClosed) iconClosed.style.display = '';
    if (iconOpen) iconOpen.style.display = 'none';

    // Stop active tour if panel is closed
    if (driverInstance && typeof driverInstance.destroy === 'function') {
      driverInstance.destroy();
    }

    clearHighlight();
  }

  // ─── RESET ────────────────────────────────────────────────────────────────────
  function resetChat() {
    const msgs = document.getElementById('nw-messages');
    if (msgs) msgs.innerHTML = '';
    const qWrap = document.getElementById('nw-questions');
    if (qWrap) qWrap.style.opacity = '';
    clearHighlight();
    renderQuestions();
    addGreeting();
  }

  function addGreeting() {
    setTimeout(() => {
      addMessage(
        'Cześć! Jestem <strong>Noted Assistant</strong> 🎓<br>Pomogę Ci poznać platformę. Kliknij pytanie poniżej, a podświetlę odpowiedni element na stronie!',
        'bot',
        true
      );
    }, 200);
  }

  // ─── INIT ─────────────────────────────────────────────────────────────────────
  function init() {
    buildHTML();
    renderQuestions();
    addGreeting();

    // Bind events
    document.getElementById('nw-toggle')?.addEventListener('click', () => {
      isOpen ? closeChatPanel() : openChatPanel();
    });

    document.getElementById('nw-close')?.addEventListener('click', closeChatPanel);

    document.getElementById('nw-reset')?.addEventListener('click', resetChat);

    document.getElementById('nw-questions-list')?.addEventListener('click', e => {
      const chip = e.target.closest('.nw-chip');
      if (chip) handleQuestion(chip.dataset.id);
    });

    // Close on Escape
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && isOpen) closeChatPanel();
    });
  }

  // Start when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
