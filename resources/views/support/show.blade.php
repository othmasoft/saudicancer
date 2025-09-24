@extends('layouts.app3')

@section('title', 'بصمة أمل - رسائل الدعم')

@section('content')
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            width: 100vw;
            background-color: #fcf5f2; /* لون خلفية للفراغات */
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        #hand-container {
            position: relative;
            height: 100vh;             /* 80% من ارتفاع الشاشة */
            width: calc(90vh * 1.3);  /* العرض = الارتفاع × النسبة (1.3) */
            max-width: 1300px;
            max-height: 1000px;
            background: url('{{ asset("storage/H4.svg") }}') no-repeat center center;
            background-size: contain; /* الصورة كاملة بدون قص */
            background-position: center center;
            margin: auto;
        }


        .box {
            position: absolute;
            width: 12%;
            height: 6%;
            background: #fcf5f2;
            color: #333;
            font-size: 0.8vw;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 1px;
            border: 1px solid #8e2151; /* إطار أحمر */
            border-radius: 15px;
            overflow: hidden;
        }

        /* مثال لمواضع */
        .box1  { top: 79%; left: 26%; width: 21% ;  transform: rotate(43deg);}
        .box2  { top: 74%; left: 31%; width: 20% ;  transform: rotate(43deg);}
        .box3  { top: 69%; left: 35%; width: 21% ;  transform: rotate(43deg);}

        .box4  { top: 57%; left: 38%; width: 13% ;  transform: rotate(43deg);}
        .box5  { top: 68%; left: 48%; width: 14% ;  transform: rotate(43deg);}
        .box6  { top: 51%; left: 42%; width: 13% ;  transform: rotate(43deg);}
        .box7  { top: 63%; left: 53%; width: 14% ;  transform: rotate(43deg);}
        .box8  { top: 46%; left: 47%; width: 13% ;  transform: rotate(43deg);}
        .box9  { top: 58%; left: 58%; width: 14% ;  transform: rotate(43deg);}


        .box10 { top: 34%; left: 50%; width: 11% ;  transform: rotate(315deg);  height: 5%;}
        .box11 { top: 38%; left: 56%; width: 17% ;  transform: rotate(315deg); height: 5%;}
        .box12 { top: 41%; left: 61%; width: 18% ;  transform: rotate(315deg); height: 6%;}
        .box13 { top: 48%; left: 65%; width: 16% ;  transform: rotate(315deg); height: 5%;}
        .box14 { top: 49%; left: 69%; width: 22% ;  transform: rotate(315deg); height: 5%;}
        .box15 { top: 25%; left: 69%; width: 13% ;  transform: rotate(315deg); height: 5%;}
        .box16 { top: 27%; left: 74%; width: 16% ;  transform: rotate(315deg); height: 6%;}
        .box17 { top: 35%; left: 77%; width: 14% ;  transform: rotate(315deg); height: 5%;}

        .box18 { top: 58%; left: 22%; width: 12% ;  transform: rotate(45deg); height: 5%;}
        .box19 { top: 51%; left: 21%; width:  17% ;  transform: rotate(45deg); height: 5%;}
        .box20 { top: 41%; left: 21%; width:  18% ;  transform: rotate(45deg);}
        .box21 { top: 37%; left: 27%; width:  16% ;  transform: rotate(45deg); height: 5%;}
        .box22 { top: 33%; left: 38%; width:  11% ;  transform: rotate(45deg); height: 5%;}

        .box23 { top: 46%; left: 10%; width:  15% ;  transform: rotate(45deg); height: 5%;}
        .box24 { top: 36%; left: 9%; width:  16% ;  transform: rotate(45deg); height: 5%;}
        .box25 { top: 27%; left: 10%; width:  16% ;  transform: rotate(45deg);}
        .box26 { top: 25%; left: 18%; width:  13% ;  transform: rotate(45deg); height: 5%;}
        .box27 { top: 79%; left: 53%; width: 21% ;  transform: rotate(317deg);}



    </style>
    <div id="hand-container">
        <div class="prince-word-container">
            <div class="prince-word-card">
                <div class="card-content">
                    <div class="signature">
                        <span class="prince-title">كلمة صاحب السمو الملكي</span>
                        <span class="prince-name">الأمير سعود بن نايف بن عبدالعزيز آل سعود</span>
                        <p class="prince-text">{{ $prince_word }}</p>
                    </div>
                </div>
            </div>
        </div>


        <style>
            .prince-word-container {
                text-align: center; /* كل النص في المنتصف */
            }

            .signature {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 11px;
            }

            .prince-title {
                font-size: 20px;
                font-weight: bold;
                color: #8e2151; /* عادي */
            }

            .prince-name {
                font-size: 18px;
                font-weight: bold;
                color: #8e2151; /* عادي */
            }

            .prince-text {
                color: #8e2151; /* النص أحمر */
                max-width: 70%;
                line-height: 1.6;
                padding: 10px 18px;
                border: 2px solid #8e2151; /* إطار أحمر */
                border-radius: 10px;
                background-color: #fff; /* خلفية بيضاء */
                display: inline-block;
            }


        </style>




        @for($i = 1; $i <= 27; $i++)
            <div class="box box{{ $i }}">{{$i}}</div>
        @endfor
    </div>

    <div id="mouse-pos"
         style="position: fixed;
            top: 10px;
            left: 10px;
            background: rgba(0,0,0,0.7);
            color: #fff;
            padding: 6px 12px;
            border-radius: 8px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            z-index: 9999;">
        X: 0% , Y: 0%
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $( document ).ready(function() {
           // $(".box").hide();
        });

        let currentIndex = 1;  // نبدأ من box1
        let lastMessageId = null; // لحفظ آخر رسالة
        const totalBoxes = 27;


        function fetchMessages() {
            $.get("{{ route('support.show') }}", (data) => {
                if (data && data.message) {
                    let message = data.message.trim();

                    // نتأكد أنها رسالة جديدة (بالمقارنة مع الـ id مثلاً)
                    if (lastMessageId !== data.id) {
                        lastMessageId = data.id; // حفظ آخر id

                        // لو عدينا 27 نبدأ من الأول ونمسح كل الرسائل
                        if (currentIndex > totalBoxes) {
                            $(".box").html("");
                            $(".box").hide();
                            $(".box1").show();
                            currentIndex = 1;   // نرجع للبداية
                        }

                        // نضيف الرسالة في الصندوق الحالي
                        $(`.box${currentIndex}`).show();
                        $(`.box${currentIndex}`).html(message.substring(0, 40));

                        currentIndex++;
                    }
                }
            });
        }

        // استدعاء كل ثانية
        setInterval(fetchMessages, 1000);
    </script>



    <script>
        document.addEventListener("mousemove", function(e) {
            let pageWidth  = document.documentElement.scrollWidth;
            let pageHeight = document.documentElement.scrollHeight;

            let mouseX = e.pageX;
            let mouseY = e.pageY;

            let percentX = (mouseX / pageWidth) * 100;
            let percentY = (mouseY / pageHeight) * 100;

            document.getElementById("mouse-pos").textContent =
                "X: " + percentX.toFixed(2) + "% , Y: " + percentY.toFixed(2) + "%";
        });
    </script>
@endsection
