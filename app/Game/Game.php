<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Deck
 *
 * @author A.Jain
 */
namespace App\Game;

use App\Game\Game;
use App\Game\CardDeck\Deck;

class Game 
{    
    /**
     * @var Deck
     */
    protected $deck; 

    protected $guess;
    
    protected $lives = 3;
   
    protected $score;
    
    /**
     * Set a deck for the game
     * 
     * @param Deck $deck
     * @return \Game
     */
    public function setDeck($deck)
    {
        $this->deck = $deck;

        return $this;
    }

    /**
     * Get the deck for this game
     * 
     * @return Game\CardDeck\Deck
     */
    public function getDeck()
    {
        return $this->deck;
    }
   
    /**
     * Set score for the game
     * 
     * @param score $score
     * @return \score
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get the score for this game
     * 
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }
    
     /**
     * Set lives for the game
     * 
     * @param $lives
     * @return int
     */
    public function setLives($lives)
    {
        $this->lives = $lives;

        return $this;
    }

    /**
     * Get the deck for this game
     * 
     * @return Game\CardDeck\Deck
     */
    public function getLives()
    {
        return $this->lives;
    }
    
    public function setCardValue($cardValue) 
    {
        $this->cardValue = $cardValue;
        return $this;
    }
    
    public function getCardValue()
    {
        return $this->cardValue;
    }
    
    public function isCorrectGuess($guess, $cardNo)
    {
        $compareValue = $this->getDeck()[$cardNo]->value;
        $cardValue = $this->cardValue;
        
        if (in_array($this->getDeck()[$cardNo]->value, ['A', 'J', 'Q', 'K'])) {
            $compareValue = $this->mapCardValues()[$this->getDeck()[$cardNo]->value];
        }
       
        if (in_array($cardValue, ['A', 'J', 'Q', 'K'])) {
            $cardValue = $this->mapCardValues()[$cardValue];
        }
        
        if ($guess == 'higher') {
            return $cardValue < $compareValue;
        } else {
            return $cardValue > $compareValue;
        }
    }
    
    // This is used to map texted cards such as defined in the array
    private function mapCardValues()
    {
        return ['A' => 1, 'J' => 11, 'Q' => 12, 'K' => 13];
    }
}