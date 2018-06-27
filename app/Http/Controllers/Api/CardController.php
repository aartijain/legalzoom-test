<?php

namespace App\Http\Controllers\Api;

use \Illuminate\Routing\Controller;
use App\Game\CardDeck\Deck;


class CardController extends Controller
{
    // Api call to get cards json
    public function index()
    {
        $deck = new Deck();
        //Generate api response for card deck
        $deck->generate();
        
        return response()->json($deck->getCards());
    }
       
}