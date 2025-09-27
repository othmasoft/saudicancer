@extends('layouts.app2')

@section('title', 'بصمة أمل - الشاشة الكبيرة')

@section('content')
    <style>
        body {
            margin: 0;
            background-color: black;
            overflow: hidden;
            height: 100vh;
        }

        #container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
        }

        .center-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 7rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 0 20px #f39c12, 0 0 40px #f39c12;
            z-index: 10;
            white-space: nowrap;
            pointer-events: none;
        }

        #container img {
            position: absolute;
            max-width: 15vw; /* متجاوب حسب العرض */
            height: auto;
        }

        .east-img {
            top: 50%;
            right: 5%;
            transform: translateY(-50%);
        }

        .logo-img {
            top: 40%;
            left: 5%;
        }

        .hand {
            position: absolute;
            width: 70px;
            height: auto;
            transform: translate(-50%, -50%);
            animation: pop 0.6s ease;
        }

        @keyframes pop {
            0% { transform: scale(0); opacity: 0; }
            70% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }

        .fade-out {
            animation: fadeOut 0.5s forwards;
        }

        @keyframes fadeOut {
            from { opacity: 1; transform: scale(1); }
            to { opacity: 0; transform: scale(0); }
        }

        img.hand[data-index="16"] {
            display: none;
        }

        img.hand[data-index="15"] {
            display: none;
        }

    </style>

    <div id="container">
        <div class="center-text">بصمة وعي</div>
        <img src="{{ asset('storage/east.png') }}" class="east-img" />
        <img src="{{ asset('storage/logo.png') }}" class="logo-img" />
    </div>

    {{-- Laravel Echo + Pusher CDN --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.15.0/dist/echo.iife.js"></script>

    <script>
        let hands = [];
        const maxHands = 30; // قلب واحد فيه 30 كف
        let positions = [];

        // 🔹 هنا نحط الأرقام اللي عايزين نتجاهلها
        const skipIndexes = [0, 1, 15, 16];
        // ملاحظة: الـ index يبدأ من 0 مش من 1
        // يعني 0 = الكف الأول، 1 = الكف الثاني، 15 = الكف رقم 16

        function calculatePositions() {
            positions = [];

            const centerX = window.innerWidth / 2;
            const centerY = window.innerHeight / 2;
            const baseScale = Math.min(window.innerWidth, window.innerHeight) / 35;

            for (let i = 0; i < maxHands; i++) {
                const t = (i / maxHands) * 2 * Math.PI; // يبدأ من فوق
                const x = 16 * Math.pow(Math.sin(t), 3);
                const y =
                    13 * Math.cos(t) -
                    5 * Math.cos(2 * t) -
                    2 * Math.cos(3 * t) -
                    Math.cos(4 * t);

                positions.push({
                    x: centerX + x * baseScale,
                    y: centerY - y * baseScale,
                });
            }
        }

        calculatePositions();

        window.addEventListener("resize", () => {
            calculatePositions();
            hands.forEach((handEl, index) => {
                const pos = positions[index];
                if (pos) {
                    handEl.style.left = pos.x + "px";
                    handEl.style.top = pos.y + "px";
                }
            });
        });

        var hands_counts = 0;
        var last_hands = 0;

        $(document).ready(function () {
            drawInitialHands();

            function sendAjaxRequest() {
                $.ajax({
                    url: "{{ url('/hope/hands') }}",
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        hands_counts = response.count;

                        if (hands_counts > last_hands) {
                            drawHand();
                        }

                        last_hands = hands_counts;
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX request failed:", status, error);
                    },
                });
            }

            setInterval(sendAjaxRequest, 2000);
        });

        function drawInitialHands() {
            // لو عايز تضيف يدين في البداية بشكل يدوي ممكن هنا
            last_hands = 0;
            hands_counts = 0;
        }

        function drawHand() {
            const container = document.getElementById("container");

            // نتأكد إن العدد أقل من maxHands
            if (hands.length < maxHands) {
                let nextIndex = hands.length;

                // نتخطى أي index في skipIndexes
                while (skipIndexes.includes(nextIndex) && nextIndex < maxHands) {
                    nextIndex++;
                }

                if (nextIndex >= maxHands) return;

                const handEl = document.createElement("img");
                handEl.src = "{{ asset('storage/right_hand.png') }}";
                handEl.className = "hand";
                handEl.dataset.index = nextIndex;

                const pos = positions[nextIndex];
                handEl.style.left = pos.x + "px";
                handEl.style.top = pos.y + "px";

                container.appendChild(handEl);
                hands.push(handEl);
            } else {
                // 🔹 بعد ما اكتمل القلب (30 كف)
                // نشيل آخر كف ونضيفه من جديد
                const lastIndex = maxHands - 1;
                const oldHand = hands[lastIndex];
                if (oldHand) {
                    oldHand.remove();
                    hands.splice(lastIndex, 1);
                }

                const newHand = document.createElement("img");
                newHand.src = "{{ asset('storage/right_hand.png') }}";
                newHand.className = "hand";
                newHand.dataset.index = lastIndex;

                const pos = positions[lastIndex];
                newHand.style.left = pos.x + "px";
                newHand.style.top = pos.y + "px";

                container.appendChild(newHand);
                hands.push(newHand);
            }
        }

        function resetHands() {
            hands.forEach((h) => h.remove());
            hands = [];
            calculatePositions();
            last_hands = 0;
            hands_counts = 0;
        }
    </script>





@endsection
