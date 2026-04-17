<!-- Chatbot Widget - YonoMobilindo (Bootstrap) -->
<style>
    #chatbot-container {
        z-index: 9999;
    }

    #chatbot-toggle {
        width: 56px;
        height: 56px;
        border: none;
        font-size: 20px;
        color: #fcf259;
        background: #27548a;
    }

    #chatbot-box {
        position: absolute;
        right: 0;
        bottom: 68px;
        width: 340px;
        height: 500px;
        border: 1px solid rgba(39, 84, 138, 0.15);
        border-radius: 1rem;
        background: #fffdf6;
    }

    .chatbot-header {
        background: #27548a;
    }

    .chatbot-brand {
        font-size: 15px;
    }

    .chatbot-subtitle {
        font-size: 11px;
        color: rgba(255, 255, 255, 0.7);
    }

    .chatbot-clear-btn {
        border: 1px solid rgba(252, 242, 89, 0.4);
        font-size: 11px;
        color: #fcf259;
        background: rgba(255, 255, 255, 0.1);
    }

    .chatbot-close-btn {
        width: 32px;
        height: 32px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        color: #fffdf6;
        background: rgba(255, 255, 255, 0.1);
    }

    #chatbot-messages {
        background: #f8f6ef;
    }

    .chatbot-input-wrap {
        border-top: 1px solid rgba(39, 84, 138, 0.12);
        background: #fffdf6;
    }

    #chatbot-input {
        font-size: 13px;
        border-color: rgba(39, 84, 138, 0.25);
        background: #fffdf6;
    }

    #chatbot-send {
        border: none;
        color: #fcf259 !important;
        background: #27548a;
    }

    .chatbot-welcome-bubble {
        max-width: 90%;
        border: 1px solid rgba(39, 84, 138, 0.15);
        border-radius: 16px 16px 16px 4px !important;
        font-size: 13px;
        line-height: 1.65;
        background: #fffdf6;
    }

    #chatbot-box .chatbot-bubble {
        max-width: 82%;
        font-size: 13px;
        line-height: 1.4;
        white-space: pre-wrap;
    }

    #chatbot-box .chatbot-bubble-user {
        border-radius: 16px 16px 4px 16px;
        color: #fffdf6;
        background: #27548a;
        padding: 0.75rem 1rem;
    }

    #chatbot-box .chatbot-bubble-bot {
        border: 1px solid rgba(39, 84, 138, 0.15);
        border-radius: 16px 16px 16px 4px;
        color: #171513;
        background: #fffdf6;
        padding: 0.375rem 0.75rem !important;
    }

    #chatbot-box .chatbot-car-card {
        margin-top: 6px !important;
        overflow: hidden !important;
        border: 1px solid rgba(39, 84, 138, 0.16) !important;
        border-radius: 12px !important;
        background: #ffffff !important;
    }

    #chatbot-box .chatbot-car-thumb-wrap {
        position: relative !important;
        display: block !important;
        margin: 0 !important;
        padding: 0 !important;
        line-height: 0 !important;
        cursor: zoom-in !important;
    }

    #chatbot-box .chatbot-car-thumb {
        display: block !important;
        width: 100% !important;
        height: 150px !important;
        margin: 0 !important;
        object-fit: cover !important;
    }

    #chatbot-box .chatbot-car-thumb-zoom-hint {
        position: absolute !important;
        right: 8px !important;
        bottom: 8px !important;
        border-radius: 999px !important;
        padding: 3px 8px !important;
        font-size: 10px !important;
        line-height: 1.2 !important;
        color: #fff !important;
        background: rgba(0, 0, 0, 0.55) !important;
        pointer-events: none !important;
    }

    #chatbot-box .chatbot-car-footer {
        margin: 0 !important;
        padding: 8px !important;
        border-top: 1px solid rgba(39, 84, 138, 0.12) !important;
        background: #fff !important;
    }

    #chatbot-box .chatbot-car-link,
    #chatbot-box .chatbot-car-link:visited,
    #chatbot-box .chatbot-car-link:hover,
    #chatbot-box .chatbot-car-link:focus {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 100% !important;
        min-height: 34px !important;
        margin: 0 !important;
        padding: 6px 10px !important;
        gap: 6px !important;
        border: 1px solid #27548a !important;
        border-radius: 8px !important;
        text-decoration: none !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        line-height: 1 !important;
        white-space: nowrap !important;
        color: #ffffff !important;
        background: #27548a !important;
    }

    #chatbot-box .chatbot-car-link:hover,
    #chatbot-box .chatbot-car-link:focus {
        border-color: #1f436f !important;
        background: #1f436f !important;
    }

    .chatbot-image-viewer {
        position: fixed;
        inset: 0;
        z-index: 100000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(0, 0, 0, 0.8);
    }

    .chatbot-image-viewer.active {
        display: flex;
    }

    .chatbot-image-viewer img {
        max-width: min(92vw, 980px);
        max-height: 88vh;
        border-radius: 14px;
    }

    .chatbot-image-viewer-close {
        position: absolute;
        top: 14px;
        right: 16px;
        width: 36px;
        height: 36px;
        border: none;
        border-radius: 999px;
        font-size: 20px;
        line-height: 1;
        color: #fff;
        background: rgba(255, 255, 255, 0.2);
    }
