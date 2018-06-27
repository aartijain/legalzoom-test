<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Higher or Lower') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <meta charset=utf-8 />
    <meta name="description" content="description">

    <title>Higher or Lower!</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    
</head>

<body>
    
    <section id="main-content">
        <div id="content-div">
            <h1 class="welcome" style="color:#fff; text-transform: uppercase;"> Higher or Lower! </h1>

            <div class="row">
                <div class="col-xs-6">
                    <div id="current-card">
                        <p> </p>
                        <div class="hand">
                            <div class="card suit{{ucfirst($currentCard->suit)}}">
                               <p>{{$currentCard->value}}</p>
                            </div>					    		
                         </div>
                        <p></p>
                    </div>
                </div>
                
                 <div class="col-xs-6">
                    <div id="higher-lower">
                        <a href="#">
                            <button class="higher-button" name="higher">
                                <i class="guess-btn fa fa-chevron-up"></i>
                            </button>
                        </a>
                        <br>
                        <a href="#">
                            <button class="lower-button" name="lower">
                                <i class="guess-btn fa fa-chevron-down"></i>
                            </button>
                        </a>
                        <!-- hidden values for maintaining score and lives and keeps track of no. of card deal -->
                        <input type="hidden" class='noOfClicks' value='0'>
                        <input type="hidden" class='score' value='0'>
                        <input type="hidden" class='lives' value='3'>
                    </div>
                     
                    <div id="gameOver" style="display:none;">
                        <p class="game-over">Game over!</p>
                        <p class="your-score">You scored</p><p class="score">4</p>
                    </div>
                </div>
                
            </div>

            <div class="row" id="newgameDiv" style="display: none;">
                <div class="col-xs-12">
                    <div id="new-game">
                        <a href="{{url('higer-or-lower')}}">
                            <button type="button" class="btn margin-top-30 font-40 start-btn btn-green btn-lg">
                                Start a new game 
                                <span class="fa fa-play"></span>

                            </button>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="row" id="scoreProgress">
                <!-- progressbar -->
                <div class="col-xs-6">
                    <div id="progress">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-6">
                    <div id="lives" style="color:#fff;">
                        <i class="lives fa fa-heart-o" aria-hidden="true"></i>
                        <i class="lives fa fa-heart-o" aria-hidden="true"></i>
                        <i class="lives fa fa-heart-o" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script>
$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // This function is to convert first letter of suits into uppercase
    $.ucfirst = function(str) {

        var text = str;
        
        var parts = text.split(' '),
            len = parts.length,
            i, words = [];
        for (i = 0; i < len; i++) {
            var part = parts[i];
            var first = part[0].toUpperCase();
            var rest = part.substring(1, part.length);
            var word = first + rest;
            words.push(word);
        }

        return words.join(' ');
    };

    $('#higher-lower button').on('click', function(event){
        event.preventDefault();
        
        // specifies higher/lower button event
        buttonName = $(this).closest('button').attr('name');
        
        var currentCard = $('div#current-card div.hand div.card p').text();
        var cardSuit = $('div#current-card div.hand div').attr('class').split(' ')[1];
        var cardNo = parseInt($('input.noOfClicks').val()) + parseInt(1);
        
        $('input.noOfClicks').val(cardNo);
        console.log('data', buttonName, currentCard, cardSuit, cardNo); 
        
        $.ajax({
            type: 'POST',
            url: "{{ URL::route('dealcard') }}",
            data: {
                'guess': buttonName,
                'currentCard': currentCard,
                'suit': cardSuit,
                'cardno': cardNo,
                'cards': '<?php echo serialize($allCards);?>',
                'currentScore': $('input.score').val(),
                'lives': $('input.lives').val(),
            },
            success: function(data) {
                console.log('success', data);
                
                $('div#current-card div.hand div.card p').text(data.newCard.value);
                
                $('input.score').val(data.score);    
                // Progress calculation
                var progress = (data.score / 52) * 100 ; 
                 // Progressbar UI 
                $('div#progress .progress-bar').attr("aria-valuenow", progress); 
                $('div#progress .progress-bar').attr("style","width:"+progress+'%');
                console.log('data', data, progress);
                
                // If guess is correct display new card else remove lives
                if (data.isCorrectGuess) {
                    
                    $('div#current-card div.hand div').removeClass().addClass('card suit' + $.ucfirst(data.newCard.suit));
                    $('input.score').val(data.score);    
                } else {
                    $('input.lives').val(data.lives);
                }
                
                if (data.lives <= 0) {
                    //display game over and hide higher and lower button and display score and start again button
                    $('div#higher-lower').hide();
                    $('div#scoreProgress').hide();
                    $('div#gameOver p.score').text(data.score);
                    $('div#gameOver').show();
                    $('div#newgameDiv').show();
                }
            },
        });
    });
});
</script>
</html>
