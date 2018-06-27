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
namespace App\Game\CardDeck;

use App\Game\CardDeck\DeckInterface;

class Deck implements DeckInterface 
{
    public $deck;
    
    protected $cards; 
    const VALUE_ACE = 'A';
    const VALUE_TWO = '2';
    const VALUE_THREE = '3';
    const VALUE_FOUR = '4';
    const VALUE_FIVE = '5'; 
    const VALUE_SIX = '6';
    const VALUE_SEVEN = '7'; 
    const VALUE_EIGHT = '8'; 
    const VALUE_NINE = '9';
    const VALUE_TEN = '10';
    const VALUE_JACK = 'J'; 
    const VALUE_QUEEN = 'Q';
    const VALUE_KING = 'K';
    const SUIT_HEARTS = 'hearts'; 
    const SUIT_CLUBS = 'clubs';
    const SUIT_SPADES = 'spades';
    const SUIT_DIAMONDS = 'diamonds';
  
  
    protected static $suits = [
      self::SUIT_SPADES,
      self::SUIT_HEARTS,   
      self::SUIT_DIAMONDS,
      self::SUIT_CLUBS
    ];

    protected static $values = [
      self::VALUE_ACE,
      self::VALUE_TWO,
      self::VALUE_THREE,
      self::VALUE_FOUR,
      self::VALUE_FIVE,
      self::VALUE_SIX,
      self::VALUE_SEVEN,
      self::VALUE_EIGHT,
      self::VALUE_NINE,
      self::VALUE_TEN,
      self::VALUE_JACK,
      self::VALUE_QUEEN,
      self::VALUE_KING
    ];

    public function __construct() 
    {
        //$this->setDeck();
    } 
  
    /**
     * 
     * @param type $cardDeck
     * @return $this
     */
    public function setDeck($cardDeck) {
        $this->deck = $cardDeck;
        return $this;
    }
    
    /**
     * 
     * @return array
     */
    public function getDeck() 
    {
        return $this->deck;
    }
    
    /**
     * 
     * @return array
     */
    public static function getValues() 
    {
      return self::$values;
    }

    /**
     * 
     * @return array
     */
    public static function getSuits() 
    {
        return self::$suits;
    }

    /**
     * 
     * @return array
     */
    public function getCards() 
    {
        return $this->cards;
    }

    /**
     * 
     * @param type $cards
     * @return $this
     */
    public function setCards($cards) 
    {
        $this->cards = $cards;
        return $this;
    }
    
    /**
     * generate deck
     */
    public function generate()
    {
      foreach(self::getSuits() as $suit) {
        foreach(self::getValues() as $value) {
          $this->addCard($suit, $value);
        }
      }
    }
    
    /**
     * 
     * @param type $suit
     * @param type $card
     * @return $this
     */
    public function addCard($suit, $card) 
    {
      $this->cards[] = ['value' => $card, 'suit' => $suit];
      return $this;
    }

   
    /**
     * Shuffle cards
     * @return $this array
     */
    public function shuffle() 
    {
      shuffle($this->cards); 
      return $this;
    }

   
}

