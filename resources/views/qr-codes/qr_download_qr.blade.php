<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>A4 Size Page</title>
        <base href="{{ url('/') }}/">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @font-face {
            font-family: "darkerBold";
            src: url("assets/fonts/DarkerGrotesque-Bold.ttf");
        }

        @font-face {
            font-family: "darkerMedium";
            src: url("assets/fonts//DarkerGrotesque-Medium.ttf");
        }

        .DarkerBold {
            font-family: "darkerBold";
        }

        .DarkerMedium {
            font-family: "darkerMedium";
        }

        body {
            margin: 0;
            padding: 20px;
            background: #E0E0E0;
            font-family: Arial, sans-serif;
        }

        .a4-page {
            width: 794px;
            height: 1123px;
            background: white;
            margin: auto;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            padding: 20px;
            box-sizing: border-box;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 2px;
        }

        @media print {

            body,
            html {
                margin: 0 !important;
                padding: 0 !important;
            }

            @page {
                margin: 0;
                size: A4;
            }

            .a4-page {
                width: 210mm;
                height: 297mm;
                box-shadow: none;
                page-break-after: avoid;
            }
        }

        .qr-box {
            position: relative;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
        }
    </style>
</head>

<body>
    @foreach ($qrCodes->chunk(4) as $chunk)
        <div class="a4-page">
            @foreach ($chunk as $vehicle)
                <div class="qr-box relative">
                    <img src="./assets/bg.png" class="absolute top-0 left-0 w-full h-full"></img>
                    <!-- Company Name -->
                    <h1 class="text-[#E20000] text-[32px] DarkerBold z-10">Swara Parklane</h1>
                    <!-- Qr code -->
                    <div class="flex justify-center w-full gap-1 relative">
                        <div class="relative p-1 w-32">
                            <!-- Corners -->
                            <img src="./assets/qrborder.png" class="absolute top-0 left-0 w-2/12" alt="">
                            <img src="./assets/qrborder.png" class="absolute top-0 right-0 rotate-90 w-2/12"
                                alt="">
                            <img src="./assets/qrborder.png" class="absolute bottom-0 left-0 rotate-[270deg] w-2/12"
                                alt="">
                            <img src="./assets/qrborder.png" class="absolute bottom-0 right-0 rotate-180 w-2/12"
                                alt="">
                            <div class="p-1 rounded-sm bg-white">
                                <img src="{{ Storage::Url($vehicle->qr_code) }}" class="object-cover" alt="">
                            </div>
                        </div>
                        <img src="./assets/logo.svg" class="absolute w-8 h-auto z-10 right-5 mt-2" alt="">
                    </div>
                    <!-- Office No -->
                    <div class="flex flex-col items-center justify-center">
                        <div class="flex items-center gap-2 z-10">
                            <div class="w-3 h-3 hidden rounded-full overflow-hidden mt-[6px]">
                                <img src="./assets/dot.svg" class=" w-full h-full" alt="" srcset="">
                            </div>
                            <p class="text-[#6CC8C6] DarkerBold text-lg">{{  $vehicle->vehicle->vehicle_number }}</p>
                            <div class="w-3 h-3 rounded-full hidden overflow-hidden mt-[6px]">
                                <img src="./assets/dot.svg" class=" w-full h-full" alt="" srcset="">
                            </div>
                        </div>
                    <div class="flex items-center gap-3 z-10">
                        <div class="w-3 h-3 rounded-full overflow-hidden mt-[6px]">
                            <img src="./assets/dot.svg" class=" w-full h-full" alt="" srcset="">
                        </div>
                        <p class="text-[#6CC8C6] DarkerBold text-lg">Office No:{{  $vehicle->office->office_number }}</p>
                        <div class="w-3 h-3 rounded-full overflow-hidden mt-[6px]">
                            <img src="./assets/dot.svg" class=" w-full h-full" alt="" srcset="">
                        </div>
                        
                    </div>
                    </div>
                    <!-- Building Name -->
                    <div class="w-9/12 h-36 z-10 rounded-xl overflow-hidden">
                        <img src="./assets/Sticker15.png" class="w-full h-full object-cover" alt="">
                    </div>
                    <!-- Address -->
                    <div class="flex flex-col z-10 text-white justify-center items-center text-center">
                        <h1 class="DarkerBold text-sm">Address:</h1>
                        <p class="DarkerMedium text-xs leading-tight">Swara Parklane, Atabhai Rd,Bhavnagar, Gujarat
                            364001
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</body>

</html>
<script>
    window.onload = function() {
        window.print(); // Automatically triggers the print dialog
    };
</script>
