<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Game\CardDeck\Deck;
use App\Game\Game;
use \Illuminate\Http\Request;

/**
 * Description of GameController
 *
 * @author sindh
 */
class GameController extends Controller
{
    protected $cards;
   
    public function index()
    {
       $deck = new Deck;
       $deck->setCards($this->getCardsFromApi());
       $deck->shuffle();

       $this->cards = $deck->getCards();
       
       return view('game', ['currentCard' => $this->cards[0], 'allCards' => $this->cards]);
    }
    
    /**
     * get Api response for cards
     * @return type
     */
    private function getCardsFromApi()
    {        
        $client = new \GuzzleHttp\Client();
        $res = $client->get(env('APP_URL').'api/cards');
        
        if ($res->getStatusCode() == 200) {
           return json_decode($res->getBody()); 
        }       
    }
    
    public function dealcard(Request $request)
    {
        $game = new Game;
        $game->setDeck(unserialize($request->post('cards')));
        $game->setCardValue($request->post('currentCard'));
        $correctGuess = $game->isCorrectGuess($request->post('guess'), $request->post('cardno'));

        if ($correctGuess) {
            $game->setScore($request->post('currentScore') + 1);
            $game->setLives($request->post('lives'));
        } else {
            $game->setScore($request->post('currentScore'));
            $game->setLives($request->post('lives') - 1);
        }
        
        if($request->post('cardno') +1 < 52) {
           $dealNewCard = $game->getDeck()[$request->post('cardno')];
        } 
        return ['isCorrectGuess' => $correctGuess, 
            'newCard' => $dealNewCard ?? null, 
            'score' => $game->getScore(),
            'lives' => $game->getLives()
            ];                 
    }
    
}
