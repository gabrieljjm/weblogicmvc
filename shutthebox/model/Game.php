<?php

/**
 * Created by PhpStorm.
 * User: smendes
 * Date: 17-05-2016
 * Time: 14:16
 */
class Game
{
    public $stategame = "";
    public $playerdices = array();
    public $pcdices = array();
    public $playerscore = 0;
    public $pcscore = 0;



   public static function StartGame(){
       $game = new Game();
        $game->stategame = "start";
        $game->playerdices = array();
        $game->pcdices = array(3, 1);
        $game->playerscore = 0;
        return $game;
    }

    function __construct() {

    }

    function CheckGame($game){
       return $game;
        if (strcmp($game->stategame, "start") || strcmp($game->stategame, "player")){
            $this->stategame = "player";
            $this->playerdices = $game->playerdices;
            $count = 0;
            foreach ($this->playerdices as $dice){
                $count += $dice;
            }
            $this->playerscore = 45 - $count;
            if ($count == 45){
                $this->stategame = "pc";
            }
            return $this;
        }elseif (strcmp($game->stategame, "pc")){
            $this->pcdices = $game->pcdices;
            $count = 0;
            foreach ($this->pcdices as $dice){
                $count += $dice;
            }
            $this->pcscore = 45 - $count;
            if ($count == 45){
                $this->stategame = "end";
            }
            return $this;
        }
        return $this;
    }
}