</style>

<div id="chatbot-container" class="position-fixed bottom-0 end-0 p-3 me-3">
    <button id="chatbot-toggle" class="btn rounded-circle d-flex align-items-center justify-content-center shadow">
        <i class="fa-solid fa-comment-dots"></i>
    </button>

    <div id="chatbot-box" class="d-none flex-column position-absolute shadow rounded-4 overflow-hidden">
        <div class="chatbot-header d-flex justify-content-between align-items-center px-3 py-2 flex-shrink-0">
            <div>
                <div class="chatbot-brand fw-bold d-flex align-items-center gap-2">
                    <i class="fa-solid fa-car" style="color:#fcf259;font-size:13px;"></i>
                    <span style="color:#fffdf6;">Yono</span><span style="color:#fcf259;">Mobilindo</span>
                </div>
                <div class="chatbot-subtitle">Asisten virtual jual beli mobil</div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <button id="clear-chat" class="chatbot-clear-btn btn btn-sm d-flex align-items-center gap-1">
                    <i class="fa-solid fa-trash-can text-danger" style="font-size:10px;"></i>
                </button>
                <button id="chatbot-close" class="chatbot-close-btn btn btn-sm d-flex align-items-center justify-content-center">
                    <i class="fa-solid fa-xmark" style="font-size:14px;"></i>
                </button>
            </div>
        </div>

        <div id="chatbot-messages" class="flex-grow-1 overflow-auto p-3 d-flex flex-column gap-2"></div>

        <div class="chatbot-input-wrap d-flex gap-2 p-2 flex-shrink-0">
            <input id="chatbot-input" type="text" class="form-control rounded-pill" placeholder="Ketik pesan...">
            <button id="chatbot-send" class="btn rounded-pill px-3 d-flex align-items-center">
                <i class="fa-solid fa-paper-plane" style="font-size:13px;"></i>
            </button>
        </div>
    </div>
</div>

<div id="chatbot-image-viewer" class="chatbot-image-viewer" aria-hidden="true">
    <button id="chatbot-image-viewer-close" class="chatbot-image-viewer-close" type="button" aria-label="Tutup preview gambar">
        &times;
    </button>
    <img id="chatbot-image-viewer-img" src="" alt="Preview mobil">
</div>

