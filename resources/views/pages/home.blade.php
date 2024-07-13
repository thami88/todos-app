@guest
    <a href="{{route('login')}}">
        Login
    </a>
@else
   <form action="{{route('logout')}}" method="POST">
    @csrf
    <button type="submit">
        Log out
    </button>
   </form>
@endguest

@foreach ($courses as $course)
    <li>{{$course->title}}</li>
    <li>{{$course->description}}</li>
@endforeach
