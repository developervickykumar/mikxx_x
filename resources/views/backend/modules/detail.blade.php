@extends('layouts.master')

@section('title')
Modules Detail
@endsection

@section('content')
@component('components.breadcrumb')
@slot('li_1')
Tables
@endslot
@slot('title')
Modules Detail
@endslot
@endcomponent

<style>
<style>

/* features sec */
.features-section {
    padding: 50px 0;
}

.features-section p {
    text-align: left;
}

.feature-box {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 40px;
}

.feature-box .circle {
    width: 80px;
    height: 80px;
    background-color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: bold;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.features-heading {
    font-size: 36px;
    font-weight: bold;
    color: red;
    margin-bottom: 40px;
}

/* finbook section */
.finbook-left,
.finbook-right {
    flex: 1 1 50%;
    padding: 15px;

}

.finbook-right img {
    max-width: 100%;
    height: auto;
}

.finbook-highlight {
    color: #d9534f;
    font-weight: 700;
}

.spotlight-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
}

.spotlight-text {
    max-width: 100%;
}

.spotlight-text h2 {
    font-weight: bold;
    color: #002a5c;
}

.potlight-p-text {
    font-size: 55px;
    font-weight: 600;
    line-height: normal;

}

.potlight-p-text-new {
    font-size: 50px;
    font-weight: 700;
    line-height: 60px;

}

.f1-bg {
    background-color: #f1f1f1;
}

.spotlight-text .highlight {
    color: #002a5c;
    font-weight: bold;
}

.spotlight-text .star {
    color: #ffb400;
}

.spotlight-text .btn {
    background-color: #ff6600;
    color: white;
    font-weight: bold;
    width: 35%;
}

.spotlight-text .btn:hover {
    background-color: #e65c00;
}

.spotlight-image {
    position: relative;
    max-width: 70%;
}

.spotlight-image img {
    width: 100%;
    border-radius: 20px;
}

@media screen and (max-width: 767px) {
    .potlight-p-text {
        font-size: 26px;
        font-weight: 600;
        line-height: normal;
    }

    .spotlight-text p {
        font-size: 16px;
    }

    .spotlight-text .btn {
        background-color: #ff6600;
        color: white;
        font-weight: bold;
        width: 100%;
    }
}

.potlight-p-text-new {
    font-size: 50px;
    font-weight: 700;
    line-height: 60px;

}
</style>
</style>


<section class="spotlight-section mb-lg-5 d-flex  ">
    <div class="container-fluid">
        <div class="row ">
            <div class="col-xl-6 d-flex flex-column f1-bg">
                <div class="spotlight-text p-md-5">
                    <div class="p-md-4">
                        <div class="d-flex">
                            <img src="{{ asset('storage/' . $module->logo) }}" alt="" class="rounded me-3" width="50"
                                height="50">
                            <h2 class="text-danger">{{ $module->module_name }}</h2>

                        </div>
                        <p class="mt-md-2 potlight-p-text-new text-left">{{ $module->tag_line }}</p>
                        <hr>
                        <p class="text-left ">{{ $module->long_desc }}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 d-flex justify-content-center p-5 ">
                <div class="finbook-right text-left p-md-4">
                    <img src="{{ asset('storage/' . $module->image) }}" alt="Finance Illustration"
                        class="img-fluid mb-2">
                    <p class="text-left"><strong>{{ $module->category }}:</strong> <br><span
                            class="finbook-highlight fs-4">{{ $module->page_name }}
                        </span><br>
                    <p class="text-left ">{{ $module->short_desc }}</p>

                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container features-section">
        <div class="row">
            @foreach ($features as $feature)
            <div class="col-md-6">
                <div class="feature-box pt-4">
                    <div class="circle">{{ $loop->iteration }}</div>
                    <div>
                        <h4 class="text-capitalize">{{ $feature['feature'] }}</h4>
                        <p>{{ $feature['feature_desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


@endsection