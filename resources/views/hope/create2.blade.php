@extends('layouts.app2')

@section('title', 'بصمة أمل')

@section('content')

    <div id="wrapper">
        <!-- بث الكاميرا -->
        <video id="video" autoplay playsinline></video>
        <!-- صورة اليد الشفافة -->
        <img id="hand-mask" src="{{ asset('storage/hand-frame.png') }}" alt="hand mask" style="display:none">
        <!-- العد التنازلي -->
        <div id="countdown"></div>
    </div>

    <canvas id="canvas" style="display:none;"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/hands/hands.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@mediapipe/camera_utils/camera_utils.js"></script>

    <script>
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const handMask = document.getElementById('hand-mask');

        let processing = false; // عشان ما يبعتش كل frame

        // تهيئة MediaPipe Hands
        const hands = new Hands({
            locateFile: (file) => {
                return `https://cdn.jsdelivr.net/npm/@mediapipe/hands/${file}`;
            }
        });

        hands.setOptions({
            maxNumHands: 1,
            minDetectionConfidence: 0.7,
            minTrackingConfidence: 0.7
        });

        hands.onResults(onResults);

        const camera = new Camera(video, {
            onFrame: async () => {
                await hands.send({ image: video });
            },
            width: 400,
            height: 500
        });
        camera.start();

        function onResults(results) {
            if (!processing && results.multiHandLandmarks && results.multiHandLandmarks.length > 0) {
                processing = true;

                // ✅ اظهر hand mask
                handMask.style.display = "block";

                // التقط الصورة
                captureAndSend();

                // بعد ثانية اخفي الماسك
                setTimeout(() => {
                    handMask.style.display = "none";
                    processing = false; // ابدا من جديد
                }, 1000);
            }
        }

        // التقاط الصورة + إرسالها
        function captureAndSend() {
           // const ctx = canvas.getContext('2d');
          //  canvas.width = video.videoWidth;
           // canvas.height = video.videoHeight;
           // ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

           // const imageData = canvas.toDataURL('image/png');

            alert(1);
            // إرسال للسيرفر
            $.post("{{ url('/hope/add-hand') }}", {
                _token: "{{ csrf_token() }}",
                hand: "🖐️",
                image: imageData
            });

        }
    </script>

@endsection
