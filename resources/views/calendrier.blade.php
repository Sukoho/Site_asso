<div class="">{{$date->year}}</div>
<div class="container">
    @if ($errors->any())
    problème de d'insertion en base de donnée
    @endif
    
    <div class="month"> 
        
        <div class="left">
            <form action='{{ url('prevRoute') }} ' method='post' >
                @csrf
                <input type='hidden' name='prev' value='{{$date->date}}'>
                <input class='prev buttonMois' type='submit' value='&#10094;' >
                </form>
            </div>
            
            <div class="centre">
                <h5>
                    @foreach ($mois as $key => $value )
                    @if ($key==$date->month)
                    {{$value}}
                    @endif
                    @endforeach
                </h5>
            </div>
            
            <div class="right">    
                <form action='{{ url('nextRoute') }}' method='post' >
                    @csrf
                   <input type='hidden' name='next' value='{{$date->date}}'>
                    <input class='next buttonMois' type='submit'  value='&#10095;' >
                </form>
            </div>
        </div>
        
        <ul class="weekdays">
            @for ($i = 1;$i <= 7;$i++,$premierJour++)
            <li >{{$semaine[$premierJour]}}</li>
            @endfor
        </ul>
        
        <ul class="days">  
            @for($x = 1; $x <= $nbJour; $x++)
            
            <li >
                @if ($x == $date->day ) 
                
                    @if (isset($eventa) and in_array($x, $eventa))
                        <form action='{{ url('event') }} ' method='post' >
                            @csrf
                            <input type='hidden' name='realdate' value='{{date("Y-m-d", mktime(0, 0, 0, $date->month, $date->day, $date->year))}}'>
                            <input type='hidden' name='date' value='{{date("Y-m-d", mktime(0, 0, 0, $date->month, $x, $date->year))}}'>
                            <span class='active'><input class=' event' type='submit' value='{{$x}}' ></span>
                        </form>
                    @else
                        <form action='{{ url('event') }} ' method='post' >
                            @csrf
                            <input type='hidden' name='realdate' value='{{date("Y-m-d", mktime(0, 0, 0, $date->month, $date->day, $date->year))}}'>
                            <input type='hidden' name='date' value='{{date("Y-m-d", mktime(0, 0, 0, $date->month, $x, $date->year))}}'>
                            <span class='active'><input class='alldays' type='submit' value='{{$x}}' ></span>
                        </form>
                    @endif
                
                @elseif ($x > $date->day ) 
                
                    @if (isset($eventa) and in_array($x, $eventa))
                        <form action='{{ url('event') }} ' method='post' >
                            @csrf
                            <input type='hidden' name='realdate' value='{{date("Y-m-d", mktime(0, 0, 0, $date->month, $date->day, $date->year))}}'>
                            <input type='hidden' name='date' value='{{date("Y-m-d", mktime(0, 0, 0, $date->month, $x, $date->year))}}'>
                            <input class=' event' type='submit' value='{{$x}}' >
                        </form>
                    @else
                        <form action='{{ url('event') }} ' method='post' >
                            @csrf
                            <input type='hidden' name='realdate' value='{{date("Y-m-d", mktime(0, 0, 0, $date->month, $date->day, $date->year))}}'>
                            <input type='hidden' name='date' value='{{date("Y-m-d", mktime(0, 0, 0, $date->month, $x, $date->year))}}'>
                            <input class='alldays' type='submit' value='{{$x}}' >
                        </form>
                    @endif
                
                @else
                        <span class='beforedays'>{{$x}}</span>
                @endif
            </li>
            
            @endfor
        </ul>
    </div>