<script>
    (function () {
        const el = {
            toggle: document.getElementById('chatbot-toggle'),
            box: document.getElementById('chatbot-box'),
            input: document.getElementById('chatbot-input'),
            sendBtn: document.getElementById('chatbot-send'),
            messages: document.getElementById('chatbot-messages'),
            clearBtn: document.getElementById('clear-chat'),
            closeBtn: document.getElementById('chatbot-close'),
            imageViewer: document.getElementById('chatbot-image-viewer'),
            imageViewerImg: document.getElementById('chatbot-image-viewer-img'),
            imageViewerClose: document.getElementById('chatbot-image-viewer-close'),
        };

        const STORAGE_KEY = 'yono_chatbot_history';
        const CAR_PHOTO_STORAGE_KEY = 'yono_chatbot_car_photos';
        const FALLBACK_CAR_IMAGE = '{{ asset("image/NoImage.png") }}';
        const DETAIL_MOBIL_BASE_URL = '{{ url("/web/detailMobil") }}';

        let history = parseStorage(STORAGE_KEY, []);
        let carPhotoMap = parseStorage(CAR_PHOTO_STORAGE_KEY, {});

        function parseStorage(key, fallback) {
            try {
                const parsed = JSON.parse(localStorage.getItem(key));
                return parsed ?? fallback;
            } catch (error) {
                return fallback;
            }
        }

        function saveStorage(key, value) {
            try {
                localStorage.setItem(key, JSON.stringify(value));
            } catch (error) {}
        }

        function saveHistory() {
            saveStorage(STORAGE_KEY, history);
        }

        function saveCarPhotoMap() {
            saveStorage(CAR_PHOTO_STORAGE_KEY, carPhotoMap);
        }

        function applyResponsiveLayout() {
            if (window.innerWidth < 768) {
                el.box.style.cssText = `
                    position: fixed !important;
                    top: 0 !important;
                    left: 0 !important;
                    right: 0 !important;
                    bottom: 0 !important;
                    width: 100vw !important;
                    height: 100dvh !important;
                    border-radius: 0 !important;
                    z-index: 99999 !important;
                `;
                return;
            }

            el.box.style.cssText = `
                position: absolute;
                bottom: 68px;
                right: 0;
                width: 340px;
                height: 500px;
                border-radius: 1rem;
                border: 1px solid rgba(39,84,138,0.15);
                background: #fffdf6;
                z-index: auto;
            `;
        }

        function openChatbot() {
            el.box.classList.remove('d-none');
            el.box.classList.add('d-flex');
            applyResponsiveLayout();
            el.messages.scrollTop = el.messages.scrollHeight;
            el.input.focus();
        }

        function closeChatbot() {
            el.box.classList.add('d-none');
            el.box.classList.remove('d-flex');
        }

        function addWelcomeMessage() {
            const container = document.createElement('div');
            container.className = 'd-flex';
            container.innerHTML = `
                <div class="chatbot-welcome-bubble rounded-4 p-3">
                    Halo! Saya asisten <b style="color:#27548a;">YonoMobilindo</b>
                    <i class="fa-solid fa-car ms-1" style="color:#27548a;font-size:12px;"></i><br><br>
                    Ada yang bisa saya bantu?<br>
                    <span style="color:#867e77;font-size:12px;">
                        &bull; "Tampilkan mobil di bawah 100 juta"<br>
                        &bull; "Rekomendasikan mobil keluarga"<br>
                        &bull; "Ada mobil transmisi otomatis?"
                    </span>
                </div>
            `;
            el.messages.appendChild(container);
        }

        function escapeHTML(rawText) {
            return rawText
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');
        }

        function buildCarCard(carId, photoUrl) {
            return `<div class="chatbot-car-card"><div class="chatbot-car-thumb-wrap js-chatbot-thumb" data-image="${photoUrl}"><img src="${photoUrl}" alt="Mobil ${carId}" class="chatbot-car-thumb" loading="lazy" onerror="this.onerror=null;this.src='${FALLBACK_CAR_IMAGE}';"><span class="chatbot-car-thumb-zoom-hint"><i class="fa-solid fa-magnifying-glass-plus"></i> Perbesar</span></div><div class="chatbot-car-footer"><a href="${DETAIL_MOBIL_BASE_URL}/${carId}" class="chatbot-car-link"><i class="fa-solid fa-arrow-up-right-from-square"></i><span>Lihat Detail</span></a></div></div>`;
        }

        function renderBotMessage(content, carPhotos = {}) {
            if (Object.keys(carPhotos).length > 0) {
                carPhotoMap = { ...carPhotoMap, ...carPhotos };
                saveCarPhotoMap();
            }

            const escaped = escapeHTML(content);
            return escaped
                .replace(/\n+\[CAR_ID:(\d+)\]/g, '\n[CAR_ID:$1]')
                .replace(/\[CAR_ID:(\d+)\]/g, (match, carId) => {
                    const photoUrl = carPhotos[carId] || carPhotoMap[carId] || FALLBACK_CAR_IMAGE;
                    return buildCarCard(carId, photoUrl);
                })
                .replace(/\n{3,}/g, '\n\n');
        }

        function addMessage(content, role, options = {}) {
            const isUser = role === 'user';
            const wrapper = document.createElement('div');
            wrapper.className = `d-flex ${isUser ? 'justify-content-end' : 'justify-content-start'}`;

            const bubble = document.createElement('div');
            bubble.className = `chatbot-bubble ${isUser ? 'chatbot-bubble-user' : 'chatbot-bubble-bot'}`;

            if (isUser) {
                bubble.textContent = content;
            } else {
                bubble.innerHTML = renderBotMessage(content, options.carPhotos || {});
            }

            wrapper.appendChild(bubble);
            el.messages.appendChild(wrapper);
            el.messages.scrollTop = el.messages.scrollHeight;
        }

        function addTypingIndicator() {
            const wrapper = document.createElement('div');
            wrapper.id = 'typing-wrap';
            wrapper.className = 'd-flex justify-content-start';
            wrapper.innerHTML = `
                <div class="p-2 px-3" style="font-size:13px;border-radius:16px 16px 16px 4px;background:#fffdf6;color:#867e77;border:1px solid rgba(39,84,138,0.15);">
                    <span class="me-1">Mengetik</span>
                    <span class="spinner-grow spinner-grow-sm" style="color:#27548a;width:5px;height:5px;"></span>
                    <span class="spinner-grow spinner-grow-sm mx-1" style="color:#27548a;width:5px;height:5px;animation-delay:0.15s;"></span>
                    <span class="spinner-grow spinner-grow-sm" style="color:#27548a;width:5px;height:5px;animation-delay:0.3s;"></span>
                </div>
            `;
            el.messages.appendChild(wrapper);
            el.messages.scrollTop = el.messages.scrollHeight;
        }

        function removeTypingIndicator() {
            const typingElement = document.getElementById('typing-wrap');
            if (typingElement) typingElement.remove();
        }

        function openImageViewer(src) {
            el.imageViewerImg.src = src || FALLBACK_CAR_IMAGE;
            el.imageViewer.classList.add('active');
            el.imageViewer.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeImageViewer() {
            el.imageViewer.classList.remove('active');
            el.imageViewer.setAttribute('aria-hidden', 'true');
            el.imageViewerImg.src = '';
            document.body.style.overflow = '';
        }

        function renderHistory() {
            el.messages.innerHTML = '';
            addWelcomeMessage();
            history.forEach((chat) => {
                if (chat.role === 'system') return;
                const role = chat.role === 'user' ? 'user' : 'bot';
                addMessage(chat.content, role, { carPhotos: chat.carPhotos || {} });
            });
            el.messages.scrollTop = el.messages.scrollHeight;
        }

        async function sendMessage() {
            const text = el.input.value.trim();
            if (!text) return;

            el.input.value = '';
            addMessage(text, 'user');
            history.push({ role: 'user', content: text });
            saveHistory();

            addTypingIndicator();
            el.sendBtn.disabled = true;
            el.input.disabled = true;

            try {
                const response = await fetch('{{ route("chatbot.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ message: text, history }),
                });

                const data = await response.json();
                const reply = data.reply || 'Maaf, tidak ada respons.';
                const carPhotos = data.carPhotos || {};

                removeTypingIndicator();
                addMessage(reply, 'bot', { carPhotos });
                history.push({ role: 'assistant', content: reply, carPhotos });
                saveHistory();
            } catch (error) {
                removeTypingIndicator();
                addMessage('Maaf, terjadi kesalahan koneksi. Coba lagi.', 'bot');
            } finally {
                el.sendBtn.disabled = false;
                el.input.disabled = false;
                el.input.focus();
            }
        }

        el.toggle.addEventListener('click', () => {
            const isOpen = !el.box.classList.contains('d-none');
            if (isOpen) {
                closeChatbot();
            } else {
                openChatbot();
            }
        });

        el.closeBtn.addEventListener('click', closeChatbot);
        el.clearBtn.addEventListener('click', () => {
            history = [];
            localStorage.removeItem(STORAGE_KEY);
            renderHistory();
        });

        el.sendBtn.addEventListener('click', sendMessage);
        el.input.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && !event.shiftKey) sendMessage();
        });

        el.messages.addEventListener('click', (event) => {
            const thumbWrap = event.target.closest('.js-chatbot-thumb');
            if (!thumbWrap) return;
            openImageViewer(thumbWrap.getAttribute('data-image'));
        });

        el.imageViewerClose.addEventListener('click', closeImageViewer);
        el.imageViewer.addEventListener('click', (event) => {
            if (event.target === el.imageViewer) closeImageViewer();
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && el.imageViewer.classList.contains('active')) {
                closeImageViewer();
            }
        });

        window.addEventListener('resize', () => {
            if (!el.box.classList.contains('d-none')) applyResponsiveLayout();
        });

        renderHistory();
    })();
</script>
