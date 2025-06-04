<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Corpapark IQ</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.svg') }}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Figtree:ital,wght@0,300..900;1,300..900&display=swap');

        * {
            font-family: figtree;
        }

        .social-btn {
            transition: all 0.3s ease;
        }

        .social-btn:hover {
            transform: translateY(-3px);
        }
    </style>
</head>

<body class="bg-[#e0e0e0] text-black">

    <!-- Header -->
    <header class="bg-white shadow-lg h-20 px-5 md:px-10 flex items-center justify-center">
        <div class="flex items-center gap-3">
            <img src="./assets/logoicon.svg" alt="Logo" class="w-10 h-10">
            <p class="text-lg md:text-xl font-bold">Corppark IQ</p>
        </div>
    </header>

   <main>
  <!-- Hero Section -->
  <div class="h-48 md:h-64 w-full bg-cover bg-center flex items-center justify-center text-center px-4"
    style="background-image: url('https://s3.ap-southeast-1.wasabisys.com/media.hyvikk.com/hyvikk-solutions/hyvikk-Contact-Us.jpg');">
    <h1 class="text-3xl md:text-[56px] text-white font-semibold">Contact us</h1>
  </div>

  <!-- Address Section -->
  <div class="grid grid-cols-1 md:grid-cols-2 w-11/12 lg:w-9/12 mx-auto py-10 gap-10 md:gap-20">
    <!-- Google Map -->
    <div class="w-full h-[300px] md:h-full shadow-md border-4 border-white rounded-xl overflow-hidden">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3705.5875667379173!2d72.14639637505293!3d21.757509380080464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395f5a809dcfffff%3A0x16f02797873506a5!2sHyvikk%20Solutions!5e0!3m2!1sen!2sin!4v1749037198483!5m2!1sen!2sin"
        class="w-full h-full" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>

    <!-- Contact Info -->
    <div class="flex flex-col gap-6">
      <div>
        <h2 class="text-4xl font-bold">Locate Us</h2>
        <p class="text-gray-600">Pay us a visit at the address below</p>
      </div>
      <div>
        <h3 class="text-2xl font-bold text-[#3D66B0]">Headquarters</h3>
        <p class="text-gray-700">309, Swara Parklane, Atabhai Chowk, Bhavnagar, Gujarat (IN).</p>
      </div>
      <div>
        <h3 class="text-2xl font-bold text-[#3D66B0]">Phone</h3>
        <p class="text-gray-700 space-y-2">
          <span class="block">(91) 9427 212415</span>
          <span class="block">(91) 9429 233567</span>
        </p>
      </div>
      <div>
        <h3 class="text-2xl font-bold text-[#3D66B0]">Email</h3>
        <p class="text-gray-700">help@hyvikk.com</p>
      </div>
    </div>
  </div>

  <!-- Contact Form Section -->
  <div class="w-11/12 lg:w-9/12 mx-auto py-10">
    <h2 class="text-3xl md:text-4xl font-medium text-center mb-8">Let’s make something together</h2>

    <form class="bg-white shadow-lg rounded-xl p-6 md:p-10 w-full lg:w-2/3 mx-auto space-y-6">
      <input type="text" placeholder="Your Name"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="email" placeholder="Your Email"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
        <input type="text" placeholder="Phone Number"
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <textarea rows="5" placeholder="Your Message"
        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

      <button type="submit"
        class="bg-[#3D66B0] text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
        Send Message
      </button>
    </form>
  </div>
</main>



    <!-- Footer -->
    <footer class="bg-white py-6">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">

                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <img src="./assets/logoicon.svg" alt="Logo" class="w-10 h-10">
                    <p class="text-lg md:text-xl font-bold">Corppark IQ</p>
                </div>

                <!-- Powered By -->
                <div class="text-gray-400 text-sm text-center md:text-left">
                    <p>Powered By <a href="https://hyvikk.com/" class="hover:text-blue-500" target="_blank">Hyvikk
                            Solutions</a></p>
                </div>

                <!-- Social Media Buttons -->
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="https://www.facebook.com/hyvikk/"
                        class="bg-gray-700 text-white h-10 w-10 rounded-full flex items-center justify-center hover:bg-blue-600 transition"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/HyvikkS"
                        class="bg-gray-700 text-white h-10 w-10 rounded-full flex items-center justify-center hover:bg-blue-400 transition"><i
                            class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/hyvikk_solutions/?hl=en"
                        class="bg-gray-700 text-white h-10 w-10 rounded-full flex items-center justify-center hover:bg-pink-500 transition"><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/channel/UCfCE269wYZOkM2gMP4EDjjQ"
                        class="bg-gray-700 text-white h-10 w-10 rounded-full flex items-center justify-center hover:bg-red-600 transition"><i
                            class="fab fa-youtube"></i></a>
                    <a href="https://in.linkedin.com/company/hyvikk-solutions"
                        class="bg-gray-700 text-white h-10 w-10 rounded-full flex items-center justify-center hover:bg-blue-700 transition"><i
                            class="fab fa-linkedin-in"></i></a>
                </div>

            </div>
        </div>
    </footer>


</body>

</html>