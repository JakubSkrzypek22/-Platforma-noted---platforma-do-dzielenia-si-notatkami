{{--
  Floating AI chat widget component.
  - Uses fetch to POST `/api/chat` (rate-limited server-side).
  - Stores history in sessionStorage and escapes HTML to prevent XSS.
  - Replaces [note:{id}] tags with rich cards from `notes_metadata`.
--}}

<div id="noted-ai-widget" class="fixed right-4 bottom-6 z-50">
  <div id="noted-ai-button" class="w-14 h-14 rounded-full shadow-lg flex items-center justify-center cursor-pointer bg-white/80 backdrop-blur-md transition-transform transform hover:scale-105">
    <svg class="w-7 h-7 text-indigo-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8-1.091 0-2.14-.154-3.11-.442L3 21l1.442-5.89C3.825 13.06 3 11.62 3 10c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
  </div>

  <div id="noted-ai-panel" class="hidden mt-4 w-96 max-w-xs bg-white/90 dark:bg-gray-800/90 backdrop-blur-md rounded-lg shadow-2xl overflow-hidden">
    <div class="p-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
      <strong class="text-sm">Noted AI</strong>
      <button id="noted-ai-close" class="text-xs text-gray-500">Zamknij</button>
    </div>

    <div id="noted-ai-messages" class="p-3 h-64 overflow-auto space-y-3 text-sm"></div>

    <div class="p-3 border-t border-gray-200 dark:border-gray-700">
      <div class="flex gap-2 mb-2">
        <button class="noted-ai-suggest bg-indigo-50 text-indigo-700 px-2 py-1 rounded text-xs" data-q="Poleć najlepsze notatki do egzaminu">Poleć najlepsze notatki</button>
        <button class="noted-ai-suggest bg-indigo-50 text-indigo-700 px-2 py-1 rounded text-xs" data-q="Szybkie streszczenie notatki: [note:1]">Skróć notatkę</button>
      </div>

      <form id="noted-ai-form" class="flex gap-2">
        <input id="noted-ai-input" type="text" placeholder="Zadaj pytanie..." class="flex-1 rounded px-3 py-2 text-sm border dark:bg-gray-700" />
        <button type="submit" class="bg-indigo-600 text-white px-3 py-2 rounded text-sm">Wyślij</button>
      </form>
    </div>
  </div>
</div>

<script>
// Minimal XSS-safe text -> escaped HTML
function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}

// Replace [note:ID] tags with rich cards using metadata map
function renderWithNotes(rawText, notesMetadata) {
  const container = document.createElement('div');

  // Split by [note:id] tokens keeping them
  const parts = rawText.split(/(\[note:(\d+)\])/g);
  for (let i = 0; i < parts.length; i++) {
    const part = parts[i];
    const match = part.match(/\[note:(\d+)\]/);
    if (match) {
      const id = match[1];
      const meta = notesMetadata.find(n => String(n.id) === String(id));
      if (meta) {
        // Create rich card
        const card = document.createElement('div');
        card.className = 'border rounded p-2 mb-2 bg-white dark:bg-gray-800';
        card.innerHTML = `
          <div class="flex items-center gap-3">
            <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
              <img src="${escapeHtml(meta.thumbnail || '/img/placeholder.png')}" alt="" class="w-full h-full object-cover" />
            </div>
            <div class="flex-1">
              <div class="text-xs text-gray-600">#${escapeHtml(String(meta.id))}</div>
              <div class="font-semibold text-sm">${escapeHtml(meta.title)}</div>
              <div class="text-xs text-gray-500">Cena: ${escapeHtml(String(meta.price ?? '—'))} • Ocena: ${escapeHtml(String(meta.rating ?? '—'))}</div>
            </div>
            <div>
              <a href="/notes/${escapeHtml(String(meta.id))}" class="text-indigo-600 text-xs">Zobacz</a>
            </div>
          </div>
        `;
        container.appendChild(card);
      } else {
        // metadata not found — show raw token escaped
        const span = document.createElement('div');
        span.className = 'text-sm text-gray-700';
        span.innerHTML = escapeHtml(part);
        container.appendChild(span);
      }
    } else if (part.trim() !== '') {
      // normal text
      const p = document.createElement('div');
      p.className = 'text-sm text-gray-800';
      p.innerHTML = escapeHtml(part).replace(/\n/g, '<br/>');
      container.appendChild(p);
    }
  }

  return container.innerHTML;
}

(function () {
  const button = document.getElementById('noted-ai-button');
  const panel = document.getElementById('noted-ai-panel');
  const closeBtn = document.getElementById('noted-ai-close');
  const form = document.getElementById('noted-ai-form');
  const input = document.getElementById('noted-ai-input');
  const messages = document.getElementById('noted-ai-messages');
  const suggests = document.querySelectorAll('.noted-ai-suggest');

  // Load history from sessionStorage
  const HISTORY_KEY = 'noted_ai_history_v1';
  let history = JSON.parse(sessionStorage.getItem(HISTORY_KEY) || '[]');

  function renderHistory() {
    messages.innerHTML = '';
    history.forEach(entry => {
      const div = document.createElement('div');
      div.className = entry.role === 'user' ? 'text-right' : 'text-left';
      if (entry.role === 'user') {
        div.innerHTML = `<div class="inline-block bg-indigo-50 text-indigo-900 px-3 py-1 rounded">${escapeHtml(entry.text)}</div>`;
      } else {
        // AI response may contain [note:id] tokens — render them as cards
        div.innerHTML = renderWithNotes(entry.text, entry.notes_metadata || []);
      }
      messages.appendChild(div);
    });
    messages.scrollTop = messages.scrollHeight;
  }

  // initialize
  renderHistory();

  button.addEventListener('click', () => { panel.classList.toggle('hidden'); });
  closeBtn.addEventListener('click', () => { panel.classList.add('hidden'); });

  suggests.forEach(s => s.addEventListener('click', (e) => {
    input.value = e.currentTarget.dataset.q || '';
  }));

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const q = input.value.trim();
    if (!q) return;

    // append user message
    history.push({ role: 'user', text: q });
    sessionStorage.setItem(HISTORY_KEY, JSON.stringify(history));
    renderHistory();
    input.value = '';

    // show typing indicator
    const typing = document.createElement('div');
    typing.className = 'text-left text-sm text-gray-500';
    typing.textContent = 'Noted AI pisze...';
    messages.appendChild(typing);
    messages.scrollTop = messages.scrollHeight;

    try {
      const res = await fetch('/api/chat', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({ query: q }),
      });

      const json = await res.json();
      // remove typing
      messages.removeChild(typing);

      const aiText = json.ai_response || 'Brak odpowiedzi.';
      const notesMeta = json.notes_metadata || [];

      history.push({ role: 'assistant', text: aiText, notes_metadata: notesMeta });
      sessionStorage.setItem(HISTORY_KEY, JSON.stringify(history));
      renderHistory();
    } catch (err) {
      messages.removeChild(typing);
      const errDiv = document.createElement('div');
      errDiv.className = 'text-sm text-red-600';
      errDiv.textContent = 'Błąd komunikacji z serwerem.';
      messages.appendChild(errDiv);
    }
  });
})();
</script>
