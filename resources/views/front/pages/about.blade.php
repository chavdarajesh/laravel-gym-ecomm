@extends('front.layouts.main')
@section('title', 'About')
@section('css')
<style>
    .ticket-card {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 5px;
        padding: 20px;
        margin-bottom: 20px;
        transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
    }
   .ticket-card:hover {
        background-color: #28a745;
        color: #fff !important;
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }
   .ticket-card:hover .ticket-title,
    .ticket-card:hover .ticket-description {
        color: #fff;
    }
    .ticket-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #343a40;
    }

    .ticket-description {
        font-size: 1rem;
        color: #6c757d;
    }

    .profile-container .profile-card {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: background-color 0.3s, transform 0.3s, box-shadow 0.3s;
    }

    .profile-container .profile-card:hover {
        background-color: #28a745;
        color: #fff !important;
        transform: translateY(-10px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .profile-container .profile-card:hover .profile-name,
    .profile-container .profile-card:hover .profile-description {
        color: #fff;
    }

    .profile-container .profile-image {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .profile-container .profile-name {
        font-size: 1.25rem;
        font-weight: bold;
        color: #343a40;
        margin-bottom: 10px;
    }

    .profile-container .profile-description {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .profile-container .row {
        display: flex;
        flex-wrap: wrap;
    }

    .profile-container .col-md-3,
    .col-sm-6 {
        display: flex;
    }
</style>
@stop
@section('content')
<!--about section start -->
<div class="about_section layout_padding">
    <div class="container d-flex">
        <h1 class="about_taital">About Us</h1>
        <!-- <p class="about_text">It is a long established fact that a reader will be distracted by the readable content of a page when</p> -->
        <!-- <div class="about_section_2">
            <div class="row">
                <div class="col-lg-6">
                    <div class="about_image"><img src="{{ asset('assets/front/images/about-img.png')}}"></div>
                </div>
                <div class="col-lg-6">
                    <div class="about_taital_main">
                        <p class="lorem_text">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words </p>
                        <div class="read_bt"><a href="{{route('front.contact')}}">Contact Us</a></div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <div class="d-flex justify-content-center flex-column align-items-center mx-5 px-5">
        <img src="{{asset('custom-assets/front/images/about-us.png')}}" alt="">
        <h1 class="mt-3">।। श्री महावीराय नमः ।।</h1>
        <hr>
        <h2>
            णमो अरिहंताणं , णमो सिद्धाणं <br>
            णमो आयरियाणं, णमो उवज्झायाणं <br>
            णमो लोय सव्व साहुणं<br>
            एसो पंच णमोकारो, सव्व पाव प्पणासणॊ । <br>
            मंगलाणं च सव्वेसिं, पढ़मं हवइ मंगलम ।। <br>
        </h2>
        <hr>
        <h3>From the Earth to Your Table
            <br><br>
            Started with humble beginnings in 1981 from a small town in the heart of Central India, Barnagar (Madhya Pradesh), Jain Agriventures was founded by Shree Rajkumar Bilala, a visionary who sowed the seeds of hope and passion into agriculture.
            With quality and trust as its guiding mantra, this seed sown by Shree Rajkumar Bilala has blossomed into a thriving enterprise, expanding its branches into agritrading ( domestic and international ) , warehousing, and agriprocessing industries . Jain Agriventures is an umbrella that proudly houses a family of businesses, including Jain Traders, M/s Manoj kumar Rajkumar Jain , Garvit Enterprises,
            Jain Warehouses, Jain Coldstorages, Jain Sortex Plants and Jain farms.
            <br><br>
            Jain Agriventures continues to stand tall, dedicated to delivering excellence "from the earth to your table."
            <br><br>
            Jain Traders is now recognized as one of the leading suppliers and traders in the industry, known for delivering quality produce both domestically and internationally. Sourcing from the fertile agricultural belts of India, such as Malwa and Nimar, the firm ensures only the finest produce reaches its customers.
            <br><br>
            M/s Manojkumar Rajkumar remains committed to serving the domestic market with the same focus on quality.
            Garvit Enterprises, the star member of the family, has set its sights on the global marketplace, aspiring to deliver the richness of India’s soil to tables around the world.
            <br><br>
            At Jain Sortex Plants, we have perfected the art of resource optimization by providing top-notch cleaning, sorting, and sizing solutions for organic grains. By ensuring size uniformity and quality preparation, we transform regular grains into premium-grade commodities that meet international standards.
            <br><br>
            Meanwhile, Jain Warehouses and Jain Coldstorages are dedicated to offering the best storage solutions for farmers, ensuring their goods are stored in optimal conditions, allowing them to secure the best possible prices in the market.
            <br><br>
            At Jain Agriventures, we are united by one mission: to bring the finest agricultural products from the earth to your table, while supporting the backbone of our nation's economy—our farmers.
        </h3>
    </div>
    <div class="container pt-5">
        <div class="row">
            <!-- Vision Card -->
            <div class="col-md-6">
                <div class="ticket-card">
                    <h5 class="ticket-title">Vision</h5>
                    <p class="ticket-description">To be the leading force in showcasing the world's finest agricultural produce, highlighting the value of our farmers and their contribution to a healthier planet.</p>
                </div>
            </div>

            <!-- Mission Card -->
            <div class="col-md-6">
                <div class="ticket-card">
                    <h5 class="ticket-title">Mission</h5>
                    <p class="ticket-description">To bring the finest quality agri products from the earth to the tables around the world, while supporting the backbone of our nation’s economy - our farmers.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container pt-5 profile-container">
        <div class="row">
            <!-- Profile Card 1 -->
            <div class="col-md-3 col-sm-6 d-flex">
                <div class="profile-card flex-fill">
                    <div>
                        <img src="https://via.placeholder.com/100" alt="Profile Image" class="profile-image">
                    </div>
                    <h5 class="profile-name">John Doe</h5>
                    <p class="profile-description">A passionate web developer with expertise in full-stack technologies.</p>
                </div>
            </div>

            <!-- Profile Card 2 -->
            <div class="col-md-3 col-sm-6 d-flex">
                <div class="profile-card flex-fill">
                    <div>
                        <img src="https://via.placeholder.com/100" alt="Profile Image" class="profile-image">
                    </div>
                    <h5 class="profile-name">Jane Smith</h5>
                    <p class="profile-description">Specializes in front-end development and UI/UX design.</p>
                </div>
            </div>

            <!-- Profile Card 3 -->
            <div class="col-md-3 col-sm-6 d-flex">
                <div class="profile-card flex-fill">
                    <div>
                        <img src="https://via.placeholder.com/100" alt="Profile Image" class="profile-image">
                    </div>
                    <h5 class="profile-name">Michael Lee</h5>
                    <p class="profile-description">An expert in cloud computing and backend solutions.</p>
                </div>
            </div>

            <!-- Profile Card 4 -->
            <div class="col-md-3 col-sm-6 d-flex">
                <div class="profile-card flex-fill">
                    <div>
                        <img src="https://via.placeholder.com/100" alt="Profile Image" class="profile-image">
                    </div>
                    <h5 class="profile-name">Emily Davis</h5>
                    <p class="profile-description">Focused on mobile app development and progressive web apps.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
