<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>

    @foreach ($courses as $course)
        <li>{{$course->title}}</li>
        <li>{{$course->description}}</li>
    @endforeach
    
</body>
</html>