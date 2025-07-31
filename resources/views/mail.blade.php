<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <div class="container mt-5">
    <form action="{{url('send-mail')}}" method="post">
        @csrf
        <div class="row">
           <div class="col-12 col-md-6 col-lg-4 aline-item mt-5">
            <h1>   Mail Information</h1>
            <div class="row">
            <div class="col-lg-12">
                <input type="text" name="to" placeholder="Enter email ID">
            </div>
            </div>
            <div class="row">
            <div class="col-lg-12">
                <input type="text" name="sub" placeholder="Enter subject">
            </div>
             </div>
            <div class="col-lg-12">
                <input type="text" name="msg" placeholder="Enter message">
            </div>
           </div>
        </div>
        <button class="btn btn btn-primary">Send mail</button>
    </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>