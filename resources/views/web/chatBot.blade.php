<!-- Chatbot Widget - YonoMobilindo (Bootstrap) -->
<div id="chatbot-container" class="position-fixed bottom-0 end-0 p-3 me-3" style="z-index:9999;">

    {{-- Toggle Button --}}
    <button id="chatbot-toggle" class="btn rounded-circle d-flex align-items-center justify-content-center shadow"
        style="width:56px;height:56px;background:#27548a;color:#fcf259;border:none;font-size:20px;">
        <i class="fa-solid fa-comment-dots"></i>
    </button>

    {{-- Chat Window --}}
    <div id="chatbot-box" class="d-none flex-column position-absolute shadow rounded-4 overflow-hidden" style="bottom:68px;right:0;width:340px;height:500px;
               background:#fffdf6;border:1px solid rgba(39,84,138,0.15);">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center px-3 py-2 flex-shrink-0"
            style="background:#27548a;">
            <div>
                <div class="fw-bold d-flex align-items-center gap-2" style="font-size:15px;">
                    <i class="fa-solid fa-car" style="color:#fcf259;font-size:13px;"></i>
                    <span style="color:#fffdf6;">Yono</span><span style="color:#fcf259;">Mobilindo</span>
                </div>
                <div style="font-size:11px;color:rgba(255,255,255,0.7);">Asisten virtual jual beli mobil</div>
            </div>

            <div class="d-flex align-items-center gap-2">
                {{-- Tombol Hapus --}}
                <button id="clear-chat" class="btn btn-sm d-flex align-items-center gap-1" style="background:rgba(255,255,255,0.1);border:1px solid rgba(252,242,89,0.4);
                   color:#fcf259;font-size:11px;">
                    <i class="fa-solid fa-trash-can text-danger" style="font-size:10px; "></i>
                    {{-- <span class="d-none d-md-inline">Hapus</span> --}}
                </button>

                {{-- ✅ Tombol Close (tampil di semua device) --}}
                <button id="chatbot-close" class="btn btn-sm d-flex align-items-center justify-content-center" style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.3);
                   color:#fffdf6;width:32px;height:32px;border-radius:50%;">
                    <i class="fa-solid fa-xmark" style="font-size:14px;"></i>
                </button>
            </div>
        </div>

        {{-- Messages --}}
        <div id="chatbot-messages" class="flex-grow-1 overflow-auto p-3 d-flex flex-column gap-2"
            style="background:#f8f6ef;">
        </div>

        {{-- Input --}}
        <div class="d-flex gap-2 p-2 flex-shrink-0"
            style="border-top:1px solid rgba(39,84,138,0.12);background:#fffdf6;">
            <input id="chatbot-input" type="text" class="form-control rounded-pill" placeholder="Ketik pesan..."
                style="font-size:13px;border-color:rgba(39,84,138,0.25);background:#fffdf6;">
            <button id="chatbot-send" class="btn rounded-pill px-3 d-flex align-items-center btn btn-login"
                style="background:#27548a;color:#fcf259 !important;border:none;">
                <i class="fa-solid fa-paper-plane" style="font-size:13px; color:#fcf259 "></i>
            </button>
        </div>
    </div>
</div>

<style>
    #chatbot-box .chatbot-car-card {
        margin: 6px 0 0 !important;
        background: #ffffff !important;
        border: 1px solid rgba(39, 84, 138, 0.16) !important;
        border-radius: 12px !important;
        overflow: hidden !important;
    }

    #chatbot-box .chatbot-car-thumb-wrap {
        position: relative !important;
        cursor: zoom-in !important;
        display: block !important;
        line-height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    #chatbot-box .chatbot-car-thumb {
        width: 100% !important;
        height: 150px !important;
        object-fit: cover !important;
        display: block !important;
        margin: 0 !important;
    }

    #chatbot-box .chatbot-car-thumb-zoom-hint {
        position: absolute !important;
        right: 8px !important;
        bottom: 8px !important;
        background: rgba(0, 0, 0, 0.55) !important;
        color: #fff !important;
        font-size: 10px !important;
        border-radius: 999px !important;
        padding: 3px 8px !important;
        pointer-events: none !important;
        line-height: 1.2 !important;
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
        width: 100% !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        color: #ffffff !important;
        text-decoration: none !important;
        background: #27548a !important;
        border: 1px solid #27548a !important;
        border-radius: 8px !important;
        min-height: 34px !important;
        padding: 6px 10px !important;
        margin: 0 !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        line-height: 1 !important;
        white-space: nowrap !important;
    }

    #chatbot-box .chatbot-car-link:hover,
    #chatbot-box .chatbot-car-link:focus {
        background: #1f436f !important;
        border-color: #1f436f !important;
    }

    .chatbot-image-viewer {
        position: fixed;
        inset: 0;
        z-index: 100000;
        background: rgba(0, 0, 0, 0.8);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
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
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
    }
</style>

