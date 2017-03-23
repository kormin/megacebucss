@extends('layouts.general')

@section('content')
<div class="container">
    <h3 class="center-align dboard-head">Ideas</h3>

  <!-- SEARCH BAR -->
<!--     <div class="row dboard">
        <div class="col s6 m6 l6">
          <div class="row">
            <div class="input-field col s12">
              <i class="material-icons prefix">search</i>
              <input type="text" id="autocomplete-input" class="autocomplete">
              <label for="autocomplete-input">Ideas tags</label>
            </div>
          </div>
        </div>    
    </div> -->
        
    <!-- ROW1 -->       
<!--     <div class="row dboard"> -->
    <?php $count = 1;$length = count($posts)+1;$addpostcard=0; ?>
    @foreach($posts as $post)

    @if ($count === 1 | $count%3 === 0)
    <div class="row">
    @endif
    @if ($addpostcard === 0)
        <div class="col s12 m4 l4">
            <div class="card-panel" style="height: 340px;">
                <ul>
                    <li style="text-align: center; padding:100px 100px 100px 100px;"><a class="btn-floating red"><i class="material-icons">note_add</i></a></li>
                </ul>                
            </div>
        </div>
        <?php $addpostcard = 1; ?>
    @else
        <div class="col s12 m4 l4">
            <div class="card">
                <div class="card-image">
                    <div class="fixed-action-btn horizontal dboard-like" style="position: relative">
                        <a class="" style="width: relative">
                            <img src="images/sample-1.jpg">
                             <span class="card-title">{{$post->title}}</span>
                        </a>    
                        <ul>
                            <li><a class="btn-floating red"><i class="material-icons">thumb_up</i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-content">
                    <p class="justify-align">{{$post->content}} <a href="#">Read more</a></p>
                </div>
                <div class="card-action">
                    <div class="chip mini-chip">lake</div>
                    <div class="chip mini-chip">mountains</div>
                    <div class="chip mini-chip">nature</div>
                    <div class="chip mini-chip more">+3 more</div>
                </div>
            </div>
        </div>
    @endif
    @if ($count%3 === 0 | $count+1 === $length)
    </div>
    @endif
    <?php $count++; ?>
    @endforeach
<!--     </div>     -->    
    <!-- ROW3 --> 

    <!-- PAGINATION STARTS HERE -->
    <div class="row">
        <ul class="pagination center-align">
            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
            <li class="active"><a href="#!">1</a></li>
            <li class="waves-effect"><a href="#!">2</a></li>
            <li class="waves-effect"><a href="#!">3</a></li>
            <li class="waves-effect"><a href="#!">4</a></li>
            <li class="waves-effect"><a href="#!">5</a></li>
            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>
    </div>
    <!-- PAGINATION ENDS HERE -->

</div>
@endsection
