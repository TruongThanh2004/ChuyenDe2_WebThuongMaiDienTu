@extends('home.index')
@section('content')
<head>
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<section id="page-header" class="about-header">
        <h2>#let's_talk</h2>
        <p>LEAVE A MESSAGE, We love to hear from you!</p>
    </section>

    <section id="contact-details" class="section-p1">
        <div class="details">
            <span>GET IN TOUCH</span>
            <h2>Visit one of our agency locations or contact us today.</h2>
            <h3>Head Office</h3>
            <div>
                <li>
                    <i class="fas fa-map"></i>
                    <p>21/2A Phan Huy Ích, Phường 12, Gò Vấp, Thành phố Hồ Chí Minh, Việt Nam</p>
                </li>
                <li>
                    <i class="fas fa-envelope"></i>
                    <p>0234 678 678</p>
                </li>
                <li>
                    <i class="fas fa-phone-alt"></i>
                    <p>didongustors@gmail.com
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <p>Monday to Saturday: 9:00 AM to 16:00 PM</p>
                </li>
            </div>
        </div>
        <div class="map">
            <iframe
                src="https://www.google.com/maps?q=Thương+mại+điện+tử,+21/2A+Phan+Huy+Ích,+Phường+12,+Gò+Vấp,+Thành+phố+Hồ+Chí+Minh,+Việt+Nam&output=embed"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>
    <section id="form-details">
        <form action="">
            <span>LEAVE A MESSAGE</span>
            <h2>We love to hear from you</h2>
            <input type="text" placeholder="Your Name">
            <input type="text" placeholder="E-mail">
            <input type="text" placeholder="Subject">
            <textarea name="" id="" cols="30" rows="10" placeholder="Your Message"></textarea>
            <button class="normal">Submit</button>
        </form>
        <div class="people">
            <div>
                <img src="images/people/1.png" alt="">
                <p><span>John Doe</span> Senior Marketing Manager<br>Phone: +000 123 000 77 88<br>Email: contact@example.com</p>
            </div>
            <div>
                <img src="images/people/2.png" alt="">
                <p><span>William Smith</span> Senior Marketing Manager<br>Phone: +000 123 000 77 88<br>Email: contact@example.com</p>
            </div>
            <div>
                <img src="images/people/3.png" alt="">
                <p><span>Emma Stone</span> Senior Marketing Manager<br>Phone: +000 123 000 77 88<br>Email: contact@example.com</p>
            </div>
        </div>
    </section>
@endsection