<div id="chatbot-image-viewer" class="chatbot-image-viewer" aria-hidden="true">
    <button id="chatbot-image-viewer-close" class="chatbot-image-viewer-close" type="button" aria-label="Tutup preview gambar">
        &times;
    </button>
    <img id="chatbot-image-viewer-img" src="" alt="Preview mobil">
</div>

<script>
    (function () {
        const toggle = document.getElementById('chatbot-toggle');
        const box = document.getElementById('chatbot-box');
        const input = document.getElementById('chatbot-input');
        const sendBtn = document.getElementById('chatbot-send');
        const msgs = document.getElementById('chatbot-messages');
        const clearBtn = document.getElementById('clear-chat');
        const imageViewer = document.getElementById('chatbot-image-viewer');
        const imageViewerImg = document.getElementById('chatbot-image-viewer-img');
        const imageViewerClose = document.getElementById('chatbot-image-viewer-close');

        const STORAGE_KEY = 'yono_chatbot_history';
        const CAR_PHOTO_STORAGE_KEY = 'yono_chatbot_car_photos';
        const FALLBACK_CAR_IMAGE = '{{ asset("image/NoImage.png") }}';
        let history = [];
        let carPhotoMap = {};
        try {
            history = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
        } catch (e) {
            history = [];
        }
        try {
            carPhotoMap = JSON.parse(localStorage.getItem(CAR_PHOTO_STORAGE_KEY)) || {};
        } catch (e) {
            carPhotoMap = {};
        }

        function saveHistory() {
            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(history));
            } catch (e) {}
        }

        function saveCarPhotos() {
            try {
                localStorage.setItem(CAR_PHOTO_STORAGE_KEY, JSON.stringify(carPhotoMap));
            } catch (e) {}
        }

        // ✅ Responsive: fullscreen di mobile, popup di desktop
        function handleResize() {
            const isMobile = window.innerWidth < 768;
            if (isMobile) {
                box.style.cssText = `
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
            } else {
                box.style.cssText = `
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
        }

        function addWelcome() {
            const div = document.createElement('div');
            div.className = 'd-flex';
            div.innerHTML = `
            <div class="rounded-4 p-3" style="max-width:90%;font-size:13px;line-height:1.65;
                background:#fffdf6;border:1px solid rgba(39,84,138,0.15);border-radius:16px 16px 16px 4px !important;">
                Halo! Saya asisten <b style="color:#27548a;">YonoMobilindo</b>
                <i class="fa-solid fa-car ms-1" style="color:#27548a;font-size:12px;"></i><br><br>
                Ada yang bisa saya bantu?<br>
                <span style="color:#867e77;font-size:12px;">
                    &bull; "Tampilkan mobil di bawah 100 juta"<br>
                    &bull; "Rekomendasikan mobil keluarga"<br>
                    &bull; "Ada mobil transmisi otomatis?"
                </span>
            </div>`;
            msgs.appendChild(div);
        }

        function addMessage(content, role, options = {}) {
            const isUser = role === 'user';
            const wrap = document.createElement('div');
            wrap.className = `d-flex ${isUser ? 'justify-content-end' : 'justify-content-start'}`;

            const bubble = document.createElement('div');
            bubble.className = 'p-2 px-3';
            bubble.style.cssText = `
                max-width: 82%; font-size: 13px; line-height: 1.4; white-space: pre-wrap;
                border-radius: ${isUser ? '16px 16px 4px 16px' : '16px 16px 16px 4px'};
                background: ${isUser ? '#27548a' : '#fffdf6'};
                color: ${isUser ? '#fffdf6' : '#171513'};
                ${!isUser ? 'border: 1px solid rgba(39,84,138,0.15); padding: 0.375rem 0.75rem !important;' : 'padding: 0.75rem 1rem;'}
            `;

            if (isUser) {
                bubble.textContent = content;
            } else {
                const baseUrl = '{{ url("/web/detailMobil") }}';
                const messageCarPhotos = options.carPhotos || {};

                if (Object.keys(messageCarPhotos).length > 0) {
                    carPhotoMap = {
                        ...carPhotoMap,
                        ...messageCarPhotos
                    };
                    saveCarPhotos();
                }

                const escaped = content
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;');

                let processed = escaped
                    .replace(/\n+\[CAR_ID:(\d+)\]/g, '\n[CAR_ID:$1]')
                    .replace(/\[CAR_ID:(\d+)\]/g, (m, id) => {
                        const photoUrl = messageCarPhotos[id] || carPhotoMap[id] || FALLBACK_CAR_IMAGE;
                        return `<div class="chatbot-car-card"><div class="chatbot-car-thumb-wrap js-chatbot-thumb" data-image="${photoUrl}"><img src="${photoUrl}" alt="Mobil ${id}" class="chatbot-car-thumb" loading="lazy" onerror="this.onerror=null;this.src='${FALLBACK_CAR_IMAGE}';"><span class="chatbot-car-thumb-zoom-hint"><i class="fa-solid fa-magnifying-glass-plus"></i> Perbesar</span></div><div class="chatbot-car-footer"><a href="${baseUrl}/${id}" class="chatbot-car-link"><i class="fa-solid fa-arrow-up-right-from-square"></i><span>Lihat Detail</span></a></div></div>`;
                    })
                    .replace(/\n{3,}/g, '\n\n');
                bubble.innerHTML = processed;
            }

            wrap.appendChild(bubble);
            msgs.appendChild(wrap);
            msgs.scrollTop = msgs.scrollHeight;
        }

        function addTyping() {
            const wrap = document.createElement('div');
            wrap.id = 'typing-wrap';
            wrap.className = 'd-flex justify-content-start';
            wrap.innerHTML = `
            <div id="typing-indicator" class="p-2 px-3"
                style="font-size:13px;border-radius:16px 16px 16px 4px;
                background:#fffdf6;color:#867e77;border:1px solid rgba(39,84,138,0.15);">
                <span class="me-1">Mengetik</span>
                <span class="spinner-grow spinner-grow-sm" style="color:#27548a;width:5px;height:5px;"></span>
                <span class="spinner-grow spinner-grow-sm mx-1" style="color:#27548a;width:5px;height:5px;animation-delay:0.15s;"></span>
                <span class="spinner-grow spinner-grow-sm" style="color:#27548a;width:5px;height:5px;animation-delay:0.3s;"></span>
            </div>`;
            msgs.appendChild(wrap);
            msgs.scrollTop = msgs.scrollHeight;
        }

        function removeTyping() {
            const el = document.getElementById('typing-wrap');
            if (el) el.remove();
        }

        function openImageViewer(src) {
            imageViewerImg.src = src || FALLBACK_CAR_IMAGE;
            imageViewer.classList.add('active');
            imageViewer.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }

        function closeImageViewer() {
            imageViewer.classList.remove('active');
            imageViewer.setAttribute('aria-hidden', 'true');
            imageViewerImg.src = '';
            document.body.style.overflow = '';
        }

        // ✅ Tombol close di header
        document.getElementById('chatbot-close').addEventListener('click', () => {
            box.classList.add('d-none');
            box.classList.remove('d-flex');
        });

        function renderHistory() {
            msgs.innerHTML = '';
            addWelcome();
            history.forEach(chat => {
                if (chat.role !== 'system') {
                    addMessage(chat.content, chat.role === 'user' ? 'user' : 'bot', {
                        carPhotos: chat.carPhotos || {}
                    });
                }
            });
            msgs.scrollTop = msgs.scrollHeight;
        }

        toggle.addEventListener('click', () => {
            const isOpen = !box.classList.contains('d-none');
            if (isOpen) {
                box.classList.add('d-none');
                box.classList.remove('d-flex');
            } else {
                box.classList.remove('d-none');
                box.classList.add('d-flex');
                handleResize(); // ✅ Cek ukuran layar setiap buka
                msgs.scrollTop = msgs.scrollHeight;
                input.focus();
            }
        });

        async function sendMessage() {
            const text = input.value.trim();
            if (!text) return;

            input.value = '';
            addMessage(text, 'user');
            history.push({
                role: 'user',
                content: text
            });
            saveHistory();

            addTyping();
            sendBtn.disabled = true;
            input.disabled = true;

            try {
                const res = await fetch('{{ route("chatbot.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        message: text,
                        history
                    }),
                });

                const data = await res.json();
                removeTyping();
                addMessage(data.reply || 'Maaf, tidak ada respons.', 'bot', {
                    carPhotos: data.carPhotos || {}
                });
                history.push({
                    role: 'assistant',
                    content: data.reply,
                    carPhotos: data.carPhotos || {}
                });
                saveHistory();

            } catch (e) {
                removeTyping();
                addMessage('Maaf, terjadi kesalahan koneksi. Coba lagi.', 'bot');
            } finally {
                sendBtn.disabled = false;
                input.disabled = false;
                input.focus();
            }
        }

        clearBtn.addEventListener('click', () => {
            history = [];
            localStorage.removeItem(STORAGE_KEY);
            renderHistory();
        });

        sendBtn.addEventListener('click', sendMessage);
        input.addEventListener('keydown', e => {
            if (e.key === 'Enter' && !e.shiftKey) sendMessage();
        });
        msgs.addEventListener('click', (e) => {
            const thumbWrap = e.target.closest('.js-chatbot-thumb');
            if (!thumbWrap) return;
            const imgSrc = thumbWrap.getAttribute('data-image');
            openImageViewer(imgSrc);
        });
        imageViewerClose.addEventListener('click', closeImageViewer);
        imageViewer.addEventListener('click', (e) => {
            if (e.target === imageViewer) {
                closeImageViewer();
            }
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && imageViewer.classList.contains('active')) {
                closeImageViewer();
            }
        });
        window.addEventListener('resize', () => {
            if (!box.classList.contains('d-none')) handleResize();
        });

        renderHistory();
    })();

</script>